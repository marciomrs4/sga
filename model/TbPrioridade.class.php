<?php

class TbPrioridade extends Banco
{

	private $tabela = 'tb_prioridade';

	private $pri_codigo = 'pri_codigo';
	private $pri_descricao = 'pri_descricao';
	private $tat_codigo = 'tat_codigo';
	private $dep_codigo = 'dep_codigo';


	public function insert($dados)
	{


		$query = ("INSERT INTO $this->tabela 
					($this->pri_descricao, $this->tat_codigo, $this->dep_codigo)
					VALUES(?,?,?)");

		try{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->pri_descricao],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->tat_codigo],PDO::PARAM_INT);
			$stmt->bindParam(3,$dados[$this->dep_codigo],PDO::PARAM_INT);						

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
					SET	$this->pri_descricao = ?,
						$this->tat_codigo = ?,
						$this->dep_codigo = ?
					WHERE $this->pri_codigo = ? ");
		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->pri_descricao],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->tat_codigo],PDO::PARAM_INT);
			$stmt->bindParam(3,$dados[$this->dep_codigo],PDO::PARAM_INT);			
			$stmt->bindParam(4,$dados[$this->pri_codigo],PDO::PARAM_INT);						
				
			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	#Listar prioridade por Departamento, usado na tela de Cadastro de Problema
	public function selectPrioridadesDepartamento($dep_codigo)
	{
		$query = ("select pri_codigo, pri_descricao 
					from tb_prioridade where dep_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dep_codigo,PDO::PARAM_INT);
			
			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getMessage());
		}
	}
	
	
	public function selectMinhasPrioridades($dep_codigo)
	{
		$query = ("SELECT pri_codigo, pri_descricao, tat_descricao 
					FROM tb_prioridade AS a
					INNER JOIN tb_tempo_atendimento AS b
					ON a.tat_codigo = b.tat_codigo
					WHERE a.dep_codigo = ?
					ORDER BY a.pri_codigo
				 ");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dep_codigo,PDO::PARAM_INT);
			
			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getMessage());
		}
	}
	
	#Usado na tela de Prioridade, listar prioridade
	public function listarPrioridades($dep_codigo)
	{
		$query = ("SELECT PRI.pri_codigo, PRI.pri_descricao, TEM.tat_descricao, 
					    (SELECT dep_descricao FROM tb_departamento WHERE dep_codigo = PRI.dep_codigo) AS dep_descricao
					FROM tb_prioridade AS PRI
					INNER JOIN tb_tempo_atendimento AS TEM
					ON TEM.tat_codigo = PRI.tat_codigo
					INNER JOIN tb_departamento AS DEP
					WHERE PRI.dep_codigo LIKE ?
					GROUP BY pri_codigo
				  ");

		try
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->execute(array("%$dep_codigo%"));

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

	public function getForm($pri_codigo)
	{

		$query = ("SELECT * FROM  $this->tabela
				   WHERE $this->pri_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$pri_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetch());

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

}
?>