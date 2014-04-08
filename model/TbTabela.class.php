<?php
interface TbTabela
{
	
	public function insert($dados);
	
	public function update($dados);

	public function select();
	
	public function getForm($codigo);

		
}
?>