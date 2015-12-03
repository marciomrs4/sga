<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/sga/componentes/config.php');
include_once 'componentes/TopoPainelUsuarioFinal.php';

$busca = new Busca();

$busca->setValueGet($_GET,'usu_codigo');

$tbUsuario = new TbUsuario();

$tbAtividade = new TbAtividade();

?>

    <div class="container-fluid">
        <div class="col-xs-12">

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-th-list"></span>
                        Usuário: <?php $User = $tbUsuario->getUsuario($busca->getValueGet('usu_codigo'));
                        echo $User['usu_nome'] . ' ' . $User['usu_sobrenome'],
                        ' | Total de Atividades: ', $tbAtividade->getQuantidadeAtividadeByUser($busca->getValueGet('usu_codigo'));
                        ?>
                    </h3>
                </div>

                <div class="panel-body">

                 <?php
                 $DataGrid = new Grid();

                 $DataGrid->setCabecalho(array('#','Atividade','Titulo Projeto','Prev. Inicio','Prev. Fim','Status'));

                 $DataGrid->setDados($tbAtividade->listarAtividadeProjetoByUser($busca->getValueGet('usu_codigo'))->fetchAll(\PDO::FETCH_NUM));

                 $DataGrid->id = null;

                 $DataGrid->addFunctionColumn(function($x){
                        $btn = "<button value='{$x}' id='atividade' type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#myModal' title='Ver Atividade'>
                                <span class='glyphicon glyphicon-eye-open'></span>
                                </button>";
                        return $btn;
                    },0);

                 $DataGrid->addFunctionColumn(function($data){
                     return date('d-m-Y',strtotime($data));
                 },3);


                 $DataGrid->show(true);




                 ?>

                </div>
                <div class="panel-footer"></div>
            </div>
        </div>
    </div>

<?php
include_once './componentes/footerPainel.php';
?>