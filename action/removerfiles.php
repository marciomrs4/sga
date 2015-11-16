<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

$tipo = $_GET['tipo'];
$codigo = $_GET['codigo'];
$file = $_GET['file'];

$LogUpload = new LogUpload();

function createlog($file,$codigo)
{

	$dados['usuario'] = $_SESSION['usu_nome'].' '.$_SESSION['usu_sobrenome'];
	$dados['arquivo'] = $file;
	$dados['acao'] = 'Remover';
	$dados['tipo'] = 'Projetos';
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

		createlog($file,$codigo);

		header('location: '.$_SERVER['HTTP_REFERER']);

	break;

	case 'chamados':


	break;

	case 'rncs':

	break;

	case 'melhorias':

	break;

	default:
		header('location: '.$_SERVER['HTTP_REFERER']);
	break;

}

?>
