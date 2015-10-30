<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

//resolve o problema de acentos
header('Content-Type: text/html; charset=ISO-8859-1');

$tbFaseProjeto = new TbFaseProjeto();

$id = $_POST["pro_codigo"];

echo ('<option value="">Nenhuma</option>');

foreach ($tbFaseProjeto->listFaseByProjeto($id) as $linha):
	
	echo ('<option value='.$linha['fas_codigo'].'>'.$linha['fas_descricao'].'</option>');
	
endforeach;

?>