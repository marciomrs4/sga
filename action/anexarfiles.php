<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

if($_POST)
{
	if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
	{


		$acao = base64_decode($_SESSION['acaoform']);

		switch ($acao)
		{
			case 'cadastrar/uploadfilesprojeto' :
				$cadastro = new Cadastro();

				try
				{
					$cadastro->setDados($_POST);

					$cadastro->cadastrarAnexoProjeto($_FILES);

					$_SESSION['acao'] = base64_encode('cadastrar/uploadfilesprojeto');
					$_SESSION['valor'] = $_POST['pro_codigo'];
					header('location: '.$_SERVER['HTTP_REFERER']);

				}catch (Exception $e)
				{
					ClasseException::throwException($e,$_POST,'cadastrar/uploadfilesprojeto');
				}
				break;

			case 'cadastrar/uploadfilesRNC' :

				$cadastro = new Cadastro();

				try
				{
					$cadastro->setDados($_POST);

					$cadastro->cadastrarAnexoRNC($_FILES);

					$_SESSION['acao'] = base64_encode('cadastrar/uploadfilesRNC');
					$_SESSION['valor'] = $_POST['nc_codigo'];
					header('location: '.$_SERVER['HTTP_REFERER']);

				}catch (Exception $e)
				{
					ClasseException::throwException($e,$_POST,'cadastrar/uploadfilesRNC');
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
