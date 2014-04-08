<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');


if($_GET)
{
	Sessao::criarAcaoForm($_GET,false);
	
	$busca = new Busca();
	$busca->setValueGet($_GET,'pro_codigo');
	

	if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
	{


		$acao = base64_decode($_SESSION['acaoform']);

		switch ($acao)
		{
			case 'aprovar/projeto' :

				$alteracao = new Alteracao();

				try
				{
					$alteracao->aprovarProjeto($busca->getValueGet('pro_codigo'));
					unset($_SESSION['acao']);
				    $alteracao->finalizarApp('aprovar/projeto');

				}catch (Exception $e)
				{
					ClasseException::throwException($e,$_POST,'aprovar/projeto');
				}
				break;
				
			case 'alterar/projeto' :
				$alteracao = new Alteracao();

				try
				{

					$alteracao->setDados($_POST);

					$alteracao->alterarProjeto();

					$alteracao->finalizarApp();

				}catch (Exception $e)
				{
					ClasseException::throwException($e);
				}
				break;
				

			default:
				Sessao::destroiSessao();
			break;
					
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
