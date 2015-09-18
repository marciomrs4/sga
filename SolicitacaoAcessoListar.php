<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

$ControleAcesso = new ControleDeAcesso();
$ControleAcesso->permitirAcesso(array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico));

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");

$busca = new Busca();
$busca->validarPost($_POST);

#instancia do Classe DataGrid
$datagrid = new DataGrid();

echo "<div class='sub_menu_principal'>";

echo '<a href="SolicitacaoAcesso.php" target="_blank"><img src="css/images/new_ocorrencia.png"></a>';

Texto::criarTitulo("Solicitação de Acesso");
echo "</div>";

?>
<form action="" method="post">
<fieldset>
	<legend>Pesquisar</legend>
<table border="0">
 
	<tr>	
		<td>
			Status:
			<?php 
			$tbstatus= new TbStatus();
            //Criacao do campo do formulario de status
            $FormStatus = new SelectOption();
            $FormStatus->setStmt($tbstatus->selectMeuStatus())
                       ->setSelectName('sta_codigo')
                       ->setSelectedItem($busca->getDados('sta_codigo'))
                       ->setOptionEmpty('TODOS')
                       ->listOption();
            ?>

            Chamado:
				<input type="text" name="sol_codigo" value="<?php echo($busca->getDados('sol_descricao_solicitacao'));?>">
			

			<?php 
				//'N?mero',$_SESSION['config']['problema'],'Status','Solicitante','Depto Solicitante','Descri??o','Atendente','Data Abertura'
			$cabecalho = array('Número','Status','Data Abertura','Atendente');
				
			$datagrid->setCabecalho($cabecalho);
			
			$datagrid->exportarExcel('ListaDeSolicitacoes','listarRelatoriSolicitacaoAcesso');
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
try
{

$datagrid->setDados($busca->listarRelatoriSolicitacaoAcesso());

$datagrid->titulofield = ' Solicitações de Acesso';
$datagrid->link = 'SolicitacaoAcessoCreated.php';
$datagrid->acao = 'id';
$datagrid->nomelink = '<img src="/sga/css/images/search2.png" title="Visualizar" />';	
$datagrid->colunaoculta = 1;
$datagrid->targetEnable = true;
$datagrid->mostrarDatagrid();

}catch (Exception $e)
{
	echo $e->getMessage() . " ". $e->getCode();
}


Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menusecundario.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");

?>