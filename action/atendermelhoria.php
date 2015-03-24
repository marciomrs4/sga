<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');


if($_GET)
{
	Sessao::criarAcaoForm($_GET,false);
	
	$busca = new Busca();
	$busca->setValueGet($_GET,'som_codigo');

	echo $busca->getValueGet('som_codigo');
	
 	#Teste pra ver se aparecer o codigo
	//echo $busca->getValueGet('sol_codigo');
	
	if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
	{

		$acao = base64_decode($_SESSION['acaoform']);

		switch ($acao)
		{
			case 'atender/melhoria' :

				$alteracao = new Alteracao();

				try
				{
					$alteracao->alterarAtenderSolicitacaoMelhoria($busca->getValueGet('som_codigo'));
					
					//Serviu para apagar a ação
					unset($_SESSION['acao']);
				    
					$alteracao->finalizarApp('atender/melhoria');

				}catch (Exception $e)
				{
					$_SESSION['acaoform'] = base64_encode('alterar/SolicitacaoMelhoria');
					
					ClasseException::throwException($e,$_POST,'alterar/SolicitacaoMelhoria');
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
