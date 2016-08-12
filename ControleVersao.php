<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');
$ControleAcesso = new ControleDeAcesso();
$ControleAcesso->permitirAcesso(array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico));
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");
echo"<div class='sub_menu_principal'>";
echo FormComponente::actionButton('<img src="./css/images/versaoadd.png" title="Nova Vers�o"  >','cadastrar/Versao');
Texto::criarTitulo("Controle de Vers�o");
echo "</div>";
$busca = new Busca();
$busca->validarPost($_POST);
?>

	<form action="" method="post">
		<fieldset>
			<legend>Pesquisar Vers�o</legend>
			<table border="0">

				<tr>
					<td>
						Sistema:
						<?php

						$tbcontroleVersao = new TbSistemas();
						$FormStatus = new SelectOption();
						$FormStatus->setStmt($tbcontroleVersao->listarSistemas())
							->setSelectName('sis_codigo')
							->setSelectedItem($busca->getDados('sis_codigo'))
							->setOptionEmpty('TODOS')
							->listOption();

						?>
					</td>
					<td>
						Data de:
						<input type="text" name="data1" class="data" id="data-id" size="10" value="<?php echo($busca->getDados('data1')); ?>" />
						At�
						<input type="text" name="data2" class="data" id="data" size="10" value="<?php echo($busca->getDados('data2')); ?>"	/>
					</td>

					<td>
						<input type="submit" value="Pesquisar" />
					</td>
				</tr>
			</table>
		</fieldset>
	</form>

<?php
Arquivo::includeForm();

$DatagridVersao = new DataGrid();
$cabecalho = array('Sistema', 'Vers�o', 'Data', 'Aprovado Por');
$DatagridVersao->setCabecalho($cabecalho);
$DatagridVersao->setDados($busca->listarVersoes());
$DatagridVersao->titulofield = 'Registro(s) de Vers�o';
$DatagridVersao->colunaoculta = 1;
$DatagridVersao->acao = 'alterar/AlterarVersao';
$DatagridVersao->nomelink = '<img src="./css/images/search2.png" title="Abrir" />';
$DatagridVersao->mostrarDatagrid();

Sessao::finalizarSessao();
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menusecundario.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");
?>