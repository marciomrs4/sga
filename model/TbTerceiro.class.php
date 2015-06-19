<?php

class TbTerceiro extends Banco
{

	private $tabela = 'tb_terceiro';
	private $ter_codigo = 'ter_codigo';
	private $dep_codigo = 'dep_codigo';
	private $ter_descricao = 'ter_descricao';
	private $ter_status = 'ter_status';
	
	
	public function insert($dados)
	{
		$query = ("INSERT INTO 
						tb_terceiro (dep_codigo, ter_descricao, ter_status) 
						VALUES ( ?, ?, ?)");
	
		try {
			
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1, $dados[$this->dep_codigo], PDO::PARAM_INT);
			$stmt->bindParam(2, $dados[$this->ter_descricao], PDO::PARAM_STR);
			$stmt->bindParam(3, $dados[$this->ter_status], PDO::PARAM_STR);
			
			$stmt->execute();
			
			$this->conexao->lastInsertId();
			
		} catch (PDOException $e) {
			throw new PDOException($e->getMessage(), $e->getCode());
		}
		
		
	}
	
	
	public function update($dados)
	{
		$query = ("UPDATE $this->tabela
					SET $this->dep_codigo = ?,
						$this->ter_descricao = ?,
						$this->ter_status = ?
					WHERE $this->ter_codigo = ?
				");
		
		try {
			
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1, $dados[$this->dep_codigo], PDO::PARAM_INT);
			$stmt->bindParam(2, $dados[$this->ter_descricao], PDO::PARAM_STR);
			$stmt->bindParam(3, $dados[$this->ter_status], PDO::PARAM_STR);
			$stmt->bindParam(4, $dados[$this->ter_codigo], PDO::PARAM_INT);
			
			$stmt->execute();
			
			return $stmt;
			
		} catch (PDOException $e) {
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}
	
	#Usado na tela de cadastro de terceiro para listar por departamento
	public function listarCadastro($dep_codigo)
	{
	
		$query = ("SELECT ter_codigo, 
						DEP.dep_descricao, ter_descricao, 
						  (CASE WHEN ter_status = 1 THEN 'ATIVO' ELSE 'INATIVO' END) as ter_status 
					FROM tb_terceiro AS TER
					INNER JOIN tb_departamento DEP
					ON TER.dep_codigo = DEP.dep_codigo
					WHERE TER.dep_codigo LIKE ?");
		
		try {
			
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1, $dep_codigo, PDO::PARAM_INT);
			
			$stmt->execute();
			
			return $stmt;
			
		} catch (PDOException $e) {
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	
	}
	
	#Usado para carregar o formulario de alteracao
	public function getForm($ter_codigo)
	{
	
		$query = ("SELECT ter_codigo, dep_codigo, ter_descricao, ter_status
					FROM tb_terceiro
					WHERE $this->ter_codigo = ?");
	
		try {
				
			$stmt = $this->conexao->prepare($query);
				
			$stmt->bindParam(1, $ter_codigo, PDO::PARAM_INT);
				
			$stmt->execute();
				
			return $stmt->fetch(PDO::FETCH_ASSOC);
				
		} catch (PDOException $e) {
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	
	}
	
	#Usado para listar no formulario de envio para terceiro
	public function listarTerceiroPorDepartamento($dep_codigo)
	{
	
		$query = ("SELECT ter_codigo, ter_descricao
					FROM tb_terceiro
					WHERE $this->dep_codigo = ?");
	
		try {
	
			$stmt = $this->conexao->prepare($query);
	
			$stmt->bindParam(1, $dep_codigo, PDO::PARAM_INT);
	
			$stmt->execute();
	
			return $stmt;
	
		} catch (PDOException $e) {
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	
	}
	
	public function select()
	{
	
		$query = ("SELECT ter_codigo, dep_codigo, ter_descricao, ter_status FROM tb_terceiro");
	
	}

}
?>