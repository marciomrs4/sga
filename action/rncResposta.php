<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

if($_POST)
{
	if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
	{



				$cadastro = new Cadastro();

				try
				{
					$cadastro->setDados($_POST);
                                        
					$cadastro->cadastrarRespostaRnc();

					$cadastro->finalizarApp('rncGestor','Cadastrado com sucesso !');

				}catch (Exception $e)
				{
					ClasseException::throwException($e,$_POST,'rncGestor');
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


