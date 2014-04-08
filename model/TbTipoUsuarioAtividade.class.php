<?php

class TbTipoUsuarioAtividade extends Banco
{
	
	private $tabela = 'tb_tipo_usuario_atividade';
	
	public function insert($dados)
	{
		
		$query =  "desc tb_prioridade";
		
		$stmt = $this->conexao->prepare($query);
		
		$stmt->execute();
		
		return($stmt);
		
	}

	public function listar()
	{
		$query = ("SELECT tua_codigo, tua_descricao 
					FROM tb_tipo_usuario_atividade
				  ");
		
		try 
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->execute();
			
			return($stmt);
			
		} catch (PDOException $e) 
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
		
	}
	
	
	public function select($colum, $param = null)
	{
		
	}

	public function getForm($codigo_id_tabela){}
	
	public function update($dados){}
	
}
?>