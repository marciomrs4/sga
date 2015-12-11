<?php
include_once 'componentes/TopoPainelProjeto.php';
$tbUsuarioProjeto = new TbUsuarioProjeto();

$tbProjeto = new TbProjeto();
?>

    <div class="container-fluid">
        <div class="col-sm-12">

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="glyphicon glyphicon-th-large"></span> Total de Projeto(s) em andamento: <?php echo $tbUsuarioProjeto->countProjectByUser($_SESSION['usu_codigo']); ?>
                    </h3>
                </div>
                <div class="panel-body">

                    <p class="text-center">
                        LEGENDA DOS PROJETOS -
                        <span class="label label-success"> &nbsp;</span>&nbsp; Dentro do prazo &nbsp;
                        <span class="label label-warning"> &nbsp;</span>&nbsp; Estourando o prazo &nbsp;
                        <span class="label label-danger"> &nbsp;</span>&nbsp; Fora do prazo &nbsp;
                    <hr>



                    <?php
                    foreach ($tbUsuarioProjeto->findProjetoByUsers($_SESSION['usu_codigo']) as $projeto):

                        $dadosProjeto = $tbProjeto->getInfoPainelProjeto($projeto['pro_codigo']);

                        $calculatePercent = new CalculatePercent($dadosProjeto['pro_previsao_inicio'], $dadosProjeto['pro_previsao_fim']);
                        ?>
                        <div class="col-xs-6">
                            <div class="panel panel-<?php echo $calculatePercent->getColor(); ?>">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <div class="list-group">
                                            <div class="list-group-item">Projeto: <?php echo $dadosProjeto['pro_titulo']; ?> </div>
                                            <div class="list-group-item">Responsável: <?php echo $dadosProjeto['responsavel']; ?></div>
                                            <div class="list-group-item">Departamento: <?php echo $dadosProjeto['departamento'] ?></div>
                                            <div class="list-group-item">Status: <?php echo $dadosProjeto['status'] ?></div>


                                                <a href="DetalheProjeto.php?<?php echo base64_encode(pro_codigo) ?>=<?php echo base64_encode($projeto['pro_codigo']); ?>">
                                                    <button type="button" class="btn btn-primary btn-sm">
                                                        <span class="glyphicon glyphicon-plus"></span> Detalhes do Projeto
                                                    </button>
                                                </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                    endforeach;
                    ?>
                </div>
                <div class="panel-footer"></div>

            </div>
        </div>
    </div>


<?php
include_once 'componentes/footerPainel.php';
?>