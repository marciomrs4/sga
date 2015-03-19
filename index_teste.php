<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');



$tabela = new createTables();

$tabela->tabela = 'tb_apontamento_melhoria';

$tabela->generateAll();


//Sessao::mostrarSessao();


?>