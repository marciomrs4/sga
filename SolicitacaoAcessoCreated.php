<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

$id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);


$tbSolicitacaoAcesso = new TbSolicitacaoAcesso();

$dados = $tbSolicitacaoAcesso->select($id)->fetch(\PDO::FETCH_OBJ);

$formulario = json_decode($dados->formulario);

print_r($formulario);

//include_once 'forms/formsolicitacao.php';