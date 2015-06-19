<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

if($_POST)
{
	if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
	{


		$acao = base64_decode($_SESSION['acaoform']);

		switch ($acao)
		{
			case 'cadastrar/Sistema' :
				$cadastro = new Cadastro();

				try
				{
					$cadastro->setDados($_POST);

					$cadastro->cadastrarSistema();

					$cadastro->finalizarApp('cadastrar/Sistema');

				}catch (Exception $e)
				{
					ClasseException::throwException($e,$_POST,'cadastrar/Sistema');
				}
				break;

			case 'alterar/Sistema' :
				$alteracao = new Alteracao();

				try
				{

					$alteracao->setDados($_POST);

					$alteracao->alterarSistema();

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
