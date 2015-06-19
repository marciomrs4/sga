<?php
include_once($_SERVER['DOCUMENT_ROOT']."/sga/componentes/config.php");

ControleDeAcesso::permitirAcesso(array(ControleDeAcesso::$TecnicoADM));

include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/componentes/script.php");

//Texto::mostrarMensagem(Texto::erro($_SESSION['sempermissao']));

Texto::criarTitulo("Relatório: Chamados por Prioridade");

$busca = new Busca();
$busca->validarPost($_POST);

$dataGrid = new DataGrid(array('Prioridade','Data de Inclusão',$_SESSION['config']['usuario'] .' Solicitante','Departamento','Número do chamado','Descrição','Status'));


?>
<form action="" method="post">
<fieldset>
	<legend>Pesquisar</legend>
<table border="0">
	<tr>	
		<th>
			Status:
		</th>
			<td>
			<?php 
		    $tbStatus = new TbStatus();
		    FormComponente::$name = 'TODOS';
		    FormComponente::selectOption('sta_codigo',$tbStatus->selectStatus(),true,$busca->getDados('sta_codigo'));
		    ?>
		<td>
		<!-- 
      <th align="left" nowrap="nowrap">Departamento:</th>
	      <td nowrap="nowrap">
	      	<?php 
			$departamento = new TbDepartamento();
			FormComponente::$name = '';
			$_SESSION['cadastrar/MeuProblema']['dep_codigo'] = $_SESSION['dep_codigo'];
	      	FormComponente::selectOption('dep_codigo_problema',$departamento->listarTodosDepartamentos(),true,$_SESSION['cadastrar/MeuProblema']);	      	
	      	?>
	      </td>
	      
      <th align="left" nowrap="nowrap">Prioridade:</th>
	      <td>
	      	<?php 
	      	$tbprioridade = new TbPrioridade();
	      	FormComponente::selectOption('pri_codigo', $tbprioridade->selectMinhasPrioridades('dep_codigo'),false,$busca->getDados('pri_codigo'));	      	
	      	?>
	      </td>
    	<th>
		Período: De
		</th> 
		<td>
		<input type="text" name="data1" class="data" id="data-id" size="10" value="<?php echo($busca->getDados('data1'));?>">
		à <input type="text" name="data2" class="data" id="data" size="10" value="<?php echo($busca->getDados('data2'));?>">
		</td>
		 -->				
		<td>
			<input type="submit" value="Pesquisar" />
		</td>
	
	</tr>
</table>
</fieldset>
<?php 

$dataGrid->exportarExcel('RelatorioPorPrioridade','listarChamadoPorPrioridade');

?>
</form>
<br />
<?php 
try 
{
	$dataGrid->setDados($busca->listarChamadoPorPrioridade());
	
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