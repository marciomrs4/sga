<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

if($_POST)
{
	if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
	{


		$acao = base64_decode($_SESSION['acaoform']);

		switch ($acao)
		{
			case 'cadastrar/Apontamento' :
				$cadastro = new Cadastro();

				try
				{
					$cadastro->setDados($_POST);

					$cadastro->cadastrarApontamento();

					$cadastro->finalizarApp('cadastrar/Apontamento');

				}catch (Exception $e)
				{
					ClasseException::throwException($e,$_POST,'cadastrar/Apontamento');
				}
				break;

			case 'alterar/Apontamento' :
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
