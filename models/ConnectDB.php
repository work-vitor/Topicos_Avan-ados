<?php

abstract class Conexao {

	//Realizará a conexão com o banco de dados
	protected  function connectDB(){

		try {
			$con= new PDO("mysql:host=localhost;dbname=controle_energia","root","");
			return $con;
		} catch (PDOException $Erro) {
			return $erro->getMessage();
		}

	}
}


?>