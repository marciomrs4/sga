<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

header('Content-Type: text/html; charset=ISO-8859-1');

$pro_codigo = $_POST['pro_codigo'];

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Arquivo(s) do Projeto.</h3>
    </div>
    <div class="panel-body">

       <?php

       $diretorio = new DirectoryIterator('../files/projetos/'.$pro_codigo);

       foreach($diretorio as $dir):
           if($dir->isDot()){ continue; }

               ?>
               <div class="col-xs-12">
                   <label class="text-warning">Arquivo:</label> <?php echo substr($dir->getFilename(),0,-4); ?>
                   <a href="action/downloadfile.php?tipo=projetos&codigo=<?php echo($pro_codigo);?>&file=<?php echo $dir->getFilename();?>" target="_blank">
                       <span class="glyphicon glyphicon-circle-arrow-down"></span>
                   </a>
                   <br>
               </div>
        <?php
       endforeach;
        ?>

    </div>
    <div class="panel-footer">
    </div>
</div>