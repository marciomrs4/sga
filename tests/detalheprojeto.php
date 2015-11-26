<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');


$tbAtividade = new TbAtividade();

echo $pro_codigo = 211;

echo '<pre>';
print_r($tbAtividade->listarAtividadeByProjeto($pro_codigo));
echo '</pre>';

?>