<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');

if($_POST)
{
	if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
	{


		$acao = base64_decode($_SESSION['acaoform']);

		switch ($acao)
		{
			case 'cadastrar/Checklist' :
				
				$cadastro = new Cadastro();

				try
				{
					$cadastro->setDados($_POST);

					//$cadastro->criarCampos();
					$cadastro->cadastrarChecklist();

					$cadastro->finalizarApp('cadastrar/Checklist');

				}catch (Exception $e)
				{
					ClasseException::throwException($e,$_POST,'cadastrar/Checklist');
				}
				break;

			case 'alterar/Checklist' :
				
				$alteracao = new Alteracao();

				try
				{

					$alteracao->setDados($_POST);

					$alteracao->alterarChecklist();

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
