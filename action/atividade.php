<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

if($_POST)
{
	if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
	{


		$acao = base64_decode($_SESSION['acaoform']);

		switch ($acao)
		{
			case 'cadastrar/Atividade' :

				$cadastro = new Cadastro();

				try
				{
					$cadastro->setDados($_POST);

					$cadastro->cadastrarAtividade();

					$cadastro->finalizarApp('cadastrar/Atividade');

				}catch (Exception $e)
				{
					ClasseException::throwException($e,$_POST,'cadastrar/Atividade');
				}
				break;

			case 'alterar/Atividade' :
				
				$alteracao = new Alteracao();

				try
				{

					$alteracao->setDados($_POST);

					//$alteracao->listarDados();

					$alteracao->alterarAtividade();

					$alteracao->finalizarApp();

				}catch (Exception $e)
				{
					ClasseException::throwException($e);
				}
				break;
					
			case 'cadastrar/UsuarioAtividade':
				
				$cadastro = new Cadastro();

				try
				{
					$cadastro->setDados($_POST);

					$cadastro->cadastrarUsuarioAtividade();
					
					$_SESSION['acao'] = base64_encode('cadastrar/UsuarioAtividade');
					
					$cadastro->finalizarApp('','Usuario Cadastrado com sucesso!');

					
				}catch (Exception $e)
				{
					ClasseException::throwException($e,$_POST,'cadastrar/UsuarioAtividade');
				}
				break;
				
			case 'alterar/UsuarioAtividade':
				
				$alterar = new Alteracao();

				try
				{
					$alterar->setDados($_POST);

					$alterar->alterarUsuarioAtividade();


					$alterar->finalizarApp('','Alterado com sucesso!');

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
