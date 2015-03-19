<?php

class createTables extends Banco
{
	
	public $tabela = 'tb_solicitacao_melhoria';	
	
	public function createAtributos()
	{
		$stmt = $this->conexao->prepare("DESC $this->tabela");
		
		$stmt->execute();
		
		foreach($stmt->fetchAll() as $campo){
			$array[] = 'private $'.$campo['Field'] .' = "'.$campo['Field'].'"	;';
		}

		echo 'private $tabela = "'. $this->tabela . '";<br>';
		foreach ($array as $campo){
			echo $campo.'<br>';
		}
		
	}
	
	public function generateInsert()
	{
	
		$stmt = $this->conexao->prepare("DESC $this->tabela");
		
		$stmt->execute();
				
		foreach ($stmt->fetchAll() as $campo)
		{
			$array[] = $campo['Field'];
			$inter[] = '?'; 
		}
		
		$dados = implode(", ",$array);
		
		$inter = implode(", ", $inter);

		echo 'INSERT INTO <br>'. 
				$this->tabela . ' (' . $dados . ') <br>'.
			' VALUES ( '. $inter .')';
		
	}

	public function generateSelect()
	{
		$stmt = $this->conexao->prepare("DESC $this->tabela");
		
		$stmt->execute();
		
		foreach ($stmt->fetchAll() as $campo)
		{
			$array[] = $campo['Field'];
		}
		
		$dados = implode(", ",$array);
		
		echo 'SELECT  '. $dados .'
				<br>FROM ' . $this->tabela;
	}

	public function generateUpdate()
	{
		$stmt = $this->conexao->prepare("DESC $this->tabela");
	
		$stmt->execute();
	
		foreach($stmt->fetchAll() as $campo){
			$array[] = $campo['Field'];
		}
	
		foreach ($array as $campo){
			echo $campo.'<br>';
		}
	
	}
	
	public function generateAll()
	{
		echo 'Class $$$$ extends Banco
			  <br>{<br><br>';
		$this->createAtributos();
		echo '<br><br>';	

		echo 'public function insert()<br>
			  {<br>';
			$this->generateInsert();
		echo '<br>}<br><br>';
		$this->generateSelect();
		
		echo '<br><br>}';
	}
	
}
?>