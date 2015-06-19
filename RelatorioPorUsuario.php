<?php
include_once($_SERVER['DOCUMENT_ROOT']."/sga/componentes/config.php");

ControleDeAcesso::permitirAcesso(array(ControleDeAcesso::$TecnicoADM));

include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/componentes/script.php");

//Texto::mostrarMensagem(Texto::erro($_SESSION['sempermissao']));

Texto::criarTitulo('Relatório: Chamados por '.$_SESSION['config']['usuario']);

$busca = new Busca();
$busca->validarPost($_POST);

	$dataGrid = new DataGrid(array($_SESSION['config']['usuario'],'Data de Inclusão','Número do chamado','Descrição','Status'));

?>
<form action="" method="post">
<fieldset>
	<legend>Pesquisar</legend>
<table border="0">
	<tr>	
		<td>
			Status:
			<?php 
		    $tbStatus = new TbStatus();
		    FormComponente::$name = 'TODOS';
		    FormComponente::selectOption('sta_codigo',$tbStatus->selectStatus(),true,$busca->getDados('sta_codigo'));
		    ?>
			<?php echo($_SESSION['config']['usuario']);?>:
			<input type="text" name="usu_nome" value="<?php echo($busca->getDados('usu_nome'));?>">
		</td>				
		<td>
			<input type="submit" value="Pesquisar" />
		</td>
	</tr>
</table>
</fieldset>
<?php 

$dataGrid->exportarExcel('RelatorioPor'.$_SESSION['config']['usuario'],'listarChamadoPorUsuario',1);

?>

</form>
<br />
<?php 
try 
{
	
	$dataGrid->setDados($busca->listarChamadoPorUsuario());
	
	$dataGrid->islink = false;
	
	$dataGrid->mostrarDatagrid();

} catch (Exception $e) 
{
	echo Texto::mostrarMensagem(Texto::erro($e->getMessage()));
}

Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/menurelatorio.php");
include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/componentes/rodape.php");

?>