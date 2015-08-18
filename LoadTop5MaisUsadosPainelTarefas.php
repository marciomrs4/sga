<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

//resolve o problema de acentos
header('Content-Type: text/html; charset=ISO-8859-1');

$tbTarefas = new TbTarefas();

$dados['usu_codigo'] = $_SESSION['usu_codigo'];


echo '<div class="list-group">';

    foreach($tbTarefas->listarTarefasMaisUsadas($dados)->fetchAll(\PDO::FETCH_OBJ) as $tarefas):

        echo '<a href="#" class="list-group-item">' . $tarefas->tar_descricao . '</a>';

    endforeach;

echo '</div>';
?>