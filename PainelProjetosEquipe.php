<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/sga/componentes/config.php');


include_once 'componentes/TopoPainelProjetosEquipe.php';

$_SESSION['dep_codigo'] = ($_SESSION['dep_codigo'] == '') ? $_GET['dep_codigo'] : $_SESSION['dep_codigo'];

$tbDepartamento = new TbDepartamento();
?>

<div class="container-fluid">
    <div class="col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-user"></span>
                    USUÁRIOS <?php echo mb_strtoupper($tbDepartamento->getDepDescricao($_SESSION['dep_codigo'])); ?>
                </h3>
            </div>
            <div class="panel-body">
                <?php
                $tbUsuario = new TbUsuario();
                $tbProjetos = new TbProjeto();

                $dados['dep_codigo'] = $_SESSION['dep_codigo'];
                $Usuarios = $tbUsuario->listarUsuariosPainelAtividade($dados);

                foreach($Usuarios as $user):
                    ?>
                    <div class="col-xs-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo(ucfirst($user['usu_nome'])); ?></h3>
                            </div>
                            <div class="panel-body">
                                <p class="text-info">Total de projetos: <?php echo $tbProjetos->getQuantidadeProjetoByUsuarioResponsavel($user['usu_codigo']); ?></p>
                                <p class="text-info">Total de atividades: <?php echo($user['qtd']); ?></p>
                                <p class="text-info">Menor data de Atividade: <?php echo($user['at_previsao_inicio']); ?></p>
                                <p class="text-info">Maior data de Atividade: <?php echo($user['at_previsao_fim']); ?></p>
                                <a href="PainelProjetosUsuarioFinal.php?qwertyuiop=<?php echo base64_encode($user['usu_codigo']); ?>">
                                    <button type="button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-share-alt" aria-hidden="true">

                                        </span> Atividades</button></a>
                            </div>
                            <div class="panel-footer"></div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
            <div class="panel-footer"></div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-picture"></span>
                </h3>
            </div>
            <div class="panel-body">

                <div class="col-xs-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title"><span class="glyphicon glyphicon-picture"></span>
                                Atividade por status (Pendente e Em Andamento)
                            </h3>
                        </div>
                        <div class="panel-body">

                            <div id="atividadeporstatus"></div>

                        </div>
                        <div class="panel-footer"></div>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title"><span class="glyphicon glyphicon-picture"></span>
                                Quantidade de Atividade por usuário (Pendente e Em Andamento)
                            </h3>
                        </div>
                        <div class="panel-body">

                            <div id="atividadeporresponsavel"></div>

                        </div>
                        <div class="panel-footer"></div>
                    </div>
                </div>

            </div>
            <div class="panel-footer"></div>
        </div>
    </div>
</div>

<?php
include_once 'componentes/footerPainel.php';
?>
