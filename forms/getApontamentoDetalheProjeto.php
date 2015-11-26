<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

header('Content-Type: text/html; charset=ISO-8859-1');

$tbApontamento = new TbApontamentoProjeto();

$DataGrid = new Grid();

$DataGrid->setDados($tbApontamento->listarApontamento($_POST['ap_codigo'])->fetchAll(\PDO::FETCH_ASSOC))
         ->setCabecalho(array('Descrição','Data','Usuário'));

$Panel = new Painel();
$Panel->addGrid($DataGrid)
      ->setPainelTitle('Apontamento(s) do projeto.')
      ->show();




?>

