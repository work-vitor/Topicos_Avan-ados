<?php

        //Tratamento de dados
        if (isset($_POST['email']) && isset($_POST['password'])) {
            if(empty($_POST['email']) || empty($_POST['password'])){
                echo "<script> alert('Dados incompletos');</script>";
                echo "<script> window.location.replace('../frontend/views/register_user.html');</script>";
            }else{
                $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_SPECIAL_CHARS);
                $password = md5(filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS));
            }
        }
