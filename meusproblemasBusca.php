<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');

//resolve o problema de acentos
header('Content-Type: text/html; charset=ISO-8859-1');

$tbproblema = new TbProblema();

$id = $_POST["dep_codigo"];

	echo ('<option value="">TODOS</option>');
foreach ($tbproblema->selectMeusProblemas($id) as $linha):

	echo ('<option value='.$linha[0].'>'.$linha[1].'</option>');
	
endforeach;

?>