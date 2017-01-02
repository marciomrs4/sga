<?php
#Seto o time zone como s?o paulo
date_default_timezone_set('America/Sao_Paulo');

include_once '../model/Banco.class.php';
include_once '../model/TbSolicitacao.class.php';


$data = new \DateTime('now');
$tbSolicitacao = new TbSolicitacao();

    $data->modify('-7 days');

    $dados['data'] = $data->format('Y-m-d').' 23:59:59';

    $tbSolicitacao->marcarChamadoComoNaoAvaliado($dados);

    echo 'Chamados marcados como não atendidos';

?>