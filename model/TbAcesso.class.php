<?php

class TbAcesso extends Banco implements TbTabela
{

	private $tabela = 'tb_acesso';

	private $ace_codigo = 'ace_codigo';
	private $ace_usuario = 'ace_usuario';
	private $ace_senha = 'ace_senha';
	private $usu_codigo = 'usu_codigo';


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

	public function alterarMinhaSenha($dados)
	{
		$query = ("UPDATE $this->tabela 
					  SET $this->ace_senha = ?
					WHERE $this->ace_codigo = ? 
				  ");
		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->ace_senha],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->ace_codigo],PDO::PARAM_INT);
						
			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}
	
	public function update($dados)
	{
		$query = ("UPDATE $this->tabela 
					  SET $this->ace_usuario = ?,
					      $this->ace_senha = ?
					WHERE $this->ace_codigo = ? 
				  ");
		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->ace_usuario],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->ace_senha],PDO::PARAM_STR);
			$stmt->bindParam(3,$dados[$this->ace_codigo],PDO::PARAM_INT);
						
			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function confirmarUsuario($dados)
	{
		$query = ("SELECT $this->ace_codigo, $this->ace_usuario, $this->usu_codigo
    				FROM $this->tabela
    				WHERE $this->ace_usuario = ? AND $this->ace_senha = ? 
    			  ");

		try
		{
			$stmt = $this->conexao->prepare($query);
				
			$stmt->bindParam(1,$dados[$this->ace_usuario]);
			$stmt->bindParam(2,$dados[$this->ace_senha]);
				
			$stmt->execute();
				
			return($stmt->rowCount());

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getMessage());
		}
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
			throw new PDOException($e->getMessage(),$e->getMessage());
		}
	}

	public function getAcesso($dados)
	{
		$query = ("SELECT $this->ace_codigo, $this->ace_usuario, $this->usu_codigo
    				FROM $this->tabela
    				WHERE $this->ace_usuario = ? 
    				AND $this->ace_senha = ? 
    			  ");

		try
		{
			$stmt = $this->conexao->prepare($query);
				
			$stmt->bindParam(1,$dados[$this->ace_usuario]);
			$stmt->bindParam(2,$dados[$this->ace_senha]);
				
			$stmt->execute();
				
			return($stmt->fetch());

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getMessage());
		}
	}

	public function getForm($usu_codigo)
	{

		$query = ("SELECT $this->ace_codigo, $this->ace_usuario 
					FROM  $this->tabela
				   	WHERE $this->usu_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$usu_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetch());

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function validaLoginAcesso($ace_usuario)
	{
		
		$query = ("SELECT $this->ace_codigo 
					FROM $this->tabela
    				WHERE $this->ace_usuario = ?");
		
		try 
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$ace_usuario,PDO::PARAM_STR);
			
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