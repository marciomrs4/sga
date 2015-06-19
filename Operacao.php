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
echo FormComponente::actionButton('<img src="./css/images/addchamado.png" title="Novo Chamado"  >','cadastrar/SolicitacaoTecnico');
Texto::criarTitulo("Chamado");
echo "</div>";

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
                         ->setOptionEmpty('Selectione...')
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

#Carrega dinamicamente os formularios	
Arquivo::includeForm();


try
{
	
	
$datagrid->setDados($busca->listarChamado());

$datagrid->titulofield = ' Chamado(s)';
$datagrid->acao = 'alterar/Solicitacao';
$datagrid->nomelink = '<img src="/sga/css/images/search2.png" title="Visualizar" />';	

$datagrid->islink2 = true;
$datagrid->acao2 = 'cadastrar/Assentamento';
$datagrid->nomelink2 = '<img src="./css/images/adcionar.png" title="Adicionar Assentamento" />';


$datagrid->mostrarDatagrid();

}catch (Exception $e)
{
	echo $e->getMessage() . " ". $e->getCode();
}


Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menusecundario.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");

?>