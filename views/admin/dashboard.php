<?php
    include("../../models/Crud.php");
    session_start();
    /*if(isset($_SESSION['type_user'])){
        echo "<script> alert('Acesso negado!');</script>";
        echo "<script> window.location.replace('../auth/login.php');</script>";
    } elseif($_SESSION['type_user'] != "admin"){
        echo "<script> alert('Acesso negado!');</script>";
        echo "<script> window.location.replace('../user/dashboard.php');</script>";
    }*/
    $crud = new ClassCrud();
    $BFetch = $crud->selectDB("u.*, ce.*", "users u", "INNER JOIN consume_energy ce on ce.user_id=u.id", array());

    
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
              <a class="nav-link dropdown-toggle" href="#" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Olá, Adm</a>
                <div class="dropdown-menu" style="right: 0; left: auto;">
                  <a class="dropdown-item" href="#">Meu perfil</a>
                  <a class="dropdown-item" href="../../controller/destroy_session.php">Sair</a>
                </div>    
            </div>
        </nav>
        <div>
        </div>
        <br>
        <?php while($Fetch=$BFetch->fetch(PDO::FETCH_ASSOC)){ ?>

          <div class="container">
              <div class="row">
                <div class="col">
                  <b>Nome completo: <?php echo $Fetch['name'];?></b>
                </div>
                <div class="col">
                  Crédito restante: <?php echo $Fetch['credits'];?>
                </div>
                <div class="col">
                  Consumo mensal: <?php echo $Fetch['consume'];?>
                </div>
                <div class="col">
                  <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#modalCredito" id="btn-click" onClick="valor(this.value);" value="<?php echo $Fetch['user_id'];?>" >Adicionar créditos</button>
              </div>
              </div>
            </div>
            <br>
          
          <?php } ?>

        <div class="modal fade" id="modalCredito" tabindex="-1" role="dialog" aria-labelledby="modalCredito" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalCredito">Créditos</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <span>Informe o valor a ser adicionado</span>
                    <form action="">
                        <input type="hidden" name="envio_id" value="">
                        <input type="text" name="credit" id="creditInput" placeholder="R$ 0,00" value="">
                    </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                  <button type="button" class="btn btn-success">Salvar mudanças</button>
                </div>
              </div>
            </div>
          </div>

      <script>
        function valor(teste){
          document.querySelector("[name='envio_id']").value = teste;
        }
      </script>
        
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>

<style>
    a {
        color: white;
    }


    .row {
        border-style: groove;
        border-radius: 2px;
        padding: 20px;

    }
</style>