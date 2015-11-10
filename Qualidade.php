<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/sga/componentes/config.php');
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");


$busca = new Busca();
$busca->validarPost($_POST);

#instancia do Classe DataGrid
$datagrid = new DataGrid();

?>
 <form action="" method="post">
<fieldset>
	<legend>Pesquisar Chamado</legend>
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
                       ->setOptionEmpty('TODOS',6)
                       ->listOption();

			#Nome do Campo
			echo(' '.$_SESSION['config']['problema'].':');
				
		    $tbproblema = new TbProblema();
            //Criacao do campo do formulario de Problema
            $FormProblema = new SelectOption();
            $FormProblema->setStmt($tbproblema->listarProblemasTecnicos($_SESSION['dep_codigo']))
                         ->setSelectName('pro_codigo_busca_tecnico')
                         ->setSelectedItem($busca->getDados('pro_codigo_busca_tecnico'))
                         ->setOptionEmpty('TODOS')
                         ->listOption();

			?>
			
		</td>
	</tr>
	
	<tr>
		<td>
			Solicitante:
				<input type="text" name="usu_nome" size="15" value="<?php echo($busca->getDados('usu_nome')); ?>">
		
			Descrição:
				<input type="text" name="sol_descricao_solicitacao" size="50" value="<?php echo($busca->getDados('sol_descricao_solicitacao'));?>">
			
		Atendente:
			<?php 
				
		    $tbUsuario = new TbUsuario();
            //Botao de Lista de Problemas
            $FormUsuarioAtendente = new SelectOption();
            $FormUsuarioAtendente->setStmt($tbUsuario->selectUsuarioPorDepartamento($_SESSION['dep_codigo']))
                                 ->setOptionEmpty('TODOS',0)
                                 ->setSelectName('usu_codigo_atendente')
                                 ->setSelectedItem($busca->getDados('usu_codigo_atendente'))
                                 ->listOption();
			?>		
 										
			<?php 
				//'N?mero',$_SESSION['config']['problema'],'Status','Solicitante','Depto Solicitante','Descri??o','Atendente','Data Abertura'
			$cabecalho = array('Número','Solicitante','Data Abertura',$_SESSION['config']['problema'],'Status','Depto Solicitante','Descrição','Atendente');
				
			$datagrid->setCabecalho($cabecalho);
			
			$datagrid->exportarExcel('ListaDeChamado','listarChamado');
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

$tbRnc = new TbCadastroRnc();

$DataGridRNC = new DataGrid();

$cabecalho = array('Número','Data','Descrição', 'Local', 'Departamento');

$DataGridRNC->setCabecalho($cabecalho);

$DataGridRNC->setDados($tbRnc->listTelaRnc());

$DataGridRNC->titulofield = ' Registro de NC(s)';
$DataGridRNC->acao = 'responder/Rnc';
$DataGridRNC->link = 'rncGestor.php';
$DataGridRNC->nomelink = '<img src="./css/images/search2.png" title="Abrir" />';
$DataGridRNC->targetEnable = true;

$DataGridRNC->mostrarDatagrid();



include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menuqualidade.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");
?>
