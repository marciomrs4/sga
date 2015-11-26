<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');



//resolve o problema de acentos
//header('Content-Type: text/html; charset=ISO-8859-1');

$tbAtividade = new TbAtividade();

$dados['pro_codigo'] = 211;//$_POST["pro_codigo"];
$dados['at_codigo'] = ($_POST["at_codigo"] == '') ? '' : $_POST["at_codigo"];

echo ('<option value="">Nenhuma</option>');

foreach ($tbAtividade->listarAtividadeDependente($dados)->fetchAll(\PDO::FETCH_ASSOC) as $linha):

    echo ('<option value='.$linha['at_codigo'].'>'.$linha['at_descricao'].'</option>');

endforeach;


?>