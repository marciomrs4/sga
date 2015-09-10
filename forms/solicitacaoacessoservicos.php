<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

?>
<div class="row">
    <hr>
    <div class="col-xs-5">
        <?php
        $tbServico = new TbServico();
        ?>

        <select class="form-control" name="servico[]" readonly>
            <option value="<?php echo $tbServico->getDescricaoServico($_POST['post_servico']) ?>">
                <?php echo $tbServico->getDescricaoServico($_POST['post_servico']) ?>
            </option>
        </select>

    </div>

    <div class="col-xs-5">
        <?php
        $tbPerfil = new TbPerfil();
        ?>
        <select class="form-control" name="perfil[]" readonly>
            <option value="<?php echo $tbPerfil->getDescricaoPerfil($_POST['post_perfil']);?>">
                <?php echo $tbPerfil->getDescricaoPerfil($_POST['post_perfil']);?>
            </option>
        </select>
    </div>


    <div class="col-xs-2">
        <button class="btn btn-sm btn-danger remover" >Remover</button>
    </div>
</div>
