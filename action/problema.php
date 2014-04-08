<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');

if($_POST)
{
	if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
	{


		$acao = base64_decode($_SESSION['acaoform']);

		switch ($acao)
		{
			case 'cadastrar/MeuProblema' :
				$cadastro = new Cadastro();

				try
				{
					$cadastro->setDados($_POST);

					$cadastro->cadastrarProblema();

					$cadastro->finalizarApp('cadastrar/MeuProblema');

				}catch (Exception $e)
				{
					ClasseException::throwException($e,$_POST,'cadastrar/MeuProblema');
				}
				break;

			case 'alterar/MeuProblema' :
				$alteracao = new Alteracao();				

				try
				{

					$alteracao->setDados($_POST);

					$alteracao->alterarProblema();

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
