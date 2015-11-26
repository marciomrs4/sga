<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

header('Content-Type: text/html; charset=ISO-8859-1');

$tbAtaReuniao = new TbAtaReuniao();

$dadosAta = $tbAtaReuniao->getForm($_POST['ata_codigo']);

$dadosAta = unserialize($dadosAta['form_ata_reuniao']);


/*echo '<pre>';
print_r($dadosAta);
echo '</pre>';*/


?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Ata de Reunião</h3>
    </div>
    <div class="panel-body">

        <div class="col-xs-12">
            <label class="text-warning">Assunto:</label> <?php echo $dadosAta['ata_assunto']; ?>
            <br>
        </div>
        <div class="col-xs-12">
            <label class="text-warning">Data:</label> <?php echo $dadosAta['ata_data']; ?>
            <br>
        </div>
        <div class="col-xs-12">
            <label class="text-warning">Duração:</label> <?php echo $dadosAta['ata_duracao']; ?>
            <br>
        </div>
        <div class="col-xs-12">
            <label class="text-warning">Criado por:</label> <?php echo $dadosAta['ata_emissao']; ?>
            <br>
        </div>
        <div class="col-xs-12">
            <label class="text-warning">Local:</label> <?php echo $dadosAta['ata_local']; ?>
            <br>
        </div>
        <div class="col-xs-12">
            <label class="text-warning">Pauta:</label> <?php echo $dadosAta['ata_pauta']; ?>
            <br>
        </div>
        <div class="col-xs-12">
            <label class="text-warning">Participante(s):</label> <?php echo $dadosAta['ata_participantes']; ?>
            <br>
        </div>
        <div class="col-xs-12">
            <label class="text-warning">Resumo tratado:</label> <?php echo $dadosAta['ata_resumo_tratado']; ?>
            <br>
        </div>
        <div class="col-xs-12">
            <label class="text-warning">Ações Pendentes:</label> <?php echo $dadosAta['ata_acoes_pendencias']; ?>
            <br>
        </div>


    </div>
    <div class="panel-footer">
    </div>
</div>
