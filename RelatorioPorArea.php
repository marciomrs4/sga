<?php
include_once($_SERVER['DOCUMENT_ROOT']."/SGA/componentes/config.php");

ControleDeAcesso::permitirAcesso(array(ControleDeAcesso::$TecnicoADM));

include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/componentes/script.php");

//Texto::mostrarMensagem(Texto::erro($_SESSION['sempermissao']));

Texto::criarTitulo("Relatório: Chamados por Área");

$busca = new Busca();
$busca->validarPost($_POST);

$dataGrid = new DataGrid(array('Departamento','Data de Inclusão','Número do chamado','Descrição',$_SESSION['config']['usuario'] .' Solicitante','Status'));


?>
<form action="" method="post">
<fieldset>
	<legend>Pesquisar</legend>
<table border="0">
	<tr>	
		<td>
Departamento: <input type="text" name="dep_descricao" value="<?php echo($busca->getDados('dep_descricao'));?>">
		</td>				
		<td>
			<input type="submit" value="Pesquisar" />
		</td>
	</tr>
</table>
</fieldset>

<?php 
$dataGrid->exportarExcel('RelatorioPorArea','listarChamadoPorArea',1);

?>

</form>
<br />
<?php 
try 
{
	$dataGrid->setDados($busca->listarChamadoPorArea());
	
	$dataGrid->islink = false;
	
	$dataGrid->mostrarDatagrid();

} catch (Exception $e) 
{
	echo $e->getMessage();
}

Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/menurelatorio.php");
include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/componentes/rodape.php");

?>