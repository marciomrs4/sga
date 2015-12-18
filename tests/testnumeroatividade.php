<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

$tbAtividade = new TbAtividade();

echo $tbAtividade->getNumeroAtividadeProjeto(214)+1;

?>