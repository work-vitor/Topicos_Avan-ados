<?php

include '../includes/variables.php';
include '../models/Crud.php';

$crud = new ClassCrud;
$date = date('Y/m/d');
//$date = date('Y/m/d H:i');

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
        "?,?,?,?,?",
        array(
            null,
            $Fetch['id'],
            0,
            0,
            null
        )
    );

    $crud->insertDB(
        "temperatura",
        "?,?,?,?",
        array(
            null,
            $Fetch['id'],
            0,
            null
        )
    );


    echo "<script> alert('Cadastrado com sucesso');</script>";
    echo "<script> window.location.replace('../views/auth/login.php');</script>";
} catch (Exception $e) {
    echo 'Exceção capturada: ',  $e->getMessage(), "\n";
}
