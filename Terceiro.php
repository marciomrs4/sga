<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

ControleDeAcesso::permitirAcesso(array(ControleDeAcesso::$TecnicoADM));

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");

echo"<div class='sub_menu_principal'>";
echo FormComponente::actionButton('<img src="./css/images/novo.png" title="Novo Sistema">','cadastrar/Terceiro');
Texto::criarTitulo("Terceiro");
echo "</div>";

$busca = new Busca();
$busca->validarPost($_POST);


?>
<form action="" method="post">
<fieldset>
	<legend>Pesquisar Terceiro</legend>
<table border="0">
 
	<tr>	
		<td>
			Departamento:
			<?php 
		       $tbdepartamento = new TbDepartamento();
		       FormComponente::$name = 'Todos';
		       FormComponente::selectOption('dep_codigo',$tbdepartamento->listarDepartamentos(),true,$_POST);
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

$datagrid = new DataGrid(array('Departamento','Descricao','Status'),$busca->listarTerceiro());
$datagrid->colunaoculta = 1;
$datagrid->acao = 'alterar/Terceiro';
$datagrid->nomelink = '<img src="./css/images/editar.gif" title="Alterar Sistema">';
$datagrid->mostrarDatagrid();


Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menuadministrativo.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");
?>