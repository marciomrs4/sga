<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');

$tbAtividade = new TbAtividade();

echo $tbAtividade->validateQtdAtividadeEmAndamento(2);