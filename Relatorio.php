<?php
include_once($_SERVER['DOCUMENT_ROOT']."/sga/componentes/config.php");

ControleDeAcesso::permitirAcesso(array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico, ControleDeAcesso::$Solicitante));

include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/componentes/script.php");

Texto::mostrarMensagem($_SESSION['sempermissao']);

Texto::criarTitulo("Relatório");
?>

<?php 

Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/menurelatorio.php");
include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/componentes/rodape.php");

?>