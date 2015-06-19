<?php
class ValidarNavegador extends ClasseException
{
	private $navegador; 
	
	private $tipos = array("Chrome","Firefox","MSIE");
	private $encontrado;
	
	public function __construct()
	{
		$this->navegador = $_SERVER['HTTP_USER_AGENT'];
	}
	
	private function getNavegador()
	{
		$qtd = count($this->tipos);
		
		for($x=0;$x < count($qtd);$x++)
		{
			if(stripos($this->navegador,$this->tipos[$x]))
			{
				$this->encontrado = $this->tipos[$x];
			}
		}
	}
	
	public function fazRedirect()
	{
		$this->getNavegador();
		
		if($this->encontrado != "Chrome")
		{
			echo('<h3>O seu navegador nao é o CHROME! Utilize o navegador CHROME, ou contate o suporte para mais informaçoes.</h3>');
			die();
		}
	}
}
?>