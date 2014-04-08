<?php

abstract class Dados extends Banco
{
		
	protected $dados;

	
	public function validarPost($post)
	{
		if($post)
		{
			$this->setDados($post);
			$_SESSION['post'] = $post;

		}elseif($_SESSION['post'])
		{
			$this->setDados($_SESSION['post']);
		}
		
	}
	
	public function setDados($dados)
	{
		$this->dados = $dados;
	}
	
	public function getDados($dados)
	{
		return($this->dados[$dados]);
	}

	public function setValueGet($get,$getname)
	{
		foreach ($get as $chaves => $valor){break 1;}
		
		$this->dados[$getname] = $valor;
	}
	
	public function getValueGet($getname)
	{
		return(base64_decode($this->dados[$getname]));
	}
	
	#Metodo para fazer debug
	public function listarDados()
	{
		foreach ($this->dados as $campo => $valor)
		{
			echo("
					[ Campo:<font color='blue'> ( {$campo} )</font>  ] 
							- 
				  	[ Valor:<font color='red'> ( {$valor} )</font>  ]
				  <br />
				");
		}
	}

	#Metodo para facilitar obter os nomes dos campos
	public function criarCampos()
	{
		foreach ($this->dados as $campo => $valor)
		{
			echo('$this->dados[\''.$campo.'\']<br />');
		}
	}

	public function criarArray($dados)
	{
		$Array = explode(',', $dados);
		
		return($Array);
	}
	
	public function finalizarApp($session = null,$sucesso = null)
	{
		$_SESSION['mensagem'] = Texto::letterBlue($sucesso);
		unset($_SESSION[$session]);
		header('location: '.$_SERVER['HTTP_REFERER']);			
	}
	
}
?>