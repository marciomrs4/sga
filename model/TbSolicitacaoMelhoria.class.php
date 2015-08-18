<?php

class TbSolicitacaoMelhoria extends Banco
{

private $tabela = tb_solicitacao_melhoria;

private $som_codigo = 'som_codigo';
private $sis_codigo = 'sis_codigo';
private $som_descricao = 'som_descricao';
private $som_data_solicitacao = 'som_data_solicitacao';
private $usu_codigo_atendente = 'usu_codigo_atendente';
private $usu_codigo_solicitante = 'usu_codigo_solicitante';
private $stm_codigo = 'stm_codigo';


	public function insert($dados)
	{

		$query = ("INSERT INTO 
						tb_solicitacao_melhoria (sis_codigo, som_descricao, 
												 usu_codigo_solicitante, stm_codigo) 
					VALUES ( ?, ?, ?, ?)
				  ");

						try
						{
							$stmt = $this->conexao->prepare($query);

							$stmt->bindParam(1,$dados[$this->sis_codigo],PDO::PARAM_INT);
							$stmt->bindParam(2,$dados[$this->som_descricao],PDO::PARAM_STR);
							$stmt->bindParam(3,$dados[$this->usu_codigo_solicitante],PDO::PARAM_INT);
							$stmt->bindParam(4,$dados[$this->stm_codigo],PDO::PARAM_INT);

							$stmt->execute();

							return $this->conexao->lastInsertId();


						}catch (PDOException $e)
						{
							throw new PDOException("Erro na tabela ". get_class($this)."-". $e->getMessage(),$e->getCode());
						}

	}

	public function update($dados)
	{
		$query = ("UPDATE $this->tabela
					SET	$this->sis_codigo = ?,
						$this->som_descricao = ?
					WHERE $this->som_codigo = ? ");
					try
					{
						$stmt = $this->conexao->prepare($query);

						$stmt->bindParam(1,$dados[$this->sis_codigo],PDO::PARAM_INT);
						$stmt->bindParam(2,$dados[$this->som_descricao],PDO::PARAM_STR);
						$stmt->bindParam(3,$dados[$this->som_codigo],PDO::PARAM_INT);
							
						$stmt->execute();

						return($stmt);

					} catch (PDOException $e)
					{
						throw new PDOException("Erro em TbSolicitacao".$e->getMessage(),$e->getCode());
					}

	}
	
	#Atender Melhorias
	public function updateAtenderMelhoria($dados)
	{
		$query = ("UPDATE $this->tabela
					SET	$this->usu_codigo_atendente = ?,
					    $this->stm_codigo = ?
					WHERE $this->som_codigo = ? ");
		try
		{
			$stmt = $this->conexao->prepare($query);
	
			$stmt->bindParam(1,$dados[$this->usu_codigo_atendente],PDO::PARAM_INT);
			$stmt->bindParam(2,$dados[$this->stm_codigo],PDO::PARAM_INT);
			$stmt->bindParam(3,$dados[$this->som_codigo],PDO::PARAM_INT);			
				
			$stmt->execute();
	
			return($stmt);
	
		} catch (PDOException $e)
		{
			throw new PDOException("Erro em TbSolicitacao".$e->getMessage(),$e->getCode());
		}
	
	}

	#Usado para o formulario de alteracao da melhoria
	public function getForm($som_codigo)
	{

		$query = ("SELECT som_codigo, sis_codigo, som_descricao, 
						  som_data_solicitacao, usu_codigo_atendente, 
						  usu_codigo_solicitante, stm_codigo 
						FROM tb_solicitacao_melhoria
						WHERE som_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$som_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetch(PDO::FETCH_ASSOC));

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}
	
	#Usado na tela de listagem de melhoria
	public function listarMelhoria($dados)
	{
	
		$query = ("SELECT som_codigo, USU.usu_nome, date_format(som_data_solicitacao,'%d-%m-%Y %H:%i:%s') AS som_data_solicitacao, 
					   	  SIS.sis_descricao, STM.stm_descricao, som_descricao, USUARIO.usu_nome
						FROM tb_solicitacao_melhoria AS SOL
						INNER JOIN tb_sistemas AS SIS
						ON SOL.sis_codigo = SIS.sis_codigo
						INNER JOIN tb_usuario AS USU
						ON SOL.usu_codigo_solicitante = USU.usu_codigo
						LEFT JOIN tb_usuario AS USUARIO
						ON SOL.usu_codigo_atendente = USUARIO.usu_codigo
						INNER JOIN tb_status_melhoria AS STM
						ON SOL.stm_codigo = STM.stm_codigo
						WHERE (usu_codigo_solicitante = ?
						OR SIS.usu_codigo_usuario_chave = ?)
						AND SOL.sis_codigo LIKE ?
						AND SOL.stm_codigo  LIKE ?
						ORDER BY 1 DESC;");
	
		try
		{
			$stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$_SESSION['usu_codigo'],PDO::PARAM_INT);
            $stmt->bindParam(2,$_SESSION['usu_codigo'],PDO::PARAM_INT);
            $stmt->bindParam(3,$dados['sis_codigo'],PDO::PARAM_INT);
			$stmt->bindParam(4,$dados['stm_codigo'],PDO::PARAM_INT);
	
			$stmt->execute();
	
			return($stmt);
	
		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	
	}

	
	public function getUsuarioAtendente($som_codigo)
	{
		
		$query = ("SELECT usu_codigo_atendente
					FROM $this->tabela
					WHERE som_codigo = ? ");
		
		try {
			
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$som_codigo,PDO::PARAM_INT);
			
			$stmt->execute();
			
			$dados = $stmt->fetch(PDO::FETCH_ASSOC);
			
			return $dados['usu_codigo_atendente'];
			
		} catch (PDOException $e) {
			throw new PDOException($e->getMessage(), $e->getCode());
		}
		
	}
	
	public function getUsuarioSolicitante($som_codigo)
	{
	
		$query = ("SELECT usu_codigo_solicitante
				FROM $this->tabela
				WHERE som_codigo = ? ");
	
				try {
					
				$stmt = $this->conexao->prepare($query);
					
				$stmt->bindParam(1,$som_codigo,PDO::PARAM_INT);
					
				$stmt->execute();
					
				$dados = $stmt->fetch(PDO::FETCH_ASSOC);
					
				return $dados['usu_codigo_solicitante'];
					
		} catch (PDOException $e) {
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	
	}
	
	#Atualiza Status da melhorias
	public function updateStatusMelhoria($dados)
	{
	
		$query = ("UPDATE $this->tabela
					SET	$this->stm_codigo = ?,
						$this->usu_codigo_atendente = ?
					WHERE $this->som_codigo = ? ");
			try
			{
				$stmt = $this->conexao->prepare($query);
	
				$stmt->bindParam(1,$dados[$this->stm_codigo],PDO::PARAM_INT);
				$stmt->bindParam(2,$_SESSION['usu_codigo'],PDO::PARAM_INT);
				$stmt->bindParam(3,$dados[$this->som_codigo],PDO::PARAM_INT);

				
				$stmt->execute();
	
			return($stmt);
	
		} catch (PDOException $e)
		{
			throw new PDOException("Erro em TbSolicitacao".$e->getMessage(),$e->getCode());
		}
	
	}
	
	
	#Obtem o status atual da melhoria
	public function getStatusMelhoria($som_codigo)
	{
	
		$query = ("SELECT $this->stm_codigo
				FROM $this->tabela
				WHERE som_codigo = ? ");
	
				try {
					
				$stmt = $this->conexao->prepare($query);
					
				$stmt->bindParam(1,$som_codigo,PDO::PARAM_INT);
					
				$stmt->execute();
					
				$dados = $stmt->fetch(PDO::FETCH_ASSOC);
					
				return $dados['stm_codigo'];
					
				} catch (PDOException $e) {
				throw new PDOException($e->getMessage(), $e->getCode());
				}
	
	}
	
}
?>