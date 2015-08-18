<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

//resolve o problema de acentos
header('Content-Type: text/html; charset=ISO-8859-1');

$tbChamado = new TbAtendenteSolicitacao();

$dados['usu_codigo_atendente'] = $_SESSION['usu_codigo'];
$dados['sta_codigo'] = 2;


echo '<div class="list-group">';

    foreach($tbChamado->listarChamadosPainelTarefas($dados)->fetchAll(\PDO::FETCH_OBJ) as $chamado):

        echo '<a href="#" class="list-group-item">' . $chamado->chamado . '</a>';

    endforeach;

echo '</div>';
?>