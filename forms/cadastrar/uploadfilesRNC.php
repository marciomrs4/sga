<?php
$tbRnc = new TbCadastroRnc();

?>

<fieldset>
    <legend> Anexar arquivo </legend>
    <form name="anexarfile" id="anexarfile"  method="post" enctype="multipart/form-data" action="../<?php echo($_SESSION['projeto']); ?>/action/anexarfiles.php">
        <table border="0">

            <tr>
                <th>
                    RNC:
                </th>
                <td>
                    <?php echo($tbRnc->getNumberRncFormatado(base64_decode($_SESSION['valor']))); ?>
                </td>
            </tr>

            <tr>
                <th>Enviar Arquivo:</th>
                <td>
                    <input type="file" name="arquivo" />
                </td>

                <td>
                    <input type="submit" name="cadastrar" class="button-tela" id="botaoSave" value="Salvar" />
                    <input type="hidden" name="nc_codigo" value="<?php echo($_SESSION['valor']); ?>" />
                    <span class="botaoSave" style="visibility: hidden"><img src="./css/images/299.GIF"></span>
                </td>
                <td>
                    <a href="./action/formcontroler.php?<?php echo(base64_encode('alterar/rncVerificacao').'='.$_SESSION['valor']);?>">
                        <img src="./css/images/voltar.png" title="Voltar para RNC">
                    </a>
                </td>
            </tr>

        </table>
    </form>
    <hr>
    <table border="1">
        <thead>
        <tr>
            <th>Arquivo
            </th>
            <th>
                Remover
            </th>
        </tr>
        </thead>

        <?php
        try {

            $nc_codigo = base64_decode($_SESSION['valor']);
            $dirProjeto = new DirectoryIterator(DirectoryCreate::PATH . DirectoryCreate::RNC . $nc_codigo);

            foreach ($dirProjeto as $dir):

                if ($dir->isDot()) {
                    continue;
                }

                ?>
                <tr>
                    <td>
                        <a href="action/downloadfile.php?tipo=rncs&codigo=<?php echo($nc_codigo);?>&file=<?php echo $dir->getFilename();?>" target="_blank"><?php echo($dir->getFilename()); ?></a>
                    </td>
                    <td>
                        <a href="action/removerfiles.php?tipo=rncs&codigo=<?php echo($nc_codigo);?>&file=<?php echo $dir->getFilename();?>" onclick="return confirm('Tem certeza que deseja excluir <?php echo $dir->getFilename();?> ?')">
                            <img src="css/images/remover.png">
                        </a>
                    </td>
                </tr>

                <?php
            endforeach;

        }catch(\Exception $e){
            echo 'Essa RNC não possui arquivos';
        }
        ?>
    </table>
</fieldset>