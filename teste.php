<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

/*$QL = (php_sapi_name() == 'cli') ? PHP_EOL : '<br>';

echo '__DIR__',__DIR__,$QL,$QL;

echo 'dirname(__DIR__)',dirname(__DIR__),$QL,$QL;

echo 'realpath(__DIR__)',realpath(__DIR__),$QL,$QL;


echo '__FILE__',__FILE__,$QL,$QL;

echo 'dirname(__FILE__)',dirname(__FILE__),$QL,$QL;

echo 'realpath(__FILE__)',realpath(__FILE_r_),$QL,$QL;

echo '$_SERVER[DOCUMENT_ROOT]',$_SERVER['DOCUMENT_ROOT'],$QL,$QL;

print_r(pathinfo(__DIR__));*/


$id = base64_encode(date('d-m-Y').'M');
$unidade = 1; //ceadis

$dados = file_get_contents('http://localhost/sga/services/aniversariantesdodia.php?unidade='.$unidade.'&id='.$id);

$dados = json_decode($dados);

foreach($dados as $arrays){
    foreach($arrays as $array){
        echo $array , '<br>';
    }
}

//print_r($dados);

?>