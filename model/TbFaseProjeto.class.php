<?php
class TbFaseProjeto extends Banco
{

	private $tabela = 'tb_fase_projeto';

	private $fas_codigo = 'fas_codigo';
	private $pro_codigo = 'pro_codigo';
	private $fas_descricao = 'fas_descricao';


	public function insert($dados)
	{
		$query = ("INSERT INTO $this->tabela
					($this->fas_descricao, $this->pro_codigo)
					VALUES(?, ?)");

		try{

			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->fas_descricao],\PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->pro_codigo],\PDO::PARAM_INT);

			$stmt->execute();

			return $stmt;

		}catch (\PDOException $e){
			throw new \PDOException($e->getMessage(), $e->getCode());
		}

	}
	
	public function update($dados)
	{
		$query = ("UPDATE $this->tabela
					SET $this->fas_descricao = ?
					WHERE $this->fas_codigo = ?
				  ");

		try{

			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->fas_descricao],\PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->fas_codigo],\PDO::PARAM_INT);

			$stmt->execute();

			return $stmt;

		}catch (\PDOException $e){
			throw new \PDOException($e->getMessage(), $e->getCode());
		}
	}

	public function select(){}
	
	public function getForm($fas_codigo)
	{
		$query = ("SELECT $this->fas_descricao,
						  $this->fas_codigo,
						  $this->pro_codigo
					FROM $this->tabela
					WHERE $this->fas_codigo = ?");

		try{

			$stmt = $this->conexao->prepare($query);
			$stmt->bindParam(1,$fas_codigo,\PDO::PARAM_INT);

			$stmt->execute();

			return $stmt->fetch(\PDO::FETCH_ASSOC);

		}catch (\PDOException $e){
			throw new \PDOException($e->getMessage(), $e->getCode());
		}

	}

	public function findByProjeto($pro_codigo)
	{
		$query = ("SELECT $this->fas_codigo, $this->fas_descricao
					FROM $this->tabela
					WHERE $this->pro_codigo = ?");

		try{

			$stmt = $this->conexao->prepare($query);
			$stmt->bindParam(1,$pro_codigo,\PDO::PARAM_INT);

			$stmt->execute();

			return $stmt;//->fetchAll();

		}catch (\PDOException $e){
			throw new \PDOException($e->getMessage(), $e->getCode());
		}

	}

	public function listFaseByProjeto($pro_codigo)
	{
		$query = ("SELECT $this->fas_codigo, $this->fas_descricao
					FROM $this->tabela
					WHERE $this->pro_codigo = ?");

		try{

			$stmt = $this->conexao->prepare($query);
			$stmt->bindParam(1,$pro_codigo,\PDO::PARAM_INT);

			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);

		}catch (\PDOException $e){
			throw new \PDOException($e->getMessage(), $e->getCode());
		}

	}
}
?>