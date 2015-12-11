<?php
include_once($_SERVER['DOCUMENT_ROOT']."/sga/componentes/config.php");

ControleDeAcesso::permitirAcesso(array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico));

include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/componentes/script.php");



$busca = new Busca();

$busca->validarPost($_POST);

?>

	<form action="" method="post">
		<fieldset>
			<legend>Pesquisar</legend>
			<table border="0">
				<tr>
					<td>
						Período: De <input type="text" name="data1" class="data" id="data-id" size="10" value="<?php echo($busca->getDados('data1'));?>">
						à <input type="text" name="data2" class="data" id="data" size="10" value="<?php echo($busca->getDados('data2'));?>">
					</td>
					<td>
						<input type="submit" value="Pesquisar" />
					</td>
				</tr>
			</table>
		</fieldset>
	</form>
<hr/>
	<fieldset>
		<legend>Chamados por Departamento</legend>
		<div>
			<?php include_once 'GraficoQuantidadeChamadoAbertoPorAreaInclude.php'; ?>
		</div>
	</fieldset>
<?php




Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/menurelatorio.php");
include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/componentes/rodape.php");

?>