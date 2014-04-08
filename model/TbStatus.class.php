<?php

class TbStatus extends Banco
{

	private $tabela = 'tb_status';

	private $sta_codigo = 'sta_codigo';
	private $sta_descricao = 'sta_descricao';
	private $dep_codigo = 'dep_codigo';

	public function insert($dados)
	{

		$query = ("INSERT INTO $this->tabela
					($this->sta_descricao)
					VALUES(?)");

		try{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->sta_descricao],PDO::PARAM_STR);

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
					SET	$this->sta_descricao = ?
					WHERE $this->sta_codigo = ? ");
		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->sta_descricao],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->sta_codigo],PDO::PARAM_INT);
				
			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function selectStatus()
	{
		$query = ("SELECT * FROM  $this->tabela");

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

	public function selectStatusNaoAberto()
	{
		$query = ("SELECT * FROM  $this->tabela WHERE sta_codigo NOT IN (1)");

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

	public function selectMeuStatus()
	{
		$query = ("SELECT $this->sta_codigo,$this->sta_descricao
					FROM $this->tabela");

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

	public function getForm($sta_codigo)
	{

		$query = ("SELECT $this->sta_codigo, $this->sta_descricao
					FROM  $this->tabela 
				   WHERE $this->sta_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$sta_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetch());

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}
	
	public function getDescricao($sta_codigo)
	{

		$query = ("SELECT $this->sta_descricao
					FROM  $this->tabela 
				   WHERE $this->sta_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$sta_codigo,PDO::PARAM_INT);

			$stmt->execute();
			
			$dados = $stmt->fetch();
			
			return($dados[0]);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}


}
?>