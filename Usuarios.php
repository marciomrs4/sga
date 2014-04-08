<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');

ControleDeAcesso::permitirAcesso(array(ControleDeAcesso::$TecnicoADM));

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");

echo"<div class='sub_menu_principal'>";
echo FormComponente::actionButton('<img src="./css/images/new_usuario.png" title="Novo '.$_SESSION['config']['usuario'].'">','cadastrar/usuario');
Texto::criarTitulo($_SESSION['config']['usuario']);
echo "</div>";


$busca = new Busca();
$busca->validarPost($_POST);

$datagrid = new DataGrid();

?>
<form action="" method="post">
<fieldset>
	<legend>Pesquisar Usuários</legend>
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
			Nome:
			<input type="text" name="usu_nome" value="<?php echo($busca->getDados('usu_nome'));?>" />
		</td>
		<td>
			<input type="submit" value="Pesquisar" />
		</td>
	</tr>
</table>
</fieldset>

	<?php 
	
	$datagrid->setCabecalho(array($_SESSION['config']['usuario'],'Departamento','Tipo de Acesso','E-mail','Ramal'));
	$datagrid->setDados($busca->listarUsuario());
	
	$datagrid->exportarExcel('ListaDeUsuarios','listarUsuario',1);
	
	?>

</form>
<br />

<?php
Arquivo::includeForm();

$datagrid->colunaoculta = 1;

$datagrid->islink2 = true;
$datagrid->nomelink2 = '<img src="./css/images/edit_password.png" title="Alterar Senha">';
$datagrid->acao2 = 'alterar/SenhaUsuario';


$datagrid->nomelink = '<img src="./css/images/editar.gif" title="Alterar Usuário">';
$datagrid->acao = 'alterar/usuario';

$datagrid->mostrarDatagrid();

Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menuadministrativo.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");
?>