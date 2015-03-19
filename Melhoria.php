<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');

$ControleAcesso = new ControleDeAcesso();
$ControleAcesso->permitirAcesso(array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico, ControleDeAcesso::$Solicitante));

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");

$busca = new Busca();
$busca->validarPost($_POST);

#instancia do Classe DataGrid
$datagrid = new DataGrid();

echo"<div class='sub_menu_principal'>";
echo FormComponente::actionButton('<img src="./css/images/addmelhoria.png" title="Nova Melhoria"  >','cadastrar/SolicitacaoMelhoria');
Texto::criarTitulo("Solicitações de Melhorias");
echo "</div>";

?>
<form action="" method="post">
<fieldset>
	<legend>Pesquisar Melhorias</legend>
<table border="0">
 
	<tr>	
		<td>
			Status:
			<?php 
			$tbstatusMelhoria = new TbStatusMelhoria();

			$form = new FormComponente();
			$form::$name = 'TODOS';
			$form->selectOption('stm_codigo', $tbstatusMelhoria->listarStatus(),true,$busca->getDados('stm_codigo'));

			#Nome do Campo
			echo(' Sistema:');
				
		    $tbSistema = new TbSistemas();
		    FormComponente::selectOption('sis_codigo',$tbSistema->listarSistemas(),true,$_POST);
			?>
			
		</td>
	
		<td>
			<input type="submit" class="pesquisando" value="Pesquisar" />
		</td>
	</tr>
</table>
</fieldset>
</form>

<?php

#Carrega dinamicamente os formularios	
Arquivo::includeForm();


try
{
	
	
$datagrid->setDados($busca->listarMelhoria());
$datagrid->setCabecalho(array('Nº','Solicitante','Data Solicitação','Sistema','Status','Descrição','Atendente'));

$datagrid->titulofield = ' Melhorias(s)';
$datagrid->acao = 'alterar/SolicitacaoMelhoria';
$datagrid->nomelink = '<img src="/SGA/css/images/search2.png" title="Visualizar" />';	

$datagrid->islink2 = true;
$datagrid->acao2 = 'cadastrar/apontamentoMelhoria';
$datagrid->nomelink2 = '<img src="./css/images/adcionar.png" title="Adicionar Apontamento" />';


$datagrid->mostrarDatagrid();

}catch (Exception $e)
{
	echo $e->getMessage() . " ". $e->getCode();
}


Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menusecundario.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");

?>