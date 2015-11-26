<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');


/*$data = '17-11-2015';
//$data = '17.11.2015';

//$data = '17-11-2015 12:15:05';

$data = str_replace('/','-',$data);

echo date('Y-m-d',strtotime($data));

echo PHP_EOL;
*/

$tb = new TbCadastroRnc();

$dados['data1'] = '2015-11-01';
$dados['data2'] = '2015-11-26';

$tb->getGraficoRncByDepartamento($dados);

?>