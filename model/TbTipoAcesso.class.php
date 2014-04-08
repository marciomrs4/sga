<?php

class TbTipoAcesso extends Banco
{

	private $tabela = 'tb_tipo_acesso';
	
	
	public function insert($dados)
	{
		
		
		$query = ("INSERT INTO $this->tabela ()
					VALUES(?)");

		try{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->pes_codigo],PDO::PARAM_INT);

			$stmt->execute();

			return($this->conexao->lastInsertId());

		}
		catch (PDOException $e)
		{
			throw new PDOException("Erro na tabela". get_class($this)."-". $e->getMessage(),$e->getCode());
		}

	}

	public function update($dados)
	{
		$query = ("UPDATE $this->tabela
					SET	$this-> = ?,

					WHERE $this-> = ? ");
		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->apf_nome],PDO::PARAM_STR);
			
			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function select($colum,$param)
	{
		$query = (" ");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getMessage());
		}
	}
	
	public function getForm($codigo)
	{

		$query = ("SELECT * FROM  $this->tabela 
				   WHERE $this-> = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetch());

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function listarMeusAcessos()
	{
		$query = ("SELECT * FROM $this->tabela
					WHERE tac_codigo 
					BETWEEN  2 AND 4
				 ");
		
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
	
	
	public function listarAcessos()
	{
		$query = ("SELECT * FROM tb_tipo_acesso 
					WHERE tac_codigo != 1
				 ");
		
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