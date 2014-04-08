<?php

class TbSimNao extends Banco
{

	private $tabela = 'tb_sim_nao';

	public static function selectSimNao()
	{
		return array(1 => array(1,'SIM'),2 => array(2,'NÃO'));
	}

	public static function selectOkErro()
	{
		return array(1 => array(1,'OK'),2 => array(2,'ERRO'));
	}
	
	public function select()
	{
		$query = ("SELECT * FROM $this->tabela");
		
		try 
		{

			$stmt = $this->conexao->prepare($query);
			$stmt->execute();
			return($stmt);
			
		} catch (PDOException $e) 
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}

}
?>