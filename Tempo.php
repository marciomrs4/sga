<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

ControleDeAcesso::permitirAcesso(array(ControleDeAcesso::$TecnicoADM));

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");

echo"<div class='sub_menu_principal'>";
echo FormComponente::actionButton('<img src="./css/images/new_time.png" title="Novo Tempo de Atendimento">','cadastrar/MeuTempo');
Texto::criarTitulo("Tempo de Prioridade");
echo "</div>";

$busca = new Busca();
$busca->validarPost($_POST);

?>
<form action="" method="post">
<fieldset>
	<legend>Pesquisar Tempo</legend>
<table border="0">
 
	<tr>	
		<td>
			Departamento:
			<?php 
		       $tbdepartamento = new TbDepartamento();
		       FormComponente::$name = 'Todos';
		       FormComponente::selectOption('dep_codigo',$tbdepartamento->listarTodosDepartamentos(),true,$_POST);
			?>
		</td>
		<td>
			<input type="submit" value="Pesquisar" />
		</td>
	</tr>
</table>
</fieldset>
</form>
<br />

<?php 
Arquivo::includeForm();

$datagrid2 = new DataGrid(array('Tempo de Atendimento','Departamento'), $busca->listarTempo());
$datagrid2->colunaoculta = 1;
$datagrid2->acao = 'alterar/MeuTempo';
$datagrid2->nomelink = '<img src="./css/images/editar.gif" title="Alterar Tempo de Atendimento">';
$datagrid2->mostrarDatagrid();

Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menuadministrativo.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");
?>