<?php

    include '../includes/variables.php';
    include '../models/Crud.php';

    $crud = new ClassCrud;

    try {
        $crud->insertDB(
            "users",
            "?,?,?,?,?",
            array(
                $id,
                $name,
                $email,
                $password,
                $role
            )
        );
        echo "<script> alert('Cadastrado com sucesso');</script>";

    } catch (Exception $e) {
        echo 'Exceção capturada: ',  $e->getMessage(), "\n";
    }
    

?>