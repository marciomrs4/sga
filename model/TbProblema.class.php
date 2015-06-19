<?php

class TbProblema extends Banco
{

	private $tabela = 'tb_problema';
	
	private $pro_codigo = 'pro_codigo';
	private $pro_descricao = 'pro_descricao';
	private $dep_codigo = 'dep_codigo';
	private $pri_codigo = 'pri_codigo';
	private $pri_descricao = 'pri_descricao';
	private $pro_mostrar_usuario = 'pro_mostrar_usuario';
	private $pro_tempo_solucao = 'pro_tempo_solucao';
	private $pro_status_ativo = 'pro_status_ativo';
	
	
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
					($this->pro_descricao,$this->dep_codigo,$this->pri_codigo,
					$this->pro_mostrar_usuario, $this->pro_tempo_solucao,
					$this->pro_status_ativo)
					VALUES(?,?,?,?,?,?)");

		try{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->pro_descricao],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->dep_codigo],PDO::PARAM_INT);
			$stmt->bindParam(3,$dados[$this->pri_codigo],PDO::PARAM_INT);
			$stmt->bindParam(4,$dados[$this->pro_mostrar_usuario],PDO::PARAM_INT);
			$stmt->bindParam(5,$dados[$this->pro_tempo_solucao],PDO::PARAM_INT);						
			$stmt->bindParam(6,$dados[$this->pro_status_ativo],PDO::PARAM_INT);			
			
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
					    $this->dep_codigo = ?,
						$this->pro_mostrar_usuario = ?,
						$this->pro_tempo_solucao = ?,
						$this->pro_status_ativo = ?
					WHERE $this->pro_codigo = ? ");
		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->pro_descricao],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->pri_codigo],PDO::PARAM_INT);			
			$stmt->bindParam(3,$dados[$this->dep_codigo],PDO::PARAM_INT);						
			$stmt->bindParam(4,$dados[$this->pro_mostrar_usuario],PDO::PARAM_STR);			
			$stmt->bindParam(5,$dados[$this->pro_tempo_solucao],PDO::PARAM_STR);
			$stmt->bindParam(6,$dados[$this->pro_status_ativo],PDO::PARAM_STR);			
			$stmt->bindParam(7,$dados[$this->pro_codigo],PDO::PARAM_INT);						
			
			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}
	
	#Lista todos os problema por departamento na tela de cadastro de problema
	public function listarProblemaDepartamento($dep_codigo)
	{
		$query = ("SELECT pro.pro_codigo, pro.pro_descricao, 
						  dep.dep_descricao, pri.pri_descricao, pro_tempo_solucao,
						  IF(pro_mostrar_usuario = 1,'SIM','NУO'),
						  IF(pro_status_ativo = 1,'SIM','NУO') 
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
	
	#Usado nos formularios de cadastro de chamado e tela do Solicitante
	public function listarProblema($dep_codigo)
	{
		$query = ("SELECT pro_codigo, pro_descricao 
					FROM tb_problema 
					WHERE pro_mostrar_usuario = 1 
					AND pro_status_ativo = 1
					AND dep_codigo = ?
					ORDER BY pro_descricao");

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
	
	#Usado na tela de operaчуo para listagem dos problemas
	public function selectMeusProblemas($dep_codigo)
	{
		$query = ("SELECT pro_codigo, pro_descricao 
					FROM tb_problema 
					WHERE pro_mostrar_usuario = 1 
					AND pro_status_ativo = 1
					AND dep_codigo = ?
					ORDER BY pro_descricao");
		
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
	
	#Usado na tela de assentamento para a lista de chamado do tecnico.
	/**
	 * 
	 * @param unknown $dep_codigo
	 * @throws PDOException
	 * @return PDOStatement
	 * @example Esse metodo funciona assim:
	 */
	public function listarProblemasTecnicos($dep_codigo)
	{
		$query = ("SELECT pro_codigo as 'pro_codigo_tecnico', pro_descricao 
					FROM tb_problema 
					WHERE pro_status_ativo = 1
					AND dep_codigo = ?
					ORDER BY pro_descricao;");
	
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
	
}
?>