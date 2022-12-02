<?php
    if(isset($_SESSION['type_user'])){
        echo "<script> alert('Acesso negado!');</script>";
        echo "<script> window.location.replace('../auth/login');</script>";
    } elseif($_SESSION['type_user'] != "admin"){
        echo "<script> alert('Acesso negado!');</script>";
        echo "<script> window.location.replace('../user/dashboard');</script>";
    }
?>

