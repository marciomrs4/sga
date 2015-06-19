<?php
class TbApontamento extends Banco
{

	private $tabela = 'tb_apontamento';
	
	private $ap_codigo = 'ap_codigo';
	private $ap_descricao = 'ap_descricao';
	private $ap_data_criacao = 'ap_data_criacao';
	private $at_codigo = 'at_codigo';
	private $usu_codigo = 'usu_codigo';

	public function insert($dados)
	{
		$query = ("INSERT INTO $this->tabela 
					($this->ap_descricao,$this->at_codigo, $this->usu_codigo)
                    VALUE(?,?,?)");
		
		try 
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$dados[$this->ap_descricao],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->at_codigo],PDO::PARAM_INT);
			$stmt->bindParam(3,$dados[$this->usu_codigo],PDO::PARAM_INT);
									
			$stmt->execute();
			
			$this->ap_codigo = $this->conexao->lastInsertId();
			
			return($this->ap_codigo);
			
			
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

	public function listarApontamento($at_codigo)
	{
		$query = ("SELECT $this->ap_codigo, $this->ap_descricao as Descricao, date_format($this->ap_data_criacao,'%d/%m/%Y %H:%i:%s') as 'Data', 
							(SELECT concat(usu_nome,' ',usu_sobrenome)
								FROM tb_usuario 
								WHERE ATI.usu_codigo = $this->usu_codigo) as 'Usuario'
					FROM $this->tabela AS ATI
					WHERE $this->at_codigo = ?
					ORDER BY $this->ap_data_criacao DESC
				  ");
		
		try 
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$at_codigo,PDO::PARAM_INT);
			
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