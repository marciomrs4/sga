<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');
if($_POST)
{
	if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
	{
		$acao = base64_decode($_SESSION['acaoform']);

		switch ($acao)
		{
			case 'cadastrar/Versao' :
				$cadastro = new Cadastro();

				try
				{
					$cadastro->setDados($_POST);

					//$cadastro->listarDados();

					$cadastro->cadastrarVersao();

					$cadastro->finalizarApp('versao','Cadastrado com sucesso !');

					//header('location: ../ControleVersao.php');

				}catch (Exception $e)
				{
					ClasseException::throwException($e,$_POST,'versao');
				}
				break;

			case 'alterar/AlterarVersao' :
				$alteracao = new Alteracao();

				try
				{
					$alteracao->setDados($_POST);

					$alteracao->alterarVersao();

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
