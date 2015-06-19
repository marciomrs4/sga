<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');


if($_GET)
{
	Sessao::criarAcaoForm($_GET,false);
	
	$busca = new Busca();
	$busca->setValueGet($_GET,'sol_codigo');
	
	#Teste pra ver se aparecer o codigo
	//echo $busca->getValueGet('sol_codigo');
	
	if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
	{

		$acao = base64_decode($_SESSION['acaoform']);

		switch ($acao)
		{
			case 'atender/chamado' :

				$alteracao = new Alteracao();

				try
				{
					$alteracao->alterarAtenderChamado($busca->getValueGet('sol_codigo'));
					
					//Serviu para apagar a ação
					unset($_SESSION['acao']);
				    
					$alteracao->finalizarApp('atender/chamado');

				}catch (Exception $e)
				{
					$_SESSION['acaoform'] = base64_encode('alterar/Solicitacao');
					
					ClasseException::throwException($e,$_POST,'alterar/Solicitacao');
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
