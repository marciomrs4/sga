<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");

ControleDeAcesso::permitirAcesso(array(ControleDeAcesso::$TecnicoADM));

Texto::criarTitulo('Administração');

Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menuadministrativo.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");
?>