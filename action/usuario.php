<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

if($_POST)
{
	if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
	{


		$acao = base64_decode($_SESSION['acaoform']);

		switch ($acao)
		{
			case 'cadastrar/usuario' :

				$cadastro = new Cadastro();

				try
				{
					$cadastro->setDados($_POST);

					$cadastro->cadastrarUsuario();

					$cadastro->finalizarApp('cadastrar/usuario');

				}catch (Exception $e)
				{
					ClasseException::throwException($e,$_POST,'cadastrar/usuario');
				}
				break;

			case 'alterar/usuario' :
				$alteracao = new Alteracao();

				try
				{

					$alteracao->setDados($_POST);

					$alteracao->alterarUsuario();

					$alteracao->finalizarApp();

				}catch (Exception $e)
				{
					ClasseException::throwException($e);
				}
				break;
					
			case 'alterar/SenhaUsuario':
				$alteracao = new Alteracao();

				try
				{
					$alteracao->setDados($_POST);

					$alteracao->alterarUsuarioSenha();

					$alteracao->finalizarApp();

				}catch (Exception $e)
				{
					ClasseException::throwException($e);
				}
				break;

			case 'cadastrar/MeuUsuario':
				$cadastro = new Cadastro();

				try
				{
					$cadastro->setDados($_POST);

					$cadastro->cadastrarUsuario();

					$cadastro->finalizarApp('cadastrar/usuario');

				}catch (Exception $e)
				{
					ClasseException::throwException($e,$_POST,'cadastrar/usuario');
				}
				break;
		
			case 'alterar/MinhaSenha':
				$alteracao = new Alteracao();

				try
				{
					$alteracao->setDados($_POST);

					$alteracao->alterarMinhaSenha();

					$alteracao->finalizarApp();

				}catch (Exception $e)
				{
					ClasseException::throwException($e);
				}
				break;
				
			case 'alterar/MeuPerfilCor':
				
					$alteracao = new Alteracao();

				try
				{
					$alteracao->setDados($_POST);
					
					//$alteracao->listarDados();
					$alteracao->alterarLayout($_SESSION['usu_codigo']);
					
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
