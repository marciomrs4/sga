<?php
include_once($_SERVER['DOCUMENT_ROOT']."/sga/componentes/config.php");

ControleDeAcesso::permitirAcesso(array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico));

include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/componentes/script.php");

//Texto::mostrarMensagem(Texto::erro($_SESSION['sempermissao']));

Texto::criarTitulo('Relatório: Chamados por Tempo de Solução do Problema');

$busca = new Busca();
$busca->validarPost($_POST);

$dataGrid = new DataGrid(array('Data Inicio','Data Fim','Tempo','Departamento',$_SESSION['config']['usuario'] .' Solicitante',
								'Número','Problema Usuario','Problema Tecnico','SLA Usuario','SLA Tecnico',
								'Status','Prioridade','SLA Atendimento','Atendente','DIFF - Usuario','DIFF - Tecnico'));


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
Período: De <input type="text" name="data1" class="data" id="data-id" size="10" value="<?php echo($busca->getDados('data1'));?>">
		à <input type="text" name="data2" class="data" id="data" size="10" value="<?php echo($busca->getDados('data2'));?>">
		</td>				
		<td>
			<input type="submit" value="Pesquisar" />
		</td>
	</tr>
</table>
</fieldset>
<?php 

$dataGrid->exportarExcel('RelatorioPorTempoDeSolucao','listarChamadoPorTempoDeSolucao',1);

?>
</form>
<br />
<?php 
try 
{

	
	$dataGrid->setDados($busca->listarChamadoPorTempoDeSolucao());
	
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