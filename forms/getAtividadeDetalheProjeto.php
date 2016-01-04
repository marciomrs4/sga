<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

header('Content-Type: text/html; charset=ISO-8859-1');


$tbAtividade = new TbAtividade();

$dadosAtividade = $tbAtividade->getFormDetalheAtividade($_POST['at_codigo']);

$tbApontamento = new TbApontamento();

$dadosApontamento = $tbApontamento->listarApontamento($_POST['at_codigo']);

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Detalhes da Atividade: <?php echo $dadosAtividade['at_titulo']; ?></h3>
    </div>
    <div class="panel-body">

        <div class="col-xs-12">
            <label class="text-warning">Descrição:</label> <?php echo $dadosAtividade['at_descricao']; ?>
            <br>
        </div>

        <div class="col-xs-12">
            <label class="text-warning">Responsável da Atividade:</label> <?php echo $dadosAtividade['responsavel']; ?>
            <br>
        </div>
        <div class="col-xs-12">
            <label class="text-warning">Previsão de Inicio:</label> <?php echo $dadosAtividade['at_previsao_inicio']; ?>
            <br>
        </div>
        <div class="col-xs-12">
            <label class="text-warning">Previsão de Finalização:</label> <?php echo $dadosAtividade['at_previsao_fim']; ?>
            <br>
        </div>
        <div class="col-xs-12">
            <label class="text-warning">Status:</label> <?php echo $dadosAtividade['status']; ?>
            <br>
        </div>
        <div class="col-xs-12">
            <label class="text-warning">Fase:</label> <?php echo $dadosAtividade['fas_descricao']; ?>
            <br>
        </div>
        <div class="col-xs-12">
            <label class="text-warning">Esta atividade foi:</label> <?php echo $dadosAtividade['planejamento']; ?>
            <br>
        </div>
        <div class="col-xs-12">
            <label class="text-warning">Inicio Realizado:</label> <?php echo $dadosAtividade['at_inicio']; ?>
            <br>
        </div>
        <div class="col-xs-12">
            <label class="text-warning">Finalização Realizado:</label> <?php echo $dadosAtividade['at_fim']; ?>
            <br>
        </div>


    </div>
    <div class="panel-footer">
    </div>
</div>

<?php
$DataGrid = new Grid();

$DataGrid->setDados($dadosApontamento->fetchAll(\PDO::FETCH_ASSOC))
         ->setCabecalho(array('Descrição','Data','Usuário'));
$DataGrid->colunaoculta = 1;
$Panel = new Painel();

$Panel->addGrid($DataGrid)
      ->setPainelTitle('Apontamento(s)')
      ->show();


?>
