<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/sga/componentes/config.php');
$ControleAcesso = new ControleDeAcesso();
$ControleAcesso->permitirAcesso(array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico));

include_once 'componentes/TopoPainelUsuarioFinal.php';

$busca = new Busca();

$busca->validarPost($_POST);

$busca->setValueGet($_GET,'usu_codigo');

$tbUsuario = new TbUsuario();

?>

    <div class="container-fluid">
        <div class="col-xs-12">


            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="glyphicon glyphicon-calendar"></span> Filtros
                    </h3>
                </div>
                <div class="panel-body">

                    <form class="form-inline" action="" method="post">
                        <input type="hidden" name="usu_codigo_responsavel" value="<?php echo $busca->getValueGet('usu_codigo'); ?>">
                        <div class="form-group">
                            <label for="exampleInputEmail3">Data Inicial:</label>
                            <input type="date" name="data1" class="form-control" value="<?php echo $busca->getDados('data1'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword3">Data Final:</label>
                            <input type="date" name="data2" class="form-control" value="<?php echo $busca->getDados('data2'); ?>">
                        </div>

                        <button type="submit" class="btn btn-default">Pesquisar</button>
                    </form>

                    <?php
                    if($erro){
                        ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $erro; ?>
                        </div>
                        <?php
                    }
                    ?>



                </div>
                <div class="panel-footer">
                </div>
            </div>


            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-th-list"></span>
                        Usuário: <?php $User = $tbUsuario->getUsuario($busca->getValueGet('usu_codigo'));
                        echo $User['usu_nome'] . ' ' . $User['usu_sobrenome'],
                        ' | Total de Atividades: ', $busca->getTotalAtividadeUsuario();
                        ?>
                    </h3>
                </div>

                <div class="panel-body">

                    <?php
                    $DataGrid = new Grid();

                    $DataGrid->setCabecalho(array('#','Atividade','Titulo Projeto','Prev. Inicio','Prev. Fim','Status','Prazo'));

                    $DataGrid->setDados($busca->listarAtividadeProjetoByUserFinal());

                    $DataGrid->id = null;

                    $DataGrid->addFunctionColumn(function($x){
                        $btn = "<button value='{$x}' id='atividade' type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#myModal' title='Ver Atividade'>
                                <span class='glyphicon glyphicon-eye-open'></span>
                                </button>";
                        return $btn;
                    },0);



                    $DataGrid->addFunctionColumn(function($x){

                        $data = explode('|',$x);

                        $calculatePercent = new CalculatePercent($data['0'],$data['1'],$data['2']);

                      return "<button type='button' class='btn btn-{$calculatePercent->getColor()} btn-sm btn-block' disabled>
                                <span class='glyphicon glyphicon-{$calculatePercent->getSimbol()}'></span>
                              </button>";


                    },6);

                    $DataGrid->addFunctionColumn(function($data){
                        return date('d-m-Y',strtotime($data));
                    },3);

                    $DataGrid->show(true);

                    ?>

                </div>
                <div class="panel-footer"></div>
            </div>
        </div>

        <div class="col-xs-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"></h3>
                </div>
                <div class="panel-body">
                        <div id="atividadeaberta"></div>
                </div>
                <div class="panel-footer"></div>
            </div>
        </div>

        <div class="col-xs-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"></h3>
                </div>
                <div class="panel-body">
                    <div id="atividadeconcluido"></div>
                </div>
                <div class="panel-footer"></div>
            </div>
        </div>

    </div>

<?php
include_once './componentes/footerPainelUsuarioFinal.php';
?>