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
        $BFetch = $crud->selectDB("*", "users", "where email=?", array($email));
        $Fetch = $BFetch->fetch(PDO::FETCH_ASSOC);
        $crud->insertDB(
            "consume_energy",
            "?,?,?,?",
            array(
                null,
                $Fetch['id'],
                0,
                0
            )
        );


        echo "<script> alert('Cadastrado com sucesso');</script>";
        echo "<script> window.location.replace('../views/auth/login.php');</script>";

    } catch (Exception $e) {
        echo 'Exceção capturada: ',  $e->getMessage(), "\n";
    }
    

?>