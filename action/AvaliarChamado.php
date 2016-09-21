<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

if($_POST)
{
	if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
	{


		$acao = base64_decode($_SESSION['acaoform']);

		switch ($acao)
		{
			case 'cadastrar/Avaliacao' :
				$cadastro = new Cadastro();

				try
				{
					$cadastro->setDados($_POST);

					$cadastro->cadastrarAvaliacao();

					$_SESSION['chamado'] = $cadastro->getDados('sol_codigo');

					$_SESSION['avaliacao'] = true;

					header('location: '.$_SERVER['HTTP_REFERER']);

				}catch (Exception $e)
				{
					ClasseException::throwException($e,$_POST,'cadastrar/Avaliacao');
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
