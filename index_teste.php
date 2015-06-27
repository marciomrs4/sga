<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');


$tabela = new createTables();

$tabela->tabela = 'tb_departamento';

$tabela->generateAll();


//Sessao::mostrarSessao();


?>