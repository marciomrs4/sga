<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

$diaUtil = new dateOpers();

$data1 = '2016-09-12 17:51:23';
$data2 = '2016-10-20 09:40:06';

#Hora Inicial
$hora_ini = '07:00';
#Hora Final
$hora_fim = '19:00';

#At? o esse horario do almo?o
$meio_dia = '13:00';
#Horas de sabados
$sabado   = '08';

#Tipo de Saida em horas
$saida    = 'H';

echo  $diaUtil->tempo_valido($data1, $data2, $hora_ini, $hora_fim, $meio_dia, $sabado, $saida);

/*
 * (select sol_codigo, sot_data_inclusao, sot_data_remocao, sot_tempo_util , 'terceiro' from tb_solicitacao_terceiro where sol_codigo = 23713)
union
(select sol_codigo, sol_data_inicio, sol_data_fim, '339:48:43','chamado' from tb_solicitacao where sol_codigo = 23713);


'23713', '2016-09-13 09:42:44', '2016-09-15 09:25:21', '21:42:37', 'terceiro'
'23713', '2016-09-15 09:30:02', '2016-10-20 09:36:44', '327:06:42', 'terceiro'
'23713', '2016-09-12 17:51:23', '2016-10-20 09:40:06', '339:48:43', 'chamado'


21:42:37

327:06:42
=========
348:49:19
=========
339:48:43
 */

?>