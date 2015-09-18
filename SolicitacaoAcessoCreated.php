<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

$get = new Busca();

$get->setValueGet($_GET,'id');

$id = $get->getValueGet('id');

$id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);


$tbSolicitacaoAcesso = new TbSolicitacaoAcesso();
$tbTipoSolicitacaAcesso = new TbTipoSolicitacaoAcesso();
$tbDepartamento = new TbDepartamento();


$dados = $tbSolicitacaoAcesso->select($id)->fetch(\PDO::FETCH_OBJ);

$formulario = unserialize($dados->sac_formulario);

/*echo '<pre>';
print_r($formulario);
echo '</pre>';*/

include_once 'forms/formsolicitacao.php';