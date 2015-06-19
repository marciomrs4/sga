<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');


if($_POST)
{
	
	if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
	{

		try
		{
		
		$cadastro = new Cadastro();		
		
		$cadastro->setDados($_POST);
		
		//$cadastro->listarDados();
		
		$cadastro->cadastrarExecutarChecklist();
			
		$cadastro->finalizarApp();
		
		
		}catch (Exception $e)
		{
			ClasseException::throwException($e);
		}
					
	}else
	{
		Sessao::destroiSessao();
	}
}else
{
	Sessao::destroiSessao();
}

?>
