<?php

class TbStatusMelhoria extends Banco
{

	private $tabela = tb_status_melhoria;

	private $stm_codigo = stm_codigo;
	private $stm_descricao = stm_descricao;

	public function insert($dados)
	{

		$query = ("INSERT INTO 
					tb_status_melhoria (stm_descricao) 
					VALUES (?)");

		try{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->stm_descricao],PDO::PARAM_STR);

			$stmt->execute();

			return($this->conexao->lastInsertId());

		}
		catch (PDOException $e)
		{
			throw new PDOException("Erro na tabela". get_class($this)."-". $e->getMessage(),$e->getCode());
		}

	}

	/**
	 * Usado na listagem de status da tela de pesquisa de melhorias
	 * @throws PDOException
	 * @return PDOStatement
	 */
	public function listarStatus()
	{
	
		$query = ("SELECT stm_codigo, stm_descricao 
					FROM tb_status_melhoria");
	
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
	
	
	/**
	 * Usado na listagem de status do formulario de apontamento
	 * @throws PDOException
	 * @return PDOStatement
	 */
	public function listarStatusSemPendente()
	{
	
		$query = ("SELECT stm_codigo, stm_descricao
						FROM tb_status_melhoria
					WHERE stm_codigo NOT IN (1)");
	
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
	
	
	/**
	 * Usado na listagem de status do formulario de apontamento
	 * @throws PDOException
	 * @return PDOStatement
	 */
	public function getDescricao($stm_codigo)
	{
	
		$query = ("SELECT stm_descricao
						FROM tb_status_melhoria
					WHERE stm_codigo = ?");
	
		try{
	
			$stmt = $this->conexao->prepare($query);
	
			$stmt->bindParam(1, $stm_codigo,PDO::PARAM_INT);
			
			$stmt->execute();
			
			return $stmt->fetch(PDO::FETCH_ASSOC);

	
		}
		catch (PDOException $e)
		{
			throw new PDOException("Erro na tabela". get_class($this)."-". $e->getMessage(),$e->getCode());
		}
	
	}
	
}
?>