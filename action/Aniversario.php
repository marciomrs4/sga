<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

if($_POST)
{
	if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
	{


		$acao = base64_decode($_SESSION['acaoform']);

		switch ($acao)
		{
			case 'cadastrar/Aniversario' :
				
				$cadastro = new Cadastro();

				try
				{
					$cadastro->setDados($_POST);

					$cadastro->cadastrarAniversario();

					$cadastro->finalizarApp('cadastrar/Aniversario');

				}catch (Exception $e)
				{
					ClasseException::throwException($e,$_POST,'cadastrar/Aniversario');
				}
				break;

			case 'alterar/Aniversario' :
				$alteracao = new Alteracao();				

				try
				{

					$alteracao->setDados($_POST);
	
					$alteracao->alterarAniversario();

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
