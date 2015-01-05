<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');




$data_1 = '2014-01-01 11:53:06';

$data_2 = '2014-02-17 14:35:20';



#Um minuto = 60 segundos

#Uma hora = 60 * 60 = 3600

#Um dia = 3600 * 24 = 86400



#Integral = 0

#Meio periodo = 43200

#Nao trabalhado = 86400

$Sabado = 86400;



$DiasEmFeriado = array('2014-01-25 00:00:01');



$QtdDiasEmSegundos = strtotime($data_2) - strtotime($data_1);



$diasPassados = $QtdDiasEmSegundos/86400;



echo $diasPassados.'<br /><br />';



//echo date('N,D, j',strtotime($data_1));



$inicio = 0;



$dataInicio = strtotime($data_1);



$diaSegundo = 86400;



$DiasDomingos = 0;



$qtdHorasDescontar = 0;



//echo $dataInicio;



for($x=$inicio;$x<=$diasPassados;$x++){





$domingo = date('N',$dataInicio);



if($domingo == 7){

echo date('Y-m-d H:i:s',$dataInicio),'<br />';

$DiasDomingos++;

}



#Verifica a Lista de feriados

foreach($DiasEmFeriado as $valor){



$domingo = date('N',$valor);



if($domingo == 7){

echo date('Y-m-d H:i:s',$valor),'<br />';

	$DiasDomingos++;

}

}



$segundoDescontar = $DiasDomingos * $diaSegundo;



$qtdHorasDescontar = $segundoDescontar;





		$dataInicio += $diaSegundo;

}



echo $DiasDomingos, '- Dias em segundos: ',$qtdHorasDescontar;





?>