<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

//resolve o problema de acentos
header('Content-Type: text/html; charset=ISO-8859-1');

$tbprioridade = new TbPrioridade();

$id = $_POST["codigo_departamento"];

foreach ($tbprioridade->selectPrioridadesDepartamento($id) as $linha):
	
	echo ('<option value='.$linha[0].'>'.$linha[1].'</option>');
	
endforeach;

?>