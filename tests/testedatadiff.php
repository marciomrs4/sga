<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');


$dataInicial = '2015-11-23 00:00:00';
$dataFinal = '2015-11-26 00:00:00';
$dataAtual = '2015-11-16 11:07:57';

//'1035', 'Márcio Ramos', 'Pendente', '2015-11-23 00:00:00', '2015-11-26 00:00:00', '2015-11-16 11:05:05'


$Calculate = new CalculatePercent($dataInicial, $dataFinal, $dataAtual);


echo $Calculate->getPercent(), $Calculate->getColor(), '<br>';

$dataInicio = new DateTime($dataInicial);

$dataFinal = new DateTime($dataFinal);

$dataAtual = new DateTime($dataAtual);



$totalDias =  $dataInicio->diff($dataFinal)->days + 1;

$totalDiaParcial = $dataInicio->diff($dataAtual)->days + 1;



if($dataInicio->diff($dataAtual)->invert){
    $totalDiaParcial *= -1;
}

$valorPencentual = $totalDiaParcial / $totalDias;

$percentual = sprintf('%.2f', $valorPencentual * 100);

echo $percentual, ' | ', $totalDias, ' | ', $totalDiaParcial, ' | ', $valorPencentual, ' | ', '<br><br>';

?>