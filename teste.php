<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

/*
$TbTeste = new TbTabela_TESTE();

$oper = new dateOpers();

//print_r($TbTeste->listarSolicitacaoTerceiro()->fetchAll());

foreach($TbTeste->listarSolicitacaoTerceiro() as $valor){

    print_r($linhas);
    echo '<br>';

    echo $valor['sot_codigo'],' - ', $valor['sol_codigo'],' - ' , $valor['sot_data_inclusao'],' - ',
         $valor['sot_data_remocao'],' - UTIL: ',$valor['sot_tempo_util'],' - ';

        $horas = $TbTeste->getHoraDepartamento($valor['sol_codigo']);

        echo '(',$horas['dep_hora_inicio'],' - ',$horas['dep_hora_fim'],' - ',$horas['dep_hora_almoco'],' - ',$horas['dep_carga_sabado'],')';

        $data1 = $valor['sot_data_inclusao'];

        $data2 = $valor['sot_data_remocao'];

         #Hora Inicial
        $hora_ini = $horas['dep_hora_inicio']; //'08';
        #Hora Final
        $hora_fim = $horas['dep_hora_fim']; //'18';

        #At? o esse horario do almo?o
        $meio_dia = $horas['dep_hora_almoco']; //'13';
        #Horas de sabados
        $sabado   = $horas['dep_carga_sabado']; //'00';

        #Tipo de Saida em horas
        $saida = 'H';

        $tempoutil = $oper->tempo_valido($data1, $data2, $hora_ini, $hora_fim, $meio_dia, $sabado, $saida);

        echo ' Tempo Util: ', $tempoutil ,'<br>';

    try {

       # $TbTeste->updateEnvioTerceiro($valor['sot_codigo'], $tempoutil);

    }catch (\Exception $e){
        echo $e->getMessage();
    }

/*    foreach($linhas as $valor){
        echo $valor['sot_codigo'],' - ', $valor['sol_codigo'],' - ' , $valor['sot_data_inclusao'],' - ',$valor['sot_data_remocao'],' - ',$valor['sot_tempo_util'],'<br>';
    }



}


print_r($TbTeste->getHoraDepartamento(13433));

*/




?>