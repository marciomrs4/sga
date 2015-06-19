<?php
class TbApontamentoMelhoria extends Banco
{

	private $tabela = tb_apontamento_melhoria;
	
	private $apm_codigo = 'apm_codigo';
	private $apm_descricao = 'apm_descricao';
	private $usu_codigo = 'usu_codigo';
	private $apm_data = 'apm_data';
	private $som_codigo = 'som_codigo';
	private $stm_codigo = 'stm_codigo';
	

	public function insert($dados)
	{
		$query = ("INSERT INTO 
						tb_apontamento_melhoria (apm_descricao, usu_codigo, som_codigo, stm_codigo) 
					VALUES ( ?, ?, ?, ?)");
		
		try 
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$dados[$this->apm_descricao],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->usu_codigo],PDO::PARAM_INT);
			$stmt->bindParam(3,$dados[$this->som_codigo],PDO::PARAM_INT);
			$stmt->bindParam(4,$dados[$this->stm_codigo],PDO::PARAM_INT);			
									
			$stmt->execute();
			
			return $this->conexao->lastInsertId();
			
		} catch (Exception $e) 
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
		
	}
	
	public function update($dados)
	{
		$query = ("");
		
		try 
		{
			$stmt = $this->conexao->prepare($query);
			
			
			$stmt->execute();
			
			return($stmt);
			
			
		} catch (Exception $e) 
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
		
	}

	public function select()
	{
		$query = ("");
		
		try 
		{
			$stmt = $this->conexao->prepare($query);
			
			
			$stmt->execute();
			
			return($stmt);
			
			
		} catch (Exception $e) 
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
		
	}

	public function listarApontamentoMelhoria($som_codigo)
	{
		$query = ("SELECT apm_codigo, apm_descricao, 
						(SELECT stm_descricao FROM tb_status_melhoria AS STM WHERE STM.stm_codigo = APO.stm_codigo) as stm_codigo, 
						date_format(apm_data,'%d-%m-%Y %H:%i:%s') AS apm_data, USU.usu_email
					FROM tb_apontamento_melhoria AS APO
					INNER JOIN tb_usuario AS USU
					ON APO.usu_codigo = USU.usu_codigo
					WHERE som_codigo = ?;");
		
		try 
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$som_codigo,PDO::PARAM_INT);
			
			$stmt->execute();
			
			return($stmt);
			
			
		} catch (Exception $e) 
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
		
	}

	
	public function getForm($codigo)
	{
		$query = ("");
		
		try 
		{
			$stmt = $this->conexao->prepare($query);
			
			
			$stmt->execute();
			
			return($stmt);
			
			
		} catch (Exception $e) 
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
		
	}

		
}
?>