<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/sga/componentes/config.php');
include_once 'componentes/TopoPainelUsuario.php';
?>
	
<div class="container-fluid">   
    <div class="col-xs-12">    
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-user"></span> USUÁRIOS TECNOLOGIA</h3>
            </div>
            <br>
            <div class="panel-body">                                                 
                <?php
                for($x = 0;
                $x<=7;
                $x++):
                ?>
                    <div class="col-xs-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo(ucfirst($_SESSION['usu_nome'])); ?></h3>
                            </div>
                            <div class="panel-body">
                                <p class="text-info">Total de projetos:</p>
                                <p class="text-info">Total de atividades:</p>
                                <a href="#"><button type="button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> Ver Projetos</button></a>
                            </div>
                            <div class="panel-footer"></div>
                        </div>
                    </div>
                <?php endfor;?>                                  
            </div>
            <div class="panel-footer"></div>
        </div>
    </div>
</div>

<?php
include_once 'componentes/footerPainel.php';
?>
