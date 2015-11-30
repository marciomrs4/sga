<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

$tipo = $_GET['tipo'];
$codigo = $_GET['codigo'];
$file = $_GET['file'];

$LogUpload = new LogUpload();

function createlog($file,$codigo,$tipo)
{

	$dados['usuario'] = $_SESSION['usu_nome'].' '.$_SESSION['usu_sobrenome'];
	$dados['arquivo'] = $file;
	$dados['acao'] = 'Remover';
	$dados['tipo'] = $tipo;
	$dados['codigo'] = $codigo;


	$log = new LogUpload();

	try {

		$log->insert($dados);

	}catch (\PDOException $e){
		$_SESSION['erro'] = $e->getMessage();
	}

}

switch($tipo){

	case 'projetos':

		unlink(DirectoryCreate::PATH . DirectoryCreate::PROJETOS . $codigo . '/' . $file);

		$_SESSION['acao'] = base64_encode('cadastrar/uploadfilesprojeto');
		$_SESSION['valor'] = base64_encode($codigo);

		createlog($file,$codigo,'projetos');

		header('location: '.$_SERVER['HTTP_REFERER']);

	break;

	case 'chamados':


	break;

	case 'rncs':

		unlink(DirectoryCreate::PATH . DirectoryCreate::RNC . $codigo . '/' . $file);

		$_SESSION['acao'] = base64_encode('cadastrar/uploadfilesRNC');
		$_SESSION['valor'] = base64_encode($codigo);

		createlog($file,$codigo,'RNC');

		header('location: '.$_SERVER['HTTP_REFERER']);

	break;

	case 'melhorias':

		unlink(DirectoryCreate::PATH . DirectoryCreate::MELHORIA . $codigo . '/' . $file);

		$_SESSION['acao'] = base64_encode('cadastrar/uploadfilesMelhoria');
		$_SESSION['valor'] = base64_encode($codigo);

		createlog($file,$codigo,'MELHORIA');

		header('location: '.$_SERVER['HTTP_REFERER']);


		break;

	default:
		header('location: '.$_SERVER['HTTP_REFERER']);
	break;

}

?>
