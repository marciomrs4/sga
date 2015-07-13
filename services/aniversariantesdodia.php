<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');


if($_GET['id'] == base64_encode(date('d-m-Y').'M')) {

    $id = filter_input(INPUT_GET,'id');
    $unidade = filter_input(INPUT_GET,'unidade');

    $TbAniversariante = new TbAniversariante();

    $lista = array();

    foreach ($TbAniversariante->listAniversarianteDia($unidade) as $array)
    {
        $lista[] = array_map('utf8_encode', $array);
    }

    echo json_encode($lista);

}
?>

