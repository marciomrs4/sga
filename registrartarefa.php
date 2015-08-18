<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

//resolve o problema de acentos
header('Content-Type: text/html; charset=ISO-8859-1');


$tarefa = filter_var($_POST['post_tarefa']);

if($tarefa == ''){
    exit('Erro ao inserir');
}

$tbtarefa = new TbTarefas();

$dados['usu_codigo'] = $_SESSION['usu_codigo'];
$dados['dep_codigo'] = $_SESSION['dep_codigo'];
$dados['tar_descricao'] = utf8_decode($tarefa);
$dados['tar_data'] = date('Y-m-d H:i:s');


try{

    $tbtarefa->insert($dados);

}catch (\PDOException $e){
    echo $e->getMessage();
}

$dataGrid = new Grid();
$dataGrid->colunaoculta = 1;

$dataGrid->setDados($tbtarefa->listarTarefas($dados)->fetchAll(\PDO::FETCH_ASSOC))
         ->setCabecalho(array('Descriчуo','Data'))
         ->addFunctionColumn(function($var){

             $date = new DateTime($var);
             return $date->format('d-m-Y H:i:s');

         },2)
         ->show();

?>