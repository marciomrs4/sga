<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");

$busca = new Busca();

$busca->validarPost($_POST);

echo"<div class='sub_menu_principal'>";
echo FormComponente::actionButton('<img src="../sga/css/images/addchamado.png" title="Novo Chamado"  >','cadastrar/Solicitacao');
Texto::criarTitulo("Chamados / Solicitações");
echo "</div>";

?>
<form action="" method="post">
<fieldset>
	<legend>Pesquisar Chamado</legend>
<table border="2">
 
	<tr>	
		<td nowrap="nowrap">
			Departamento:
			<?php 
			$tbdepartamento = new TbDepartamento();	
			FormComponente::$name = 'TODOS';
		    FormComponente::selectOption('dep_codigo_busca',$tbdepartamento->listarDepartamentos(),true,$busca->getDados('dep_codigo_busca'));
			?>
			</td>
			<td>
			<?php 
			   echo($_SESSION['config']['problema'].':');
		       $tbproblema = new TbProblema();
		       FormComponente::$name = 'TODOS';
		       FormComponente::selectOption('pro_codigo_busca',$tbproblema->listarProblema('dep_codigo'),true,$busca->getDados('pro_codigo_busca'));
			?>
		</td>
	</tr>
	<tr>
		<td nowrap="nowrap">
				
			Status:
			<?php 
			$tbstatus= new TbStatus();
			FormComponente::$name = 'TODOS';
			FormComponente::selectOption('sta_codigo', $tbstatus->selectMeuStatus(),true,$busca->getDados('sta_codigo'));
			?>
		</td>
	
		<td>
			Solicitante:
				<input type="text" name="usu_nome" size="15" value="<?php echo($busca->getDados('usu_nome')); ?>">
		
			Descrição:
				<input type="text" name="sol_descricao_solicitacao" size="30" value="<?php echo($busca->getDados('sol_descricao_solicitacao'));?>">
		</td>				

		<td>
			<input type="submit" value="Pesquisar" />
		</td>
	</tr>
</table>
</fieldset>

<?php 

$cabecalho = array('Número',$_SESSION['config']['problema'],'Status','Solicitante','Data Abertura','Depto Solicitado','Descrição','Atendente');

$dados = $busca->listarChamadoSolicitante();

$datagrid = new DataGrid($cabecalho,$dados);

$datagrid->exportarExcel('ListaChamado.xls','listarChamadoSolicitante');

?>

</form>
<br />

<?php

#Carrega dinamicamente os formularios	
Arquivo::includeForm();

try
{
	
$datagrid->titulofield = 'Chamado(s)';
$datagrid->acao = 'alterar/SolicitacaoSolicitante';
$datagrid->nomelink = '<img src="/SGA/css/images/search.png" />';	

$datagrid->mostrarDatagrid();

}catch (Exception $e)
{
	echo $e->getMessage() . " ". $e->getCode();
}

Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menusecundario.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");

?>