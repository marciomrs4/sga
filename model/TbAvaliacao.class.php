<?php

class TbAvaliacao extends Banco
{


	public function insert($dados)
	{

		$query = ("INSERT INTO $this->tabela 
				 ($this->ace_usuario,$this->ace_senha,$this->usu_codigo)
					VALUES(?,?,?)");

		try{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->ace_usuario],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->ace_senha],PDO::PARAM_STR);
			$stmt->bindParam(3,$dados[$this->usu_codigo],PDO::PARAM_INT);
						
			$stmt->execute();

			return($this->conexao->lastInsertId());

		}
		catch (PDOException $e)
		{
			throw new PDOException("Erro na tabela". get_class($this)."-". $e->getMessage(),$e->getCode());
		}

	}

	public function listAvaliacao()
	{
		$query = ("SELECT id, descricao
					FROM avaliacao
					WHERE status = 1");

		try{
			$stmt = $this->conexao->prepare($query);

			$stmt->execute();

			return($stmt);
		}
		catch (PDOException $e)
		{
			throw new PDOException("Erro na tabela". get_class($this)."-". $e->getMessage(),$e->getCode());
		}

	}

	
}
?>