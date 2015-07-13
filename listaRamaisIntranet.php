<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Relatório - Tempo de Solução</title>
    <link rel='stylesheet' type='text/css' href='../<?php echo($_SESSION['projeto']); ?>/css/bootstrap/bootstrap.min.css' />
    <link rel='stylesheet' type='text/css' href='../<?php echo($_SESSION['projeto']); ?>/css/bootstrap/bootstrap-theme.min.css' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="container-fluid">

<?php
echo '<div class="jumbotron">';

//Gera um idenficador unico para validar na chamada
$id = base64_encode(date('d-m-Y').'M');
//Faz a chamada passando o id
$dados = file_get_contents('http://localhost/sga/services/ramais.php?id='.$id);
//Encoda o Json encontrado
$data = json_decode($dados);

//
foreach($data as $info){
    $array[] = array($info->nome,$info->ramal,$info->email,$info->departamento);
}

$grid = new Grid();
$grid->setCabecalho(array('Nome','Ramal','Email','Departamento'))
     ->setDados($array)
     ->show();


?>

<script src="../<?php echo($_SESSION['projeto']);?>/jscript/jquery-2.1.4.js"></script>
<script src="../<?php echo($_SESSION['projeto']);?>/jscript/bootstrap.js"></script>
<script src="../<?php echo($_SESSION['projeto']);?>/jscript/my-alert.js"></script>

<script src="../<?php echo($_SESSION['projeto']);?>/jscript/jquery.dataTables.js"></script>
<script src="../<?php echo($_SESSION['projeto']);?>/jscript/tableTools.js"></script>
<script src="../<?php echo($_SESSION['projeto']);?>/jscript/my-data-table.js"></script>

</div>

<!-- Modal -->


</div>

</body>
</html>