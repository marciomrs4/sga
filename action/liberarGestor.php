<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
{



	$alterar = new Alteracao();
	$get = new Busca();

	try
	{
		$get->setValueGet($_GET,'nc_codigo');
		$dados['nc_codigo'] = $get->getValueGet('nc_codigo');

		$alterar->setDados($dados);

		$alterar->alterarLiberarRncGestor();

		//$alterar->finalizarApp('rnc','Cadastrado com sucesso !');

		$_SESSION['acao'] = base64_encode('alterar/rncVerificacao');
		$_SESSION['valor'] = $_POST['nc_codigo'];
		header('location: '.$_SERVER['HTTP_REFERER']);

	}catch (Exception $e)
	{
		ClasseException::throwException($e,$_POST,'rnc');
	}

}else
{
	Sessao::destroiSessao();
}



?>


