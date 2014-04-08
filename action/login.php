<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');

if($_POST)
{
	try
	{
		$login = new Logar();

		$login->setDados($_POST);


		$login->fazerLogin();
		
		if($_SESSION['tac_codigo'] == 2)
		{
			header('location: /SGA/Solicitante.php');
		}else
		{ 
			header('location: /SGA/Operacao.php');
		}
		
	} catch (Exception $e)
	{
		$_SESSION['erro'] = $e->getMessage();
		header('location: '.$_SERVER['HTTP_REFERER']);
	}

}
else
{
	Sessao::destroiSessao();
}

?>
