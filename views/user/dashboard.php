<?php
include("../../models/Crud.php");
session_start();
if (!isset($_SESSION['type_user'])) {
  echo "<script> alert('Acesso negado!');</script>";
  echo "<script> window.location.replace('../auth/login.php');</script>";
}

//DADOS DO USUÁRIO
$crud = new ClassCrud();
$BFetch = $crud->selectDB("u.*, ce.*", "users u", "INNER JOIN consume_energy ce on ce.user_id=u.id where u.id=?", array($_SESSION['id_user']));
$Fetch = $BFetch->fetch(PDO::FETCH_ASSOC);

//Temperatura
$BFetchT = $crud->selectDB("*", "temperatura", "where user_id=?", array($_SESSION['id_user']));
$FetchT = $BFetchT->fetch(PDO::FETCH_ASSOC);


//RELATORIO
if (isset($_POST['dateIn'])) {
  $dateI1 = ' 00:00:00';
  $dateF1 = ' 23:59:59';
  $dateI = $_POST['dateIn'] . $dateI1;
  $dateF = $_POST['dateF'] . $dateF1;

  //Relatorio
  $soma = 0;
  $BFetch1 = $crud->selectDB("*", "consume_energy", "where dateTime >= ? and dateTime <= ? and user_id=?", array($dateI, $dateF, $Fetch['user_id']));
  while ($Fetch1 = $BFetch1->fetch(PDO::FETCH_ASSOC)) {
    $soma += $Fetch1['consume'];
  }
}

?>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

  <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <a class="navbar-brand" href="#">CONTROLE DE ENERGIA</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample03">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">PÁGINA INICIAL<span class="sr-only">(current)</span></a>
        </li>
      </ul>
      <a class="nav-link dropdown-toggle" href="#" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Olá, <?php echo $Fetch['name']; ?> </a>
      <div class="dropdown-menu" style="right: 0; left: auto;">
        <a class="dropdown-item" href="../../controller/destroy_session.php">Sair</a>
      </div>
    </div>
  </nav>

  <?php

  ?>
  <div class="container">
    <div class="form-group">
      <h3 class="text-center">Seus dados</h3>
      <span>Nome: <?php echo $Fetch['name']; ?></span><br>
      <span>Saldo atual: <?php echo $Fetch['credits']; ?> </span> <br>
      <span>Temperatura atual:  <?php echo $FetchT['temperatura']; ?> ºC</span> <br>

      <?php
      if (isset($_POST['dateIn'])) {
        echo "<span>Seu consumo de energia:" . $soma . " KHM</span>";
      }

      ?>


      <div class="col">

      </div>
    </div>
    <div class="d-flex justify-content-center">
      <button type="button" class="btn btn-dark " data-toggle="modal" data-target="#modalCredito" id="btn-click">Relatório</button>
    </div>
  </div>

  <div class="modal fade" id="modalCredito" tabindex="-1" role="dialog" aria-labelledby="modalCredito" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCredito">Relatório</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="../../views/user/relatorio.php" method="POST">
        <div class="modal-body">
          <span>Informe o período a ser verificado</span><br><br>
            <label>Início</label>
            <input type="date" name="dateIn" id="dateIn" value=""><br>
            <label>Fim:  </label>
            <input type="date" name="dateF" id="dateF" value="">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
          <button step="0.01" class="btn btn-success" id="freshR">Gerar Relatório</button>
          </form>
        </div>
      </div>
    </div>
  </div>



  <div class="modal fade" id="modalResultado" tabindex="-1" role="dialog" aria-labelledby="modalResultado" aria-hidden="true">

  </div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


</body>

</html>

<style>
  a {
    color: white;
  }

  .container {
    width: 20%;
    margin: 0 auto;
    background: white;
    position: absolute;
    top: 50%;
    z-index: 2;
    color: black;
    content: '';
    padding: 20px;
    left: 50%;
    transform: translate(-50%, -50%);
  }

  .form-group {
    border-style: groove;
    border-radius: 4px;
    padding: 20px;

  }
</style>