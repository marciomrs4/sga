<?php

class TbProblema extends Banco
{

	private $tabela = 'tb_problema';
	
	private $pro_codigo = 'pro_codigo';
	private $pro_descricao = 'pro_descricao';
	private $dep_codigo = 'dep_codigo';
	private $pri_codigo = 'pri_codigo';
	private $pri_descricao = 'pri_descricao';
	
	public function getProblemaDescricao($pro_codigo)
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
			
		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}
	
	public function insert($dados)
	{
		
		$query = ("INSERT INTO $this->tabela 
					($this->pro_descricao,$this->dep_codigo,$this->pri_codigo)
					VALUES(?,?,?)");

		try{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->pro_descricao],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->dep_codigo],PDO::PARAM_INT);
			$stmt->bindParam(3,$dados[$this->pri_codigo],PDO::PARAM_INT);
			
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
					SET	$this->pro_descricao = ?,
					    $this->pri_codigo = ?, 
					    $this->dep_codigo = ?
					WHERE $this->pro_codigo = ? ");
		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->pro_descricao],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->pri_codigo],PDO::PARAM_INT);			
			$stmt->bindParam(3,$dados[$this->dep_codigo],PDO::PARAM_INT);						
			$stmt->bindParam(4,$dados[$this->pro_codigo],PDO::PARAM_INT);			
			
			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}
	
	#Seleciona problema por departamento, tela de problema
	public function listarProblemaDepartamento($dep_codigo)
	{
		$query = ("SELECT pro.pro_codigo, pro.pro_descricao, 
						  dep.dep_descricao, pri.pri_descricao 
					FROM tb_problema AS pro
					INNER JOIN tb_departamento AS dep
					ON pro.dep_codigo = dep.dep_codigo
					INNER JOIN tb_prioridade AS pri
					ON pri.pri_codigo = pro.pri_codigo
					WHERE dep.dep_codigo LIKE ?
					ORDER BY dep.dep_codigo, pro.pro_descricao");

		try
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->execute(array("{$dep_codigo}"));
			
			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getMessage());
		}
	}
	
	public function listarProblema($dep_codigo)
	{
		$query = ("SELECT pb.pro_codigo, pb.pro_descricao, pr.pri_descricao
					FROM $this->tabela AS pb
					JOIN tb_prioridade AS pr
					ON pr.pri_codigo = pb.pri_codigo
					WHERE pb.dep_codigo = ?
					ORDER BY pb.pro_descricao");

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
	
	
	public function selectMeusProblemas($dep_codigo)
	{
		$query = ("SELECT pb.pro_codigo, pb.pro_descricao, pr.pri_descricao
					FROM $this->tabela AS pb
					JOIN tb_prioridade AS pr
					ON pr.pri_codigo = pb.pri_codigo
					WHERE pb.dep_codigo = ?
					ORDER BY pb.pro_descricao");
		
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
	
	public function getForm($pro_codigo)
	{

		$query = ("SELECT * 
					FROM  $this->tabela 
				   	WHERE $this->pro_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$pro_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetch());

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	#Verifica qual a prioridade do problema, e retorna
	public function getPrioridade($pro_codigo)
	{
		$query = ("SELECT $this->pri_codigo FROM $this->tabela
					WHERE $this->pro_codigo = ? ");

		try
		{
			$stmt = $this->conexao->prepare($query);
				
			$stmt->bindParam(1,$pro_codigo,PDO::PARAM_INT);
				
			$stmt->execute();
				
			$dados = $stmt->fetch();
				
			return($dados[0]);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}
	
	#Listagem de problema para tela de buscar chamado em Operaчуo
	public function listarTodosProblema()
	{
		$query = ("SELECT pro_codigo, pro_descricao 
					FROM tb_problema
					ORDER BY pro_descricao
				  ");

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