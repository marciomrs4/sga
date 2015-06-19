<?php
class Usuario
{
	
	public $nome;
	public $email;
	public $idade;
	public $cpf;
	

	public function setCpf($cpf)
	{
		$this->cpf = $cpf;
	}

	
	public function setIdade($idade)
	{
		$this->idade = $idade;
	}

	public function getIdade()
	{
		return($this->idade);
	}
	
	public function validarIdade()
	{
		ValidarCampos::campoVazio($this->idade,'Idade');
	}
	
}
?>