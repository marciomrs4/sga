<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');

ControleDeAcesso::permitirAcesso(array(ControleDeAcesso::$TecnicoADM));

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");

echo"<div class='sub_menu_principal'>";
echo FormComponente::actionButton('<img src="./css/images/novo.png" title="Nova Prioridade">','cadastrar/Sistema');
Texto::criarTitulo("Prioridade");
echo "</div>";

$busca = new Busca();
$busca->validarPost($_POST);

?>
<form action="" method="post">
<fieldset>
	<legend>Pesquisar Sistema</legend>
<table border="0">
 
	<tr>	
		<td>
			Usuário Chave:
		</td>
		<td>
			<input type="text" name="usu_codigo_usuario_chave" value="<?php echo $busca->getDados('usu_codigo_usuario_chave'); ?>" />
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

$datagrid = new DataGrid(array('Descricao','Usuário Chave'),$busca->listarSistemaUsuarioChave());
$datagrid->colunaoculta = 1;
$datagrid->acao = 'alterar/Sistema';
$datagrid->nomelink = '<img src="./css/images/editar.gif" title="Alterar Sistema">';
$datagrid->mostrarDatagrid();


Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menuadministrativo.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");
?>