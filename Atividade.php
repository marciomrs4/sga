<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');

$ControleAcesso = new ControleDeAcesso();
$ControleAcesso->permitirAcesso(array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico));

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");

$busca = new Busca();

$busca->validarPost($_POST);

$datagrid = new DataGrid();

echo"<div class='sub_menu_principal'>";
echo FormComponente::actionButton('<img src="./css/images/addatividade.png" title="Nova Atividade"  >','cadastrar/Atividade');
Texto::criarTitulo("Atividade");
echo "</div>";

?>
<form action="" method="post">
<fieldset>
	<legend>Pesquisar Atividade</legend>
<table border="0">
 
	<tr>	
		<td>
			Status:
			<?php 
				
		    $tbStatusAtividade = new TbStatusAtividade();
		    FormComponente::$name = 'Todos';
		    FormComponente::selectOption('sta_codigo',$tbStatusAtividade->listarStatusAtividade(),true,$busca->getDados('sta_codigo'),5);
		    ?>
			Projeto:
			<?php 
				
		    $tbProjeto = new TbProjeto();
		    FormComponente::$name = 'Todos';
		    FormComponente::selectOption('pro_codigo',$tbProjeto->listarProjetoTodos($_SESSION['dep_codigo']),true,$_SESSION['post']);
			?>
			Usuário:
			<?php 
				
		    $tbUsuario = new TbUsuario();
		    FormComponente::$name = 'Todos';
		    $_SESSION['post']['usu_codigo_responsavel'] = ($_SESSION['post']['usu_codigo_responsavel'] == '') ? $_SESSION['usu_codigo'] : $_SESSION['post']['usu_codigo_responsavel']; 
		    FormComponente::selectOption('usu_codigo_responsavel',$tbUsuario->selectUsuarioPorDepartamento($_SESSION['dep_codigo']),true,$_SESSION['post'],5);
			?>			
		</td>
	</tr>
	<tr>
		<td>
			Descrição:
				<input type="text" name="at_descricao" size="50" value="<?php echo($busca->getDados('at_descricao'));?>">
		</td>				

		<td>
			<input type="submit" value="Pesquisar" />
		</td>
	</tr>
</table>
</fieldset>

<?php 
$cabecalho = array('N°','Projeto','Executor','Prev. Inicio','Previsão. Fim','Status','Descrição','Data Aponta.','Descrição','Qtd');
$datagrid->setCabecalho($cabecalho);


$datagrid->exportarExcel('Atividade','listarAtividadeSemQuebrarLinha');

?>
</form>

<?php

#Carrega dinamicamente os formularios	
Arquivo::includeForm();


try
{
	

$datagrid->setDados($busca->listarAtividade());

$datagrid->titulofield = 'Atividade(s)';
$datagrid->acao = 'alterar/Atividade';
$datagrid->nomelink = '<img src="/SGA/css/images/search2.png" title="Visualizar" />';	

$datagrid->islink2 = true;
$datagrid->nomelink2 = '<img src="/SGA/css/images/adcionar.png" title="Adicionar Apontamento" />';
$datagrid->acao2 = 'cadastrar/Apontamento';


$datagrid->mostrarDatagrid();

}catch (Exception $e)
{
	echo $e->getMessage() . " ". $e->getCode();
}

Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menusecundario.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");

?>