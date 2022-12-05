<?php

include '../models/Crud.php';
$id_user = $_POST['envio_id'];
$numero = $_POST['credit'];
$form = str_replace(['.',','],'.', $numero); 

$crud = new ClassCrud;

try {
    $crud->updateDB("consume_energy", "credits = credits + ?", "user_id=?", array($form, $id_user));


    echo "<script> alert('Cadastrado com sucesso');</script>";
    echo "<script> window.location.replace('../views/admin/dashboard.php');</script>";

} catch (Exception $e) {
    echo 'Exceção capturada: ',  $e->getMessage(), "\n";
}


//UPDATE `consume_energy` SET `credits`= `credits` + 1 WHERE `id` = 1