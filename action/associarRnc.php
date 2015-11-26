<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

if($_POST)
{
	if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
	{


		$acao = base64_decode($_SESSION['acaoform']);

		switch($acao) {

			case 'cadastrar/Ocorrencia':

				$cadastro = new Cadastro();

				try {
					$cadastro->setDados($_POST);

					$cadastro->cadastrarAssociacaoRnc();

					$cadastro->finalizarApp('cadastrar/Ocorrencia', 'Cadastrado com sucesso !');

				} catch
				(Exception $e) {
					ClasseException::throwException($e, $_POST, 'cadastrar/Ocorrencia');
				}


			break;

			case 'alterar/Ocorrencia' :

				$alteracao = new Alteracao();

				try {
					$alteracao->setDados($_POST);

					$alteracao->alterarAssociacaoRnc();

					$alteracao->finalizarApp('alterar/Ocorrencia', 'Cadastrado com sucesso !');

				} catch
				(Exception $e) {
					ClasseException::throwException($e, $_POST, 'cadastrar/Ocorrencia');
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


