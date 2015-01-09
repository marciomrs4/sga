<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');


#677

$data1 = '2014-12-08 11:55:52';

$data2 = '2015-01-05 17:05:19';

$hora_ini = '8';
$hora_fim = '18';

#Até o esse horario do almoço
$meio_dia = '14';
$sabado   = '9';
$saida    = 'H';


$validador = new dateOpers();


$retorno = $validador->tempo_valido($data1, $data2, $hora_ini, $hora_fim, $meio_dia, $sabado, $saida);


echo $retorno;

?>