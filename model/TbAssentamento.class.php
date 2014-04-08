<?php
class TbAssentamento extends Banco
{

	private $tabela = 'tb_assentamento';
	
	private $ass_codigo = 'ass_codigo';
	private $ass_descricao = 'ass_descricao';
	private $ass_data_cadastro = 'ass_data_cadastro';
	private $sol_codigo = 'sol_codigo';
	private $usu_codigo = 'usu_codigo';
		
	#Insere um Assentamento
	public function insert($dados)
	{
		$query = ("INSERT INTO $this->tabela
					($this->ass_descricao, $this->sol_codigo, $this->usu_codigo)
					VALUES(?,?,?)");
		
		try 
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$dados[$this->ass_descricao],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->sol_codigo],PDO::PARAM_INT);
			$stmt->bindParam(3,$dados[$this->usu_codigo],PDO::PARAM_INT);			
			
			$stmt->execute();
			
			return($stmt);
			
		} catch (PDOException $e) 
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
		
		
	}
	
	#Metodo que lista os assentamentos das solicitações
	public function listarAssentamento($sol_codigo)
	{
	
		$query = ("SELECT ass_codigo, ass_descricao, date_format(ass_data_cadastro,'%d-%m-%Y %H:%i:%s'), b.usu_email
					FROM tb_assentamento AS a
					INNER JOIN tb_usuario AS b
					ON a.usu_codigo = b.usu_codigo
					WHERE $this->sol_codigo = ?
					ORDER BY ass_codigo");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$sol_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
		
	}
	
	public function update($dados)
	{
		
	}

	public function select()
	{
		
	}
	
	public function getForm($ass_codigo)
	{
		$query = ("SELECT * FROM $this->tabela
					WHERE $this->ass_codigo = ?");
		
		try 
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$ass_codigo,PDO::PARAM_INT);
			
			$stmt->execute();
			
			$dados = $stmt->fetch();
			
			return($dados);
			
			
		} catch (PDOException $e) 
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
		
	}


	public function alterarDescricao($dados)
	{
		
	}
	
}
?>