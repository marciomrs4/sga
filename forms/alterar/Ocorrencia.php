<?php

$onc_codigo = base64_decode($_SESSION['valorform']);

$tbOcorrenciaRnc = new TbOcorrenciaRnc();

$OcorrenciaRnc = $tbOcorrenciaRnc->getFormOcorrenciaRnc($onc_codigo);

?>

<fieldset>
    <legend>Associar Ocorrência (Editar)</legend>
    <form name="associarocorrencia" id="associarocorrencia" method="post" enctype="multipart/form-data" action="../<?php echo($_SESSION['projeto']); ?>/action/associarRnc.php">
        <table border="0">

            <?php
            if($_SESSION['erro']) {
                ?>
                <tr>
                    <th nowrap="nowrap">

                    </th>
                    <td>
                        <?php

                        echo Erro::validarChamadoInRnc($_SESSION['erro']);

                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>

            <tr>
                <th nowrap="nowrap">
                    Número da ocorrência:
                </th>
                <td>
                    <?php echo $OcorrenciaRnc['sol_codigo']; ?>
                    <input type="hidden" name="sol_codigo" value="<?php echo $OcorrenciaRnc['sol_codigo']; ?>">
                    <input type="hidden" name="onc_codigo" value="<?php echo $OcorrenciaRnc['onc_codigo']; ?>">
                </td>
            </tr>

            <tr>
                <th nowrap="nowrap">
                    Descriação da ocorrência:
                </th>
                <td>
                    <?php
                    $tbSolicitacao = new TbSolicitacao();

                    echo $tbSolicitacao->getDescricaoSolicitacao($OcorrenciaRnc['sol_codigo']);

                    ?>
                </td>
            </tr>

            <tr>
                <th>
                    RNC:
                </th>
                <td>
                    <?php
                    $tbRNc = new TbCadastroRnc();

                    $RncSelect = new SelectOption();

                    $RncSelect->setStmt($tbRNc->listarRncNaoFechadas())
                        ->setOptionEmpty('Selecione')
                        ->setSelectName('nc_codigo')
                        ->setSelectedItem($OcorrenciaRnc['nc_codigo'])
                        ->listOption();

                    ?>
                </td>
            </tr>

            <tr>
                <td>
                    &emsp;
                </td>
            </tr>

            <tr>
                <td>
                    <input type="submit" name="salvar" class="button-tela" value=" Salvar " />

                </td>
                <td>
                    <a href="action/formcontroler.php?<?php echo base64_encode('alterar/Solicitacao') . base64_encode($OcorrenciaRnc['sol_codigo']); ?>">
                        <span class="button-tela">Voltar</span>
                    </a>
                </td>
            </tr>

        </table>

<?php

$GridOcorrencia = new DataGrid(array('RNC','Chamado'),$tbOcorrenciaRnc->listarRncChamado($OcorrenciaRnc['sol_codigo']));

$GridOcorrencia->acao = 'alterar/Ocorrencia';
$GridOcorrencia->colunaoculta = 1;

$GridOcorrencia->mostrarDatagrid(1);

?>

</fieldset>

<?php unset($_SESSION['cadastrar/Ocorrencia']);?>