<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');


$tbanexo = new TbAnexo();

$busca = new Busca();

$busca->setValueGet($_GET,'id');

$dados = $tbanexo->select($busca->getValueGet('id'));

/*
$dados['ane_anexo']
$dados['ane_tipo']
$dados['ane_nome']
$dados['ane_tamanho']
*/

$tipo = $dados['ane_tipo'];

header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");

header ("Cache-Control: no-cache, must-revalidate");

header ("Pragma: no-cache");

header ("Content-Disposition: attachment; filename=\"{$dados['ane_nome']}\"" );

header ("Content-Description: PHP Generated Data" );

header("Content-type: $tipo");

print $dados['ane_anexo'];