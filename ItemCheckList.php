<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

$ControleAcesso = new ControleDeAcesso();
$ControleAcesso->permitirAcesso(array(ControleDeAcesso::$TecnicoADM));

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");



#Instancia a a classe busca 
$busca = new Busca();
#Seta a variavel GET e diz que pode ser usado o nome che_codigo
#para obetela
$busca->setValueGet($_GET,'che_codigo');
#Obtem o c?digo che_codigo com metodo get


$tbchecklist = new TbChecklist();

$_SESSION['cadastrar/ItemChecklist'] = $tbchecklist->getForm($busca->getValueGet('che_codigo'));

$CheckList = $_SESSION['cadastrar/ItemChecklist'];

echo"<div class='sub_menu_principal'>";
echo FormComponente::actionButton('<img src="./css/images/addItem.png" title="Novo Item do Checklist"  >','cadastrar/Itemchecklist');
Texto::criarTitulo('Item Checklist: '.$_SESSION['cadastrar/ItemChecklist']['che_titulo']);
echo "</div>";

Arquivo::includeForm();

$cabecalho = array('Descrição','Ativo','Link','Anexo');

$datagrid = new DataGrid($cabecalho, $busca->listarItemCheckList());

$datagrid->colunaoculta = 1;

$datagrid->acao = 'alterar/Itemchecklist';

$datagrid->titulofield = 'Itens do Checklist: - '.$CheckList['che_titulo'].' -';

$datagrid->mostrarDatagrid();


Sessao::finalizarSessao();

unset($_SESSION['cadastrar/ItemChecklist']);

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menuadministrativo.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");


?>