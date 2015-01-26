<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');

/* 
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
 */

function getSecunds($hora)
{
	$horaParte = explode(':', $hora);
	
	$horasEmSegundo = ($horaParte['0'] * 3600) + ($horaParte['1'] * 60) + $horaParte['2'];
	
	return $horasEmSegundo;
}

/* $horaProblema = '24:00:00';

$horaSLA = '141:51:42';

$diaUtil = new dateOpers();

$horaProblema = getSecunds($horaProblema);

$horaSLA = getSecunds($horaSLA);
 */

$horaUtil = '197:03:54';

$horaProblema = '24:00:00';

 $horaUtil = getSecunds($horaUtil);

$horaProblema = getSecunds($horaProblema); 


if($horaUtil <= $horaProblema){
	echo 'Dentro';
	
}else{
	echo 'Fora';
}

/* echo '<br />',$horaProblema,' - ' ,$horaSLA;

echo '<br />',$diaUtil->hourToSec($horaProblema),'<br />';

echo '<br />',$diaUtil->hourToSec($horaSLA),'<br />'; */


?>