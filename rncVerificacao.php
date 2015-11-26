<?php
include_once 'componentes/TopoRnc.php';

$buca = new Busca();

$buca->setValueGet($_GET,'nc_codigo');

$tbRnc = new TbCadastroRnc();

$_SESSION['rncGestor'] = $tbRnc->getFormRnc($buca->getValueGet('nc_codigo'));
?>

    <div class="container-fluid">
        <div class="col-xs-12">

            <!-- DESCRI??O RESUMIDA DA RNC -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-check"></span> DESCRIÇÃO DA RNC</h3>
                </div>
                <div class="panel-body">

                    <div class="col-xs-12">
                        <label class="text-info">
                            NÚMERO DA RNC:
                        </label>
                        <?php echo $_SESSION['rncGestor']['nc_codigo'] . '/' .
                            date('y',strtotime($_SESSION['rncGestor']['nc_data_criacao'])); ?>
                    </div>


                    <div class="col-xs-12">
                        <label class="text-info">
                            DESCRIÇÃO DA NÃO CONFORMIDADE:
                        </label>
                        <?php echo $_SESSION['rncGestor']['nc_descricaocompleta']; ?>
                    </div>

                    <div class="col-xs-12">
                        <label class="text-info">
                            LOCAL DA OCORRÊNCIA:
                        </label>
                        <?php echo $_SESSION['rncGestor']['nc_local_ocorrencia']; ?>
                    </div>

                    <div class="col-xs-12">
                        <label class="text-info">
                            DATA DA OCORRÊNCIA:
                        </label>
                        <?php echo ValidarDatas::dataCliente($_SESSION['rncGestor']['nc_data_ocorrencia']); ?>
                    </div>

                    <div class="col-xs-12">
                        <label class="text-info">
                            AÇÃO IMEDIATA:
                        </label>
                        <?php echo $_SESSION['rncGestor']['nc_acao_imediata']; ?>
                    </div>

                </div>
            </div>
            <!-- END DESCRI??O RESUMIDA DA RNC -->

            <!-- GESTOR -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="glyphicon glyphicon-th-list"></span>
                        RESPOSTA DO DEPARTAMENTO
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="col-xs-12">
                        <label class="text-info">
                            CAUSAS:
                        </label>
                        <?php echo $_SESSION['rncGestor']['nc_causas']; ?>
                    </div>

                    <div class="col-xs-12">
                        <label class="text-info">
                            AÇÃO DE MELHORIA:
                        </label>
                        <?php echo $_SESSION['rncGestor']['nc_acao_melhoria']; ?>
                    </div>
                    <div class="col-xs-12">
                        <label class="text-info">
                            PRAZO DE IMPLANTAÇÂO:
                        </label>
                        <?php echo $_SESSION['rncGestor']['nc_prazo_implatacao']; ?>
                    </div>
                    <div class="col-xs-12">
                        <label class="text-info">
                            RESPONSÁVEL IMPLANTAÇÃO:
                        </label>
                        <?php echo $_SESSION['rncGestor']['nc_resp_implantacao']; ?>
                    </div>
                    <div class="col-xs-12">
                        <label class="text-info">
                            DATA DA IMPLANTAÇÃO:
                        </label>
                        <?php echo ValidarDatas::dataCliente($_SESSION['rncGestor']['nc_data_implantacao']); ?>
                    </div>
                </div>
            </div>

            <?php

            if(($_SESSION['rncGestor']['snc_codigo'] == 2) or ($_SESSION['rncGestor']['snc_codigo'] == 3)) {

            ?>

                <!-- Verificação qualidade -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-check"></span> VERIFICACÃO</h3>
                    </div>
                    <div class="panel-body">

                        <form name="rncVerificacao" method="post" action="action/rncVerificacao.php">
                            <input type="hidden" name="nc_codigo"
                                   value="<?php echo($_SESSION['rncGestor']['nc_codigo']); ?>">

                            <div class="col-xs-6">
                                <p class="text-primary">EFICAZ ?</p>

                                <div class="col-xs-6">

                                    <?php
                                    $tbRncEficaz = new TbRncEficaz();

                                    $selectDescricao = new SelectOption();

                                    $selectDescricao->setStmt($tbRncEficaz->listRncEficaz())
                                        ->isRequire(true)
                                        ->setClass('form-control')
                                        ->setOptionEmpty('SELECIONE')
                                        ->setSelectName('efi_codigo')
                                        ->listOption();
                                    ?>
                                </div>
                            </div>

                            <div class="col-xs-6">
                                <p class="text-primary">ENCERRAR NC ?</p>

                                <div class="col-xs-6">


                                    <?php
                                    $array = array(array(1, 'SIM'),
                                        array(2, 'NÃO'));

                                    $SelectEncerrarNC = new SelectOption();

                                    $SelectEncerrarNC->setOptionEmpty('SELECIONE')
                                        ->setSelectName('ver_encerrado')
                                        ->setStmt($array)
                                        ->isRequire(true)
                                        ->setClass('form-control')
                                        ->listOption();

                                    ?>


                                </div>
                            </div>
                            <div class="col-xs-12">
                                <hr>
                                <label class="text-info">PARECER DA QUALIDADE:</label>
                                <textarea class="form-control" rows="2" name="ver_parecer_qualidade"
                                          placeholder="PARECER QUALIDADE"></textarea>
                                <br>
                            </div>

                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-primary"> Verificar</button>
                                </div>
                            </div>

                        </form>


                        <?php
                        $tbRncVerificacao = new TbRncVerificacao();

                        if($tbRncVerificacao->countVerificacaoByRnc($buca->getValueGet('nc_codigo')) >= 1) {

                            ?>
                            <!-- Verificacoes -->
                            <hr>
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        Verificações Anteriores
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <?php

                                    $DataGrid = new Grid(array('Eficaz', 'Data', 'Encerrado', 'Parecer Qualidade'),
                                        $tbRncVerificacao->listarVerificaoByRnc($buca->getValueGet('nc_codigo'))
                                                         ->fetchAll(\PDO::FETCH_ASSOC));

                                    $DataGrid->colunaoculta = 1;
                                    $DataGrid->show(true);
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <!-- fim verificações -->


                    </div>
                    <div class="panel-footer"></div>
                </div>
                <?php
            }elseif($_SESSION['rncGestor']['snc_codigo'] == 4){
                $tbRncVerificacao = new TbRncVerificacao();
                $Verificacao = $tbRncVerificacao->getUltimaRncVerificacao($buca->getValueGet('nc_codigo'));
            ?>

                <!-- Verificado -->

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-check"></span> VERIFICACÃO</h3>
                    </div>
                    <div class="panel-body">

                        <div class="col-xs-6">
                            <label class="text-info">
                                EFICAZ:
                            </label>
                            <?php echo($Verificacao['efi_descricao']); ?>
                        </div>

                        <div class="col-xs-6">
                            <label class="text-info">
                                ENCERRAR NC:
                            </label>
                            <?php echo($Verificacao['ver_encerrado']); ?>
                        </div>

                        <div class="col-xs-12">
                            <label class="text-info">PARECER DA QUALIDADE:</label>
                            <?php echo  $Verificacao['ver_parecer_qualidade']; ?>
                            <br>
                        </div>

                        <div class="col-xs-12">
                            <label class="text-info">DATA DA VERIFICAÇÃO:</label>
                            <?php echo  $Verificacao['ver_data_resposta']; ?>
                            <br>
                        </div>


                        </form>
                    </div>
                    <div class="panel-footer"></div>
                </div>

            <?php
            }


            ?>


        </div>
    </div>

<?php
include_once 'componentes/footerRnc.php';
?>