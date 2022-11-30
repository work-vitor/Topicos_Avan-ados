<?php

    include '../includes/loginVariables.php';
    include '../models/Crud.php';

    $crud = new ClassCrud;

    try {
        $BFetch=$crud->selectDB("*","users","where email=?",array($_POST['email']));
        
        $Fetch=$BFetch->fetch(PDO::FETCH_ASSOC);
        if($Fetch == null){
            echo "<script> alert('Email incorreto, por favor verifique');</script>";
            echo "<script> window.location.replace('../frontend/views/login.html');</script>";
        }
        
        $db_email=$Fetch['email'];
        $db_password=$Fetch['password'];
        // var_dump($password);
        // var_dump($db_password);
        if($db_password != $password){
            echo "<script> alert('Senha incorreta, por favor verifique');</script>";
            echo "<script> window.location.replace('../frontend/views/login.html');</script>";
        } else {
            if($Fetch['role'] == "admin"){
                echo "<script> alert('Login realizado com sucesso!');</script>";
                echo "<script> window.location.replace('../frontend/views/admin/dashboard.html');</script>";
            }else{
                echo "<script> alert('Login realizado com sucesso!');</script>";
                echo "<script> window.location.replace('../frontend/views/user/dashboard.html');</script>";
            }
            
        }
    } catch (Exception $e) {
        echo 'Exceção capturada: ',  'Login incorreto, verifique as informações', "\n";
        echo "<script> window.location.replace('../frontend/views/login.html');</script>";
    }
    

?>