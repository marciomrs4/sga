<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

/*$dir = '../files/projetos/10/';

if(!move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir . $_FILES['arquivo']['name']))
{
    echo 'Houve erro ao enviar o arquivo','<br>';
}

echo getcwd().DIRECTORY_SEPARATOR.basename($_FILES['arquivo']['tmp_name']);*/



$codigo = rand(11,100).'/';

$createDir = new DirectoryCreate();
$createDir->createDirProjetos($codigo);

$dir = new FileUpload();

echo $dir->setFile($_FILES['arquivo']['tmp_name'])
->setDestination(DirectoryCreate::PATH.DirectoryCreate::PROJETOS.$codigo.$_FILES['arquivo']['name'])
->moveUploaded()
->getErro(),'<br>';

$LerDir = new DirectoryIterator(DirectoryCreate::PATH.DirectoryCreate::PROJETOS.$codigo);

foreach($LerDir as $obj){
    if($obj->isDot()){ continue; }
    echo $obj->getFilename(),'<br>';
}


?>