<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

/*$tbSolicitacao = new TbSolicitacao();

//$dados['dep_codigo'] = 5;
$dados['data1'] = '2015-06-01 00:00:01';
$dados['data2'] = '2015-06-30 23:59:59';

$tbSolicitacao->graficoTopTenChamadoAbertoPorArea($dados);

print_r($dados);*/

$busca = new Busca();

$busca->graficoTopTenChamadoAbertoPorArea();

?>

