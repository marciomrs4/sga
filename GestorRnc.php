<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/sga/componentes/config.php');
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");


$busca = new Busca();
$busca->validarPost($_POST);

//$busca->listarDados();

#instancia do Classe DataGrid
$datagrid = new DataGrid();

?>
<form action="" method="post">
	<fieldset>
		<legend>Pesquisar RNC</legend>
		<table border="0">
			<td>
				Status:
				<?php
				$tbstatusRnc= new TbStatusRnc();
				//Criacao do campo do formulario de status
				$FormStatus = new SelectOption();
				$FormStatus->setStmt($tbstatusRnc->listarStatus())
							->setSelectName('sta_codigo_rnc')
							->setSelectedItem($busca->getDados('sta_codigo_rnc'))
							->setOptionEmpty('TODOS')
							->listOption();

				?>

				- Período: De <input type="text" name="data1" class="data" id="data-id" size="10" value="<?php echo($busca->getDados('data1'));?>">
				à <input type="text" name="data2" class="data" id="data" size="10" value="<?php echo($busca->getDados('data2'));?>">
			</td>
			</tr>

			<tr>
				<td>
					Descrição:
					<input type="text" name="nc_descricaocompleta" size="50" value="<?php echo($busca->getDados('nc_descricaocompleta'));?>">
				</td>
				<td>
					<input type="submit" class="pesquisando" value="Pesquisar" />
				</td>
			</tr>
		</table>
	</fieldset>
</form>

<?php



$DataGridRNC = new DataGrid();

$cabecalho = array('Número','Data Ocorrencia','Descrição', 'Local', 'Departamento','Data Abertura','Status');

$DataGridRNC->setCabecalho($cabecalho);

$DataGridRNC->setDados($busca->listarRncGestor());

$DataGridRNC->colunaoculta = 1;

$DataGridRNC->titulofield = ' Registro de NC(s)';
$DataGridRNC->acao = 'responder/Rnc';
$DataGridRNC->link = 'rncGestor.php';
$DataGridRNC->nomelink = '<img src="./css/images/search2.png" title="Abrir" />';
$DataGridRNC->targetEnable = true;

$DataGridRNC->mostrarDatagrid();



include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menuqualidade.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");
?>
