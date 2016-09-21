<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

$ControleAcesso = new ControleDeAcesso();
$ControleAcesso->permitirAcesso(array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico,ControleDeAcesso::$Solicitante));

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");

$busca = new Busca();
$busca->validarPost($_POST);

#instancia do Classe DataGrid
$datagrid = new DataGrid();

echo"<div class='sub_menu_principal'>";
Texto::criarTitulo("Avalia��o de chamados");
echo "</div>";

#Carrega dinamicamente os formularios	
Arquivo::includeForm();

if($_SESSION['avaliacao']){

	echo '<h3>Obrigado por avaliar o chamado: ', $_SESSION['chamado'],'</h3>';

	unset($_SESSION['avaliacao']);

}


try
{
	
$cabecalho = array('N�','Problema','Status','Descri��o','Departamento Solicitado','Atendente','Abertura');

$datagrid->setCabecalho($cabecalho);
$datagrid->setDados($busca->listarChamadoParaAvaliacao());

$datagrid->titulofield = 'Chamados pendentes de avalia��o';
$datagrid->acao = 'cadastrar/Avaliacao';
$datagrid->nomelink = '<img src="/sga/css/images/avaliacao.png" title="Avaliar" />';

$datagrid->mostrarDatagrid();

}catch (Exception $e)
{
	echo $e->getMessage() . " ". $e->getCode();
}


Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menusecundario.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");

?>