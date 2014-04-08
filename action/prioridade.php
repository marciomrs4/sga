<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');

if($_POST)
{
	if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
	{


		$acao = base64_decode($_SESSION['acaoform']);

		switch ($acao)
		{
			case 'cadastrar/MinhaPrioridade' :
				$cadastro = new Cadastro();

				try
				{
					$cadastro->setDados($_POST);

					$cadastro->cadastrarPrioridade();

					$cadastro->finalizarApp('cadastrar/MinhaPrioridade');

				}catch (Exception $e)
				{
					ClasseException::throwException($e,$_POST,'cadastrar/MinhaPrioridade');
				}
				break;

			case 'alterar/MinhaPrioridade' :
				$alteracao = new Alteracao();

				try
				{

					$alteracao->setDados($_POST);

					$alteracao->alterarPrioridade();

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
