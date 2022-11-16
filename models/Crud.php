<?php


include ("class_connect.php");

class Classcrud extends Conexao{
	//Atributos

	private $Crud;
	private $Contador;

	//Preparação de declativas

	public function preparedStatements($Query, $Parametros)
	{
		$this->countParametros($Parametros);
		$this->Crud=$this->connectDB()->prepare($Query);
		
		if($this->Contador > 0){
			for ($I=1; $I <= $this->Contador; $I++) { 
				$this->Crud->bindValue($I,$Parametros[$I-1]);
			}
		}

		$this->Crud->execute();

	}

	//Contador de parâmetros

	private function countParametros($Parametros)
	{
		$this->Contador=count($Parametros);
	}



	//Inserção no Banco de Dados

	public function insertDB($Tabela , $Condicao , $Parametros){
		$this->preparedStatements("insert into {$Tabela} values ({$Condicao})" , $Parametros);
		return $this->Crud;
	}



	//Seleção no Banco de Dados

	public function selectDB($Campos , $Tabela , $Condicao , $Parametros){
		$this->preparedStatements("select {$Campos} from {$Tabela} {$Condicao}" , $Parametros);
		return $this->Crud;
	}


	//Deletar dados no DB

	public function deleteDB($Tabela , $Condicao , $Parametros){
		$this->preparedStatements("delete from {$Tabela} where {$Condicao}" , $Parametros);
    	return $this->Crud;
	}

	//Atualizando o banco de dados
	public function updateDB($Tabela, $Set, $Condicao, $Parametros){
		$this->preparedStatements("update {$Tabela} set {$Set} where {$Condicao}",$Parametros);
		return $this->Crud;
	}

}

?>