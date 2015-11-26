<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

$ControleAcesso = new ControleDeAcesso();
$ControleAcesso->permitirAcesso(array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico,ControleDeAcesso::$Solicitante));

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");

$busca = new Busca();

$busca->validarPost($_POST);

echo"<div class='sub_menu_principal'>";
Texto::criarTitulo("Buscar Rnc");
echo "</div>";


try
{

?>
<form action="" method="post">
<fieldset>
	<legend>Pesquisar Rnc</legend>
<table border="0">
	<tr>
	</tr>
	<tr>
		<td>
			Número da Rnc:
				<input type="text" name="rnc_codigo" value="<?php echo($busca->getDados('sol_codigo')); ?>">
		</td>
		<td>
			<input type="submit" value="Pesquisar" />
		</td>
	</tr>
</table>
</fieldset>
</form>
<br />

<?php

}catch (Exception $e)
{
	Texto::mostrarMensagem(Texto::letterRed($e->getMessage()));
}

Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menuqualidade.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");

?>