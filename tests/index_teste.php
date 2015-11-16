<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

$validate = new dateOpers();

//'chamado', '2015-07-13 14:56:29', '2015-07-21 14:59:34' / 13436
//	     '2015-07-13 14:56:29 | 2015-07-21 14:59:34',

//'terceiro', '2015-07-15 11:12:22', '2015-07-21 14:58:10'

//Obtem o tempo de entrada, saida, almoco e sabado do Departamento
$TbDepartamento = new TbDepartamento();
$TempoDepartamento = $TbDepartamento->getAllHours(1234);

//Chamado
$data1 = '2015-07-15 11:12:22';
$data2 = '2015-07-21 14:58:10';
#$data2 = date('Y-m-d H:i:s');
//Terceiro
//$data1 = '2015-07-15 08:00:00';
//$data2 = '2015-07-20 18:00:00';


//Hora de Inicio do departamento
$hora_ini = ($TempoDepartamento['dep_hora_inicio'] == '') ? '08' : $TempoDepartamento['dep_hora_inicio'];
//Hora Fim do departamento
$hora_fim = ($TempoDepartamento['dep_hora_fim'] == '') ? '18' : $TempoDepartamento['dep_hora_fim'];
//Hora de almoco departamento
$meio_dia = ($TempoDepartamento['dep_hora_almoco'] == '') ? '13' : $TempoDepartamento['dep_hora_almoco'];
//Carga horaria de sabado departamento
$sabado = ($TempoDepartamento['dep_carga_sabado'] == '') ? '00' : $TempoDepartamento['dep_carga_sabado'];
//Formato de saida H (em horas)
$saida = 'H';

/*#Hora Inicial
$hora_ini = '08';
#Hora Final
$hora_fim = '18';

#At? o esse horario do almo?o
$meio_dia = '13';
#Horas de sabados
$sabado   = '00';

#Tipo de Saida em horas
$saida = 'H';*/

$horaUtil = $validate->tempo_valido($data1, $data2, $hora_ini, $hora_fim, $meio_dia, $sabado, $saida);


echo $horaUtil,PHP_EOL;


?>