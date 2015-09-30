<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

$ControleAcesso = new ControleDeAcesso();
$ControleAcesso->permitirAcesso(array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico,$ControleAcesso::$Solicitante));

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");

$busca = new Busca();

$busca->validarPost($_POST);

echo"<div class='sub_menu_principal'>";
echo FormComponente::actionButton('<img src="../sga/css/images/addchamado.png" title="Novo Chamado"  >','cadastrar/Solicitacao');
Texto::criarTitulo("Chamados / Solicitações");
echo "</div>";

?>
<form action="" method="post">
<fieldset>
	<legend>Pesquisar Chamado</legend>
<table border="0">
 
	<tr>	
		<td nowrap="nowrap">
			Departamento:
			<?php 
			$tbdepartamento = new TbDepartamento();
            //Campo de Departamento
            $FormDepartamento = new SelectOption();
            $FormDepartamento->setStmt($tbdepartamento->listarDepartamentos())
                             ->setOptionEmpty('TODOS')
                             ->setSelectedItem($busca->getDados('dep_codigo_busca'))
                             ->setSelectName('dep_codigo_busca')
                             ->listOption();


			?>
			</td>
			<td>
			<?php 
			   echo($_SESSION['config']['problema'].':');
		       $tbproblema = new TbProblema();

               $FormProblema = new SelectOption();
               $FormProblema->setStmt($tbproblema->listarProblema('dep_codigo'))
                            ->setOptionEmpty('TODOS')
                            ->setSelectedItem($busca->getDados('pro_codigo_busca'))
                            ->setSelectName('pro_codigo_busca')
                            ->listOption();


            ?>
		</td>
	</tr>
	<tr>
		<td nowrap="nowrap">
				
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
		</td>
	
		<td>
			Solicitante:
				<input type="text" name="usu_nome" size="15" value="<?php echo($busca->getDados('usu_nome')); ?>">
		
			Descrição:
				<input type="text" name="sol_descricao_solicitacao" size="20" value="<?php echo($busca->getDados('sol_descricao_solicitacao'));?>">
		</td>				

		<td>
			<input type="submit" value="Pesquisar" />
		</td>
	</tr>
</table>
</fieldset>

<?php

$cabecalho = array('Número',$_SESSION['config']['problema'],'Status','Solicitante','Data Abertura','Depto Solicitado','Descrição','Atendente');

$dados = $busca->listarChamadoSolicitante();

$datagrid = new DataGrid($cabecalho,$dados);

$datagrid->exportarExcel('ListaChamado.xls','exportarlistaChamadoSolicitante');

?>

</form>
<br />

<?php

#Carrega dinamicamente os formularios	
Arquivo::includeForm();

try
{
	
$datagrid->titulofield = 'Chamado(s)';
$datagrid->acao = 'alterar/SolicitacaoSolicitante';
$datagrid->nomelink = '<img src="/sga/css/images/search.png" />';	

$datagrid->mostrarDatagrid();

}catch (Exception $e)
{
	echo $e->getMessage() . " ". $e->getCode();
}

Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menusecundario.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");

?>