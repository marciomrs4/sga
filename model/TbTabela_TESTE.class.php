<?php

class TbTabela_TESTE extends Banco implements TbTabela
{
	
	private $tabela = 'tb_prioridade';
	
	public function insertUsuario(Usuario $dados)
	{
		
		foreach ($dados as $dado)
		{
			echo $dado.'<br />';
		}
		
	}
	
	public function insert($dados)
	{
		foreach ($dados as $dado)
		{
			echo $dado;
		}
		
	}

	public function select()
	{
		
	}

	public function getForm($codigo_id_tabela){}
	
	public function update($dados){}
	
}
?>