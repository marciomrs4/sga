<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

if($_POST)
{
	if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
	{


		$acao = base64_decode($_SESSION['acaoform']);

		switch ($acao)
		{
			case 'cadastrar/FaseProjeto' :
				$cadastro = new Cadastro();

				try
				{
					$cadastro->setDados($_POST);

					//$cadastro->listarDados();

					$cadastro->cadastrarFaseProjeto();

					//$cadastro->finalizarApp('cadastrar/Sistema');

					unset($_SESSION['cadastrar/Sistema']);

					$_SESSION['acao'] = base64_encode('alterar/Projeto');
					$_SESSION['valor'] = $_POST['pro_codigo'];
					header('location: '.$_SERVER['HTTP_REFERER']);

				}catch (Exception $e)
				{
					ClasseException::throwException($e,$_POST,'cadastrar/Sistema');
				}
				break;

			case 'alterar/FaseProjeto' :
				$alteracao = new Alteracao();

				try
				{

					$alteracao->setDados($_POST);

					$alteracao->alterarFaseProjeto();

					$_SESSION['acao'] = base64_encode('alterar/Projeto');
					$_SESSION['valorform'] = base64_encode($_POST['pro_codigo']);
					header('location: '.$_SERVER['HTTP_REFERER']);

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
