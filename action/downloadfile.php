<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

$tipo = $_GET['tipo'];
$codigo = $_GET['codigo'];
$file = $_GET['file'];

/*echo $tipo,'<br>';
echo $codigo,'<br>';
echo $file,'<br>';

echo '../files/'.DirectoryCreate::PROJETOS.$codigo.'/'.$file;

print_r($_GET);*/

function download($path,$file)
{
	header('Content-Description: File Transfer');
	header('Content-Disposition: attachment; filename="'.$file.'"');
	header('Content-Type: application/octet-stream');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: ' . filesize($path));
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Expires: 0');
// Envia o arquivo para o cliente
	readfile($path);
}

switch ($tipo)
{
	case 'projetos':

		$path = '../files/'.DirectoryCreate::PROJETOS.$codigo.'/'.$file;

		download($path,$file);

	break;

	case 'chamados':
	break;

	case 'rncs':

		$path = '../files/'.DirectoryCreate::RNC.$codigo.'/'.$file;

		download($path,$file);

	break;

	case 'melhorias':
	break;

	default:
	break;
}

?>
