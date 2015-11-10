<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');


$dataInicial = '2015-10-20';
$dataFinal = '2015-10-20 00:00:00';
$dataAtual = '2015-11-09 11:07:57';

/*$dataIni = new DateTime($dataInicial);

$dataFim = new DateTime($dataFinal);

$dataHoje = new DateTime($dataAtual);

$totalDias = $dataIni->diff($dataFim)->days + 1;

$totalParcial = $dataIni->diff($dataHoje)->days + 1;

$valorPencentual =  $totalParcial / $totalDias;

$percentual = sprintf('%.2f', $valorPencentual * 100);


echo 'Data Inicial: ', $dataInicial, ' Data Final: ', $dataFinal, ' Data Hoje: ', $dataAtual, '<br><br>';

echo '<br>Total dias: ', $totalDias, ' Parcial: ', $totalParcial, ' Percetual: ', $percentual;*/



$Calculate = new CalculatePercent($dataInicial, $dataFinal, $dataAtual);


echo $Calculate->getPercent(), $Calculate->getColor(), '<br>';

?>