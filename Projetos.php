<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

ControleDeAcesso::permitirAcesso(array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico));

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");

echo"<div class='sub_menu_principal'>";
echo FormComponente::actionButton('<img src="./css/images/addprojeto.png" title="Novo Projeto"  >','cadastrar/Projeto');
echo FormComponente::actionButton('<img src="./css/images/addatividade.png" title="Nova Atividade"  >','cadastrar/Atividade');
Texto::criarTitulo('Projetos');
echo "</div>";

$busca = new Busca();
$busca->validarPost($_POST);

$DataGrid = new DataGrid(array('C�digo do Projeto','Titulo',$_SESSION['config']['usuario'].' Solicitante','Previs�o Inicio','Previs�o Fim','Status'));


?>
<form action="" method="post">
<fieldset>
	<legend>Pesquisar Projetos</legend>
<table border="0">
 
	<tr>	
		<td>

			Status:
			<?php 
			$tbStatusProjeto = new TbStatusProjeto();
			FormComponente::$name = 'TODOS';
			FormComponente::selectOption('stp_codigo', $tbStatusProjeto->selectStatus(),true,$busca->getDados('stp_codigo'));
			?>
		<td>
			Titulo:
				<input type="text" name="pro_titulo" value="<?php echo($busca->getDados('pro_titulo')); ?>">
		
			Descri��o:
				<input type="text" name="pro_descricao" size="50" value="<?php echo($busca->getDados('pro_descricao'));?>">
		</td>				

		<?php 
		
		$DataGrid->exportarExcel('ListaDeProjeto','listarProjeto',1); 
		
		?>

		<td>
			<input type="submit" value="Pesquisar" />
		</td>
	</tr>
</table>
</fieldset>
</form>
<br />
<?php


/*echo '<pre>';
print_r($_SESSION);
echo '</pre>';*/

Arquivo::includeForm();


try
{
	
	$DataGrid->setDados($busca->listarProjeto());
	
	$DataGrid->titulofield = 'Projeto(s)';

	$DataGrid->nomelink2 = '<img src="./css/images/search2.png" title="Abrir" />';
	$DataGrid->acao2 = 'alterar/Projeto';
	$DataGrid->islink2 = true;
	$DataGrid->link ='DetalheProjeto.php?'.base64_encode('pro_codigo');
	$DataGrid->targetEnable = true;

	$DataGrid->nomelink = '<img src="./css/images/projeto.png" title="Painel de Projeto" />';
	$DataGrid->acao = '';

	
	$DataGrid->mostrarDatagrid();

}catch (Exception $e)
{
	echo $e->getMessage();
}
Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menusecundario.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");

?>

