<?php
include_once '../classes/DirectoryCreate.class.php';
include_once '../classes/FileUpload.class.php';
include_once '../classes/FileCopy.class.php';

$chamado = '14337';
$rnc = '16';


$fileCopy = new FileCopy();

$fileCopy->setChamado($chamado)->setRnc($rnc)->copyChamadoToRnc();




?>
