<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/sga/componentes/config.php');
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");


$busca = new Busca();
$busca->validarPost($_POST);


?>
 <form action="" method="post">
<fieldset>
	<legend>Pesquisar RNC</legend>
<table border="0">
 
	<tr>
		<td>
			Status:
			<?php 
			$tbstatusRNC = new TbStatusRnc();
            //Criacao do campo do formulario de status
            $FormStatus = new SelectOption();
            $FormStatus->setStmt($tbstatusRNC->listarStatus())
                       ->setSelectName('snc_codigo')
                       ->setSelectedItem($busca->getDados('snc_codigo'))
                       ->setOptionEmpty('TODOS')
                       ->listOption();
			?>

			Departamento:
			<?php
		    $tbDepartamento = new TbDepartamento();
            //Criacao do campo do formulario de Problema
            $FormProblema = new SelectOption();
            $FormProblema->setStmt($tbDepartamento->getAllDepartamentos())
                         ->setSelectName('dep_responsavel_codigo')
                         ->setSelectedItem($busca->getDados('dep_responsavel_codigo'))
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

Arquivo::includeForm();

$DataGridRNC = new DataGrid();

$cabecalho = array('Número','Data Ocorrência','Descrição', 'Local', 'Departamento','Data Abertura','Status');

$DataGridRNC->setCabecalho($cabecalho);

$DataGridRNC->setDados($busca->listarRncQualidade());

$DataGridRNC->titulofield = ' Registro de NC(s)';

$DataGridRNC->colunaoculta = 1;
$DataGridRNC->acao = 'alterar/rncVerificacao';
$DataGridRNC->nomelink = '<img src="./css/images/search2.png" title="Abrir" />';

$DataGridRNC->acao2 = 'cadastrar/uploadfilesRNC';
$DataGridRNC->nomelink2 = '<img src="./css/images/anexo.png" title="Anexos" />';
$DataGridRNC->islink2 = true;


$DataGridRNC->mostrarDatagrid();



Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menuqualidade.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");
?>
