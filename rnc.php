<?php
include_once 'componentes/TopoRnc.php';


$tbOcorrenciaRnc = new TbOcorrenciaRnc();

$busca = new Busca();

$busca->setValueGet($_GET,'sol_codigo');

?>

    <!-- QUALIDADE -->
    <div class="container-fluid">
    <div class="col-xs-12">
    <div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-user"></span> QUALIDADE</h3>
    </div>

    <div class="panel-body">
<?php


if($tbOcorrenciaRnc->validarOcorrencia($busca->getValueGet('sol_codigo')) >= 1){

    $Grid = new Grid(array('RNC','Chamado'),
        $tbOcorrenciaRnc->listarRncChamado($busca->getValueGet('sol_codigo'))->fetchAll(\PDO::FETCH_NUM));

    $Grid->colunaoculta = 1;

    $Panel = new Painel();

    $Panel->addGrid($Grid)->setPainelTitle('Registro de RNC - Já Existe uma RNC criada ou associada a esse chamado !')->setPainelColor('danger')->show();

}else {


    ?>

    <form id="cadastrarrnc" name="rnc" method="post" action="action/cadastrarRnc.php">

        <?php if ($_SESSION['erro']): ?>
            <div class="alert alert-danger" role="alert"><?php echo $_SESSION['erro']; ?></div>
        <?php endif; ?>

        <?php if ($_SESSION['mensagem']): ?>
            <div class="alert alert-success" role="alert"><?php echo $_SESSION['mensagem']; ?></div>
        <?php endif; ?>


        <div class="col-xs-12">
            <label class="text-info">CRIANDO RNC COM A OCORRÊNCIA:</label>
            <?php echo $busca->getValueGet('sol_codigo'); ?>
            <input type="hidden" name="sol_codigo" value="<?php echo($busca->getValueGet('sol_codigo')); ?>">
        </div>

        <div class="col-xs-12">
            <label class="text-info">DESCRIÇÃO DA NÃO COMFORMIDADE:</label>
                                <textarea class="form-control" rows="3" name="nc_descricaocompleta" placeholder="DESCRIÇÃO"<?php echo($_SESSION['rnc']['nc_descricaocompleta']); ?>"></textarea>
            <hr>
        </div>

        <div class="col-xs-3">
            <label class="text-info">LOCAL DA OCORRÊNCIA:</label>
            <input type="text" class="form-control" name="nc_local_ocorrencia" placeholder="LOCAL"
                   value="<?php echo($_SESSION['rnc']['nc_local_ocorrencia']); ?>">
        </div>

        <div class="col-xs-3">
            <label class="text-info">DATA DA OCORRÊNCIA:</label>
            <input type="date" class="form-control" name="nc_data_ocorrencia"
                   placeholder="DATA DA OCORRÊNCIA" title="DATA DA OCORRÊNCIA"
                   value="<?php echo($_SESSION['rnc']['nc_data_ocorrencia']); ?>">
        </div>

        <div class="col-xs-3">
            <label class="text-info">EMITENTE:</label>

            <?php
            $tbUsuario = new TbUsuario();

            $selectUsuarios = new SelectOption();

            $selectUsuarios->setStmt($tbUsuario->selectUsuarios())
                ->isRequire(true)
                ->setClass('form-control')
                ->setOptionEmpty('SELECIONE')
                ->setSelectName('usu_emitente_codigo')
                ->listOption();
            ?>

        </div>

        <div class="col-xs-3">
            <label class="text-info">DEPTO RESPONSÁVEL:</label>

            <?php
            $tbDepartamento = new TbDepartamento();

            //$tbDepartamento->getAllDepartamentos();

            $SelectDepartamento = new SelectOption();

            $SelectDepartamento->setStmt($tbDepartamento->getAllDepartamentos())
                ->isRequire(true)
                ->setClass('form-control')
                ->setOptionEmpty('SELECIONE')
                ->setSelectName('dep_responsavel_codigo')
                ->listOption();
            ?>

        </div>

        <div class="col-xs-9">
            <hr>
            <label class="text-info">TIPO DE PROBLEMA:</label>
            <?php
            $tbProblema = new TbProblema();

            $SelecTipoProblemaRnc = new SelectOption();

            $SelecTipoProblemaRnc->setStmt($tbProblema->listarProblemasTecnicos(36))
                                 ->isRequire(true)
                                 ->setClass('form-control')
                                 ->setOptionEmpty('SELECIONE')
                                 ->setSelectName('pro_codigo_tecnico_rnc')
                                 ->listOption();

            ?>
            <hr>
        </div>

        <div class="col-xs-12">
            <label class="text-info">AÇÃO IMEDIATA:</label>
                                <textarea class="form-control" rows="3" name="nc_acao_imediata" placeholder="AÇÃO IMEDIATA" <?php echo($_SESSION['rnc']['nc_acao_imediata']); ?>"></textarea>
            <hr>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary" id="botaoSave"> Criar</button>
                <div id="loadprocessar"></div>
            </div>
        </div>


    </form>

    </div>
    <div class="panel-footer"></div>
    </div>
    </div>
    </div>
    <!-- END QUALIDADE -->

    <?php
}
Sessao::finalizarSessao();

include_once 'componentes/footerRnc.php';
?>