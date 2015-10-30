<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');


$at_codigo = 1015;
$ap_descricao = 'Criado Descricao do apontamento aqui';
$sta_codigo = 2;

$tbAtividade = new TbAtividade();
$tbProjeto = new TbProjeto();
$tbUsuario = new TbUsuario();
$tbStatusAtividade = new TbStatusAtividade();

$tbUsuarioAtividade = new TbUsuarioAtividade();

$projeto = $tbAtividade->getProCodigo($at_codigo);

$projeto = $tbProjeto->getDescricaoProjeto($projeto['pro_codigo']);

$usuario = $tbUsuario->getUsuario($_SESSION['usu_codigo']);


$cabecalho = "<b>Andamento do projeto: {$projeto['pro_titulo']}</b>";

echo $cabecalho, '<br><br>';

$mensagem = '';
$mensagem .= '<b>Houve um novo apontamento:</b><br>';
$mensagem .= "<b>Titulo do Projeto:</b> {$projeto['pro_titulo']} <br>";
$mensagem .= "<b>Número da atividade: </b> {$at_codigo} <br><br>";
$mensagem .= "<b>Criado por: </b>" . $usuario['usu_nome'] .' '. $usuario['usu_sobrenome'] .' | ' . $usuario['usu_email'] . "<br><br>";
$mensagem .= '<b>Descrição do apontamento:</b> <br>';
$mensagem .= "{$ap_descricao}<br><br>";
$mensagem .= "<b>Status da Atividade: </b> {$tbStatusAtividade->getDescricao($sta_codigo)}";

echo $mensagem, '<br><br>';

foreach($tbUsuarioAtividade->getEmailUsuarioByInformadoOrConsultado($at_codigo, 1) as $email){
    echo $email['usu_email'], '<br>';
}

foreach($tbUsuarioAtividade->getEmailUsuarioByInformadoOrConsultado($at_codigo, 2) as $email){
    echo $email['usu_email'], '<br>';
}

foreach($tbProjeto->getEmailUsuarioByProjeto($projeto['pro_codigo']) as $email){
    echo $email['usu_email'],'<br>';
}


echo '<br><br>####################################################### <br><br>';
$cabecalho = '<b>Andamento do projeto: {titulo_projeto}</b>';

echo $cabecalho, '<br><br>';

$mensagem = '';
$mensagem .= '<b>Houve um novo apontamento:</b><br>';
$mensagem .= '<b>Titulo do Projeto:</b> {titulo_projeto} <br>';
$mensagem .= '<b>Número da atividade: </b> {numero} <br><br>';
$mensagem .= '<b>Criado por: </b> {usuario} | {email} <br><br>';
$mensagem .= '<b>Descrição do apontamento:</b> <br>';
$mensagem .= '{descricao}<br><br>';
$mensagem .= '<b>Status da Atividade: </b> {status}';

echo $mensagem;

?>