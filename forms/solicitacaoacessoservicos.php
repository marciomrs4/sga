<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

?>
<div class="row">
    <hr>
    <div class="col-xs-5">

        <?php
        $tbTipoSolicitacao = new TbTipoSolicitacaoAcesso();

        $select = new SelectOption();

        $select->setStmt($tbTipoSolicitacao->select()->fetchAll(\PDO::FETCH_NUM))
            ->setSelectName('service[]')
            ->setOptionEmpty('Selecione')
            ->setClass('form-control')
            ->isRequire(true)
            ->listOption();

        ?>

    </div>

    <div class="col-xs-5">

        <select class="form-control"  name="perfil[]">
            <option disabled selected>SELECIONE PERFIL...</option>
            <option value="alterar" >Alteração</option>
            <option value="bloquear">Bloqueio</option>
            <option value="desbloquear">Desbloqueio</option>
            <option value="incluir">Inclusão</option>
        </select>
    </div>
    <div class="col-xs-2">
        <button class="btn btn-sm btn-danger remover" >Remover</button>
    </div>
</div>
