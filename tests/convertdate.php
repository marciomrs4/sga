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


echo $tb->getStatus(11);

?>