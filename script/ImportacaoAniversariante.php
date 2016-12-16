<?php
date_default_timezone_set('America/Sao_Paulo');

include_once '../model/Banco.class.php';
include_once '../model/TbAniversariante.class.php';
include_once '../classes/ClasseException.class.php';
include_once '../classes/ValidarDatas.class.php';


$tbAniversariante = new TbAniversariante();

$file = file('../tests/niver_2016.csv');


$tbAniversariante->truncateTable();


foreach($file as $linhas){

    $linha = explode(';',$linhas);

    $dados['seq'] = $linha[0];
    $dados['ani_drt'] = $linha[1];
    $dados['ani_nome'] = $linha[2];
    $dados['ani_setor'] = $linha[3];
    $dados['ani_data_nascimento'] = ValidarDatas::dataBanco($linha[4]);
    $dados['ani_dia'] = $linha[5];
    $dados['ani_mes'] = $linha[6];
    $dados['ani_ano'] = $linha[7];
    $dados['ani_unidade'] = $linha[8];

    print_r($dados);

    echo $tbAniversariante->insert($dados),PHP_EOL;

}

?>