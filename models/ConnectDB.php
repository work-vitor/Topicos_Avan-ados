<?php

abstract class Conexao {

	//Realizará a conexão com o banco de dados
	protected  function connectDB(){
		// try {
			// $con= new PDO("mysql:host=localhost;dbname=controle_energia, port=3307","root","");
			// return $con;
			$host = 'localhost';
			$db   = 'controle_energia';
			$user = 'root';
			$pass = '';
			$port = "3307";
			$charset = 'utf8mb4';

			$options = [
				\PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
				\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
				\PDO::ATTR_EMULATE_PREPARES   => false,
			];
			$con = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
			try {
				$pdo = new \PDO($con, $user, $pass, $options);
				return $pdo;
			} catch (\PDOException $e) {
				throw new \PDOException($e->getMessage(), (int)$e->getCode());
			}
		// } catch (PDOException $erro) {
		// 	return $erro->getMessage();
		// }
	}
}


?>