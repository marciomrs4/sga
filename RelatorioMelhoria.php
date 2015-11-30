<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

$ControleAcesso = new ControleDeAcesso();
$ControleAcesso->permitirAcesso(array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico));

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");

$busca = new Busca();
$busca->validarPost($_POST);

#instancia do Classe DataGrid
$datagrid = new DataGrid();

echo"<div class='sub_menu_principal'>";
Texto::criarTitulo("Relatório de Melhorias");
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
			$SelectStatus = new SelectOption();
			$SelectStatus->setStmt($tbstatusMelhoria->listarStatus())
				->setOptionEmpty('Todos')
				->setSelectName('stm_codigo')
				->setSelectedItem($busca->getDados('stm_codigo'))
				->listOption();
			?>
			Sistema:
			<?php
		    $tbSistema = new TbSistemas();

			$SelectSistema = new SelectOption();

			$SelectSistema->setStmt($tbSistema->listarSistemas())
				->setOptionEmpty('Todos')
				->setSelectName('sis_codigo')
				->setSelectedItem($busca->getDados('sis_codigo'))
				->listOption();

			?>
			
		</td>
	
		<td>
			<input type="submit" class="pesquisando" value="Pesquisar" />
		</td>
	</tr>
</table>
</fieldset>
	<?php
	$datagrid->excel = true;
	$datagrid->exportarExcel('Lista de Melhoria','listarRelatorioMelhoria');
	$datagrid->setCabecalho(array('N°','Sistema','Usuário Chave','Solicitante','Status','Data Abertura','Assunto'));
	?>
</form>

<?php
#Carrega dinamicamente os formularios	
Arquivo::includeForm();


try
{
	
	
$datagrid->setDados($busca->listarRelatorioMelhoria());


$datagrid->titulofield = ' Melhorias(s)';
$datagrid->islink = false;
$datagrid->acao = 'alterar/SolicitacaoMelhoria';
$datagrid->nomelink = '<img src="/sga/css/images/search2.png" title="Visualizar" />';	

$datagrid->islink2 = false;
$datagrid->acao2 = 'cadastrar/ApontamentoMelhoria';
$datagrid->nomelink2 = '<img src="./css/images/adcionar.png" title="Adicionar Apontamento" />';


$datagrid->mostrarDatagrid();

}catch (Exception $e)
{
	echo $e->getMessage() . " ". $e->getCode();
}


Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menurelatorio.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");

?>