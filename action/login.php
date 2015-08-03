<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

if($_POST)
{
	try
	{
		$login = new Logar();

		$login->setDados($_POST);


		$login->fazerLogin();
		
		if($_SESSION['tac_codigo'] == 2)
		{
			header('location: /sga/Solicitante.php');
		}else
		{ 
			header('location: /sga/Operacao.php');
		}
		
	} catch (Exception $e)
	{
		$_SESSION['erro'] = $e->getMessage();

        sleep(2);

        header('location: '.$_SERVER['HTTP_REFERER']);
	}

}
else
{
	Sessao::destroiSessao();
}

?>
