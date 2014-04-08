<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');

$ControleAcesso = new ControleDeAcesso();
$ControleAcesso->permitirAcesso(array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico));

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");

$busca = new Busca();
$busca->validarPost($_POST);

#instancia do Classe DataGrid
$datagrid = new DataGrid();
$datagrid->islink = (($_SESSION['dep_codigo'] == 40) || ($_SESSION['dep_codigo'] == 5)) ? true : false;

echo"<div class='sub_menu_principal'>";
if($datagrid->islink)
{
	echo FormComponente::actionButton('<img src="./css/images/niver.png" title="Novo Aniversariante"  >','cadastrar/Aniversario');
	echo FormComponente::criaHiperlink('Enviar E-mail','ScriptAniversariantes.php');
}
Texto::criarTitulo("Aniversario");
echo "</div>";

?>
<form action="" method="post">
<fieldset>
	<legend>Pesquisar Aniversáriantes</legend>
<table border="0">
 
	<tr>
		<td>	
		Dia:
			<?php 
			$tbDia = new TbConfigAniversario();
			FormComponente::$name = 'TODOS';

			FormComponente::selectOption('ani_dia', $tbDia->listarDias(),true,$_POST);
			?>	
					
		Mês:
			<?php 
			$tbMes = new TbConfigAniversario();
			FormComponente::$name = 'TODOS';

			FormComponente::selectOption('ani_mes', $tbMes->listarMeses(),true,$_POST);
			?>	

		<td>
		Unidade:
			<?php 
			$tbUnidade= new TbConfigAniversario();
			FormComponente::$name = 'TODOS';

			FormComponente::selectOption('ani_unidade', $tbMes->listarUnidade(),true,$_POST);
			?>	

		<td>		
			Nome:
				<input type="text" name="ani_nome" size="40" value="<?php echo($busca->getDados('ani_nome')); ?>">
				
				<?php 
				$colunas = array('DRT','Nome','Departamento','Dia','Mês');
				
				$datagrid->setCabecalho($colunas);
				$datagrid->exportarExcel('ListaDeAniversariantes', 'listarAniversariante',1);
				
				?>
		</td>				
		<td>
			<input type="submit" value="Pesquisar" />
		</td>
		<td>
		<?php 
		$Link = ($_SESSION['post']['NomeExcel'] == 'ListaDeAniversariantes') ? true : false;
		
		if($Link and $datagrid->islink)
		{ 
			$param = 'Unidade='.base64_encode($busca->getDados('ani_unidade')).'&';
			$param .= 'Mes='.base64_encode($busca->getDados('ani_mes'));
		?>
			<a href="GerarAniversariantePdf.php?<?php echo $param ?>" target="blank"><img src="./css/images/pdf.png"></a>	
		<?php } ?>
		
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
	
$datagrid->setDados($busca->listarAniversariante());
				
	

//$datagrid->excel = true;
$datagrid->titulofield = ' Aniversariante(s)';
$datagrid->islink = (($_SESSION['dep_codigo'] == 40) || ($_SESSION['dep_codigo'] == 5)) ? true : false;
$datagrid->acao = 'alterar/Aniversario';
$datagrid->nomelink = '<img src="/SGA/css/images/search.png" />';	

$datagrid->acao2 = true;

$datagrid->mostrarDatagrid();

}catch (Exception $e)
{
	echo $e->getMessage() . " ". $e->getCode();
}

Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menusecundario.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");

?>