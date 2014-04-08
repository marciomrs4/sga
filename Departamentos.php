<?php
include_once($_SERVER['DOCUMENT_ROOT']."/SGA/componentes/config.php");

ControleDeAcesso::permitirAcesso(array(ControleDeAcesso::$TecnicoADM));

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");

echo"<div class='sub_menu_principal'>";
echo FormComponente::actionButton('<img src="./css/images/novo.png" title="Novo Departamento"  >','cadastrar/departamento');
Texto::criarTitulo("Departamentos");
echo "</div>";

?>

<?php

Arquivo::includeForm();

$tbdepartamento = new TbDepartamento();

$datagrid = new DataGrid(array('Departamento','E-mail Departamento','Listar Chamado'),$tbdepartamento->listarTodosDepartamentos());
$datagrid->colunaoculta = 1;

$datagrid->nomelink = "<img src='./css/images/editar.gif' title='Alterar Departamento'/> ";
$datagrid->acao = 'alterar/departamento';

$datagrid->mostrarDatagrid();

Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menuadministrativo.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");
?>