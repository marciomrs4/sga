<?php
session_start();

include_once 'componentes/config.php';

#Instacia o Classe Busca
$busca = new Busca();
#Pega o que existe na sessão
$busca->validarPost($_POST);

#Cria o nome do Arquivo para ser gerado [OK]
$arquivo = $busca->getDados('NomeExcel').'.xls';

#Cria o cabeçalho
$cabecalho = $busca->criarArray($busca->getDados('Cabecalho'));

#Pega o metodo a ser chamado
$Metodo = $busca->getDados('Metodo');

if(!method_exists($busca,$Metodo))
{
	echo('Método não encontrado: Favor entrar em contato com administrator');
}

#Chama o metodo e passa o valores para DAdos
$dados = $busca->$Metodo();

$datagrid = new DataGrid($cabecalho,$dados);

$datagrid->islink = false;

$datagrid->colunaoculta = $busca->getDados('ColunaOculta');

$datagrid->borda = 2;

header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");

header ("Cache-Control: no-cache, must-revalidate");

header ("Content-type: application/vnd.ms-msexcel");
//header ("Content-type: application/x-msexcel");

header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );

header ("Content-Description: PHP Generated Data" );

header ("Pragma: no-cache");

$datagrid->mostrarDatagrid();

exit;