<?php
#Seto o time zone como s?o paulo
date_default_timezone_set('America/Sao_Paulo');

include_once '../model/Banco.class.php';
include_once '../model/TbSolicitacao.class.php';


$data = new \DateTime('now');

$dataDia = $data->format('d');


if($dataDia == 07){

    $tbSolicitacao = new TbSolicitacao();

    $dados['data'] = $data->format('Y-m-d');
    //$dados['data'] = '2015-09-21';
    $tbSolicitacao->marcarChamadoComoNaoAvaliado($dados);

    echo 'Chamados marcados como não atendidos';


}else{

    echo 'Não houveram chamados marcados';
}



?>