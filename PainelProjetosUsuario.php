<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/sga/componentes/config.php');
include_once 'componentes/TopoPainelUsuario.php';

$busca = new Busca();

$busca->setValueGet($_GET,'usu_codigo');
?>

    <div class="container-fluid">
        <div class="col-xs-12">


            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-calendar"></span>
                        Filtros:
                    </h3>
                </div>
                <div class="panel-body">

                    ...

                </div>
                <div class="panel-footer"></div>
            </div>


            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-user"></span>
                        Usuário : <?php echo $busca->getValueGet('usu_codigo'); ?>
                    </h3>
                </div>

                <div class="panel-body">

                    <?php for($x=0; $x<=10; $x++):?>
                    <div class="col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><span class="glyphicon glyphicon-user"></span> <?php echo(ucfirst($_SESSION['usu_nome'])); ?></h3>
                            </div>
                            <div class="panel-body">

                                ...

                            </div>
                            <div class="panel-footer"></div>
                        </div>
                    </div>
                    <?php  endfor; ?>

                </div>
                <div class="panel-footer"></div>
            </div>
        </div>
    </div>

<?php
include_once './componentes/footerPainel.php';
?>