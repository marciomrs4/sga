<?php
Sessao::validarForm('cadastrar/Versao');
?>

  <fieldset>
    <legend> Nova Versão </legend>
    <form name="versao" id="versao" method="post" enctype="multipart/form-data" action="../<?php echo($_SESSION['projeto']); ?>/action/CadastrarVersao.php">
      <table border="0" cellspacing="5">
        <tr>
          <td colspan="2" align="center">
            <?php Texto::mostrarMensagem($_SESSION['erro']); ?>
          </td>
        </tr>

        <tr>
          <th width="119" align="left" nowrap="nowrap">Sistema:</th>
          <td>
            <?php
            $tbversao = new TbSistemas();
            $FormStatus = new SelectOption();
            $FormStatus->setStmt($tbversao->listarSistemas())
                ->setSelectName('sis_codigo')
                ->setSelectedItem($AlterarVersao['sis_codigo'])
                ->setOptionEmpty('TODOS')
                ->listOption();
            ?>
          </td>
        </tr>
        <tr>
          <th align="left" nowrap="nowrap">Versão:</th>
          <td>
            <input type="text" name="vso_versao" size="30" value="" />
          </td>
        </tr>

        <tr>
          <th width="119" align="left" nowrap="nowrap">Aprovado Por:</th>
          <td>
            <input type="text" name="vso_aprovador" size="30" value="" />
          </td>
        </tr>

        <tr>
          <th align="left" nowrap="nowrap">Data:</th>
          <td>
            <input type="text" name="vso_data" class="data" id="data2-id" size="10" value="<?php echo date('d-m-Y')?>" />
          </td>
        </tr>

        <tr>
          <th align="left" nowrap="nowrap">Novas Instalações:</th>
          <td>
            <textarea name="vso_novas_instalacoes" rows="8" cols="50"></textarea>
          </td>
        </tr>

        <tr>
          <th align="left" nowrap="nowrap">Observações:</th>
          <td>
            <textarea name="vso_obs" rows="8" cols="50"></textarea>
          </td>
        </tr>

        <tr>
          <th nowrap="nowrap">Enviar e-mail para:</th>
          <td nowrap="nowrap">
            Departamento: <input type="checkbox" name="Departamento" checked="checked" value="1" >
            |
            Usuário chave: <input type="checkbox" name="UsuarioChave" checked="checked" value="1" >
          </td>
        </tr>

        <tr>
          <td colspan="2">
            &ensp;
          </td>
        </tr>

        <tr>
          <td>
          </td>


          <td nowrap="nowrap">
            <input type="submit" name="cadastrar" class="button-tela" id="botaoSave" value="Salvar" />
            <span class="botaoSave" style="visibility: hidden"><img src="./css/images/299.GIF"></span>

    </form>
    <hr>

    <form action="">
      <input type="submit" name="alterar" class="button-tela" value=" Voltar " />
    </form>
    </td>
    </tr>

    </table>
  </fieldset>

<?php unset($_SESSION['cadastrar/Versao']);?>