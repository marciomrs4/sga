<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

if($_POST)
{
	if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
	{


		$acao = base64_decode($_SESSION['acaoform']);

		switch ($acao)
		{
			case 'cadastrar/ApontamentoMelhoria' :
				$cadastro = new Cadastro();

				try
				{
					$cadastro->setDados($_POST);
						
					$cadastro->cadastrarApontamentoMelhoria();

					$cadastro->finalizarApp('cadastrar/Assentamento');

				}catch (Exception $e)
				{
					ClasseException::throwException($e,$_POST,'cadastrar/Assentamento');
				}
				break;

			case 'cadastrar/AssentamentoSolicitante' :
				$cadastro = new Cadastro();

				try
				{
					$cadastro->setDados($_POST);
						
					$cadastro->cadastrarAssentamentoSolicitante();

					$cadastro->finalizarApp('cadastrar/AssentamentoSolicitante');

				}catch (Exception $e)
				{
					ClasseException::throwException($e,$_POST,'cadastrar/AssentamentoSolicitante');
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
