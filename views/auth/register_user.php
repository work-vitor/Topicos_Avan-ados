<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

        <div class="container">
            <div class="form--user__icon">
                <div class="icon--img">
                    <span class="glyphicon glyphicon-pencil"></span>
                </div>
            </div>
            <br>
            <h3 class="text-center">Cadastro</h3>
            <form action="../../controller/createUserController.php" method="POST">
                <div class="form-group">
                    <label for="name"> <span class="glyphicon glyphicon-user"></span> Nome:</label>
                    <input type="name" class="form-control" id="name" placeholder="Nome completo" name="name">
                </div>
                <div class="form-group">
                    <label for="email"> <span class="glyphicon glyphicon-envelope"></span> Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email">
                </div>
                <div class="form-group">
                    <label for="password"> <span class="glyphicon glyphicon-lock"></span> Senha:</label>
                    <input type="password" class="form-control" id="password" placeholder="Senha" name="password">
                </div>
                <div class="form-group">
                    <label for="password"> <span class="glyphicon glyphicon-lock"></span> Confirme a senha:</label>
                    <input type="password" class="form-control" id="confirm_password" placeholder="Confirme a senha" name="confirm_password">
                </div>
                <div></div>
                <button type="submit" class="btn btn-default">Criar conta</button>
            </form>
        </div>
    </body>
</html>

<script>
    var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("As senhas n??o coincidem");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>

<style>
    body {
        background: ghostwhite;
        position: relative;
        height: 100vh;
    }
    
    .form--user__icon span{
        font-size: 32px;
        position: absolute !important;
        top: 50% !important;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .container {
        width: 20%;
        margin: 0 auto;
        background: ghostwhite;
        border-radius: 4px;
        position: absolute;
        top: 50%;
        z-index: 2;
        color: black;
        content: '';
        padding: 20px;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    
    
    .form--user__icon {
        border-radius: 50%;
        height: 100px;
        z-index: 9;
        top: -50px;
        text-align: center;
        left: 50%;
        transform: translate(-50%, 0);
        position: absolute;
        background: darkslategrey;
        width: 100px;
        color: #fff;
    }
    
    button {
        width: 100%;
        color:white !important;
        border-radius: 50px !important;
        border: 0 !important;
        background: black !important;
    }
    
    .container h4 {
        margin-top: 32px;
    }
    form a{
        color: black;
        text-decoration:underline !important;
    }
</style>
