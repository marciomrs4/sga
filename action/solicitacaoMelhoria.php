<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

//sleep(3);

if($_POST)
{
	if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
	{


		$acao = base64_decode($_SESSION['acaoform']);

		switch ($acao)
		{
			case 'cadastrar/SolicitacaoMelhoria' :

				$cadastro = new Cadastro();

				try
				{
					$cadastro->setDados($_POST);	
					
					$cadastro->cadastrarSolicitacaoMelhoria();
					
					$cadastro->finalizarApp('cadastrar/SolicitacaoMelhoria');

				}catch (Exception $e)
				{
					ClasseException::throwException($e,$_POST,'cadastrar/SolicitacaoMelhoria');
				}
				break;

			case 'alterar/SolicitacaoMelhoria' :
				$alteracao = new Alteracao();

				try
				{

					$alteracao->setDados($_POST);

					$alteracao->alterarSolicitacaoMelhoria();

					$alteracao->finalizarApp();

				}catch (Exception $e)
				{
					ClasseException::throwException($e);
				}
				break;

			case 'alterar/Solicitacao' :
				$alteracao = new Alteracao();

				try
				{

					$alteracao->setDados($_POST);

					$alteracao->alterarSolicitacao($_FILES['arquivo']);
					//$alteracao->listarDados();
					$alteracao->finalizarApp('','Atualizado com sucesso!');

				}catch (Exception $e)
				{
					ClasseException::throwException($e);
				}
				break;

			case 'cadastrar/SolicitacaoTecnico' :

				$cadastro = new Cadastro();

				try
				{
					$cadastro->setDados($_POST);	
					
					//$cadastro->listarDados();
					
					$cadastro->cadastrarSolicitacaoTecnico(null,$_FILES['arquivo']);
					
					$cadastro->finalizarApp('cadastrar/SolicitacaoTecnico');

				}catch (Exception $e)
				{
					ClasseException::throwException($e,$_POST,'cadastrar/SolicitacaoTecnico');
				}
				
				break;

			case 'alterar/AprovarSolicitacao' :
				$alteracao = new Alteracao();

				try
				{

					$alteracao->setDados($_POST);

					$alteracao->alterarAprovarSolicitacao($_SESSION['usu_codigo']);

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

