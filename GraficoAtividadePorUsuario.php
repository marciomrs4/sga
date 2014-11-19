<?php
include_once($_SERVER['DOCUMENT_ROOT']."/SGA/componentes/config.php");

ControleDeAcesso::permitirAcesso(array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico));

include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/componentes/script.php");

//Texto::mostrarMensagem(Texto::erro($_SESSION['sempermissao']));

Texto::criarTitulo('Relatório: Grafico');

?>
<div>
	<?php include_once 'GraficoUsuario.php'; ?>
</div>
<?php 




Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/menurelatorio.php");
include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/componentes/rodape.php");

?>