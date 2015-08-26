<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

$id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);

/*$tabela = new TbTabela();

$dados = $tabela->select($id)->fetch(\PDO::FETCH_OBJ);

$formulario = json_decode($dados->formulario);*/

$chamado = rand(1,100);



/*echo '<pre>';

print_r($dados);

echo '<br>';

print_r($formulario);

echo $formulario->nome_solicitante,'<br>';

echo $formulario->email_solicitante,'<br>';

echo $formulario->observacao,'<br>';

echo $formulario->cargo_solicitante,'<br>';

echo $formulario->sobre_nome_usuario,'<br>';

echo '</pre>';*/

include_once 'forms/formsolicitacao.php';