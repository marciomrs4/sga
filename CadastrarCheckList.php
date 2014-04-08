<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');

$ControleAcesso = new ControleDeAcesso();
$ControleAcesso->permitirAcesso(array(ControleDeAcesso::$TecnicoADM));

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");

$busca = new Busca();

$busca->validarPost($_POST);

echo"<div class='sub_menu_principal'>";
echo FormComponente::actionButton('<img src="./css/images/addItem.png" title="Novo Checklist"  >','cadastrar/Checklist');
Texto::criarTitulo('Checklist');
echo "</div>";


Arquivo::includeForm();

$grid = new DataGrid(array('Titulo','E-mail de Envio','Departamento'),$busca->listarChecklist());

$grid->colunaoculta = 1;

$grid->acao = 'alterar/Checklist';

$grid->islink2 = true;
$grid->acao2 = 'criar/ItemChecklist';
$grid->link2 = 'ItemChecklist.php';

$grid->mostrarDatagrid();

Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menuadministrativo.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");

?>