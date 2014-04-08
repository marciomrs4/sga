<?php

class TbVerPor extends Banco
{

	private $tabela = 'tb_sim_nao';

	public static function selectVerPor()
	{
		return array(1 => array(1,'Chamados que abri'),2 => array(2,'Chamados para minha equipe'),3 => array(3,'Chamados que estou atendendo'));
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