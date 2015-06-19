<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

//resolve o problema de acentos

$TbUsuario = new TbUsuario();

$lista = $TbUsuario->listarRamaisIntranet()->fetchAll(\PDO::FETCH_ASSOC);


/*foreach($lista as $array){

    foreach($array as $valor){
        echo $valor, '-';
    }
    echo '<br/>';
}*/

foreach($lista as $chave => $value){

    #echo 'Chave: ', $chave, ' - ', $value;

    #$NovoArray[$chave];

    foreach($value as $val){

        #echo utf8_encode($val), ' - ';

        $NovoArray[$chave][] = utf8_encode($val);
    }

    #echo '<br/>';


}

#print_r($NovoArray);

echo json_encode($NovoArray);

json_last_error_msg();

?>
