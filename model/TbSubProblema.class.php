<?php

class TbSubProblema extends Banco
{

	private $tabela = 'tb_sub_problema';
	
	private $sup_codigo = 'sup_codigo';
	private $sup_descricao = 'sup_descricao';
	private $pro_codigo = 'pro_codigo';
	private $pri_codigo = 'pri_codigo';

	public function getProcodigoSubProblema($sup_codigo)
	{

			$query = ("SELECT $this->pro_codigo
						FROM $this->tabela
						WHERE $this->sup_codigo = ?");
			
		try 
		{
			$stmt = $this->conexao->prepare($query);
			$stmt->bindParam(1,$sup_codigo,PDO::PARAM_INT);
			$stmt->execute();
			$dados = $stmt->fetch();
			return($dados[0]);
			
		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}
	
	public function listarSubProblema($pro_codigo)
	{
		$query = ("SELECT $this->sup_codigo, $this->sup_descricao
					FROM $this->tabela 
						WHERE $this->pro_codigo = ?");
		
		try
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$pro_codigo,PDO::PARAM_INT);
			
			$stmt->execute();
			
			return($stmt);
			
			
		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
		
	}
	
	public function insert($dados)
	{
		
		$query = ("INSERT INTO $this->tabela 
					($this->pro_descricao,$this->dep_codigo)
					VALUES(?,?)");

		try{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->pro_descricao],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->dep_codigo],PDO::PARAM_INT);
			
			$stmt->execute();

			return($this->conexao->lastInsertId());

		}
		catch (PDOException $e)
		{
			throw new PDOException("Erro na tabela ". get_class($this)."-". $e->getMessage(),$e->getCode());
		}

	}

	public function update($dados)
	{
		$query = ("UPDATE $this->tabela
					SET	$this->pro_descricao = ?
					WHERE $this->pro_codigo = ? ");
		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->pro_descricao],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->pro_codigo],PDO::PARAM_STR);			
			
			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function getProblemas($pro_codigo)
	{
		$query = ("SELECT $this->pro_descricao
					FROM $this->tabela
					WHERE $this->pro_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$pro_codigo,PDO::PARAM_INT);
			
			$stmt->execute();

			$dados = $stmt->fetch();
			
			return($dados[0]);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getMessage());
		}
	}
	
	
	public function selectMeusSubProblemas($pro_codigo)
	{
		$query = ("SELECT $this->sup_codigo, $this->sup_descricao
					FROM $this->tabela
					WHERE $this->pro_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);
			$stmt->bindParam(1,$pro_codigo,PDO::PARAM_INT);
			
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
	

}
?>