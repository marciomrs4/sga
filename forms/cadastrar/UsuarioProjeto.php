<?php 
Sessao::validarForm('cadastrar/UsuarioProjeto');

?>
<table>
	<tr>
		<td>
			<fieldset>
				<legend>Cadastrar Usuario Projeto</legend>
<form name="arquivo" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/UsuarioProjeto.php">
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="2" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
      </td>
    </tr>
    
    <tr>
      <th width="119" align="left" nowrap="nowrap">Usuário:</th>
      <td>
        <?php
        $tbUsuario = new TbUsuario();

        $SelectUsuarioProjeto = new SelectOption();

        $SelectUsuarioProjeto->setOptionEmpty('Selecione')
        ->setSelectedItem($_SESSION['cadastrar/UsuarioProjeto']['usu_codigo_integrante'])
        ->setSelectName('usu_codigo_integrante')
        ->setStmt($tbUsuario->selectUsuarios())
        ->listOption();

        ?>

        <input name="pro_codigo" type="hidden" value="<?php echo(base64_decode($_SESSION['valor'])); ?>" />
      </td>

      <td colspan="2" align="right">
	      <input type="submit" name="cadastrar" id="button" value="Adicionar" />

        <a href="./action/formcontroler.php?<?php echo(base64_encode('alterar/Projeto').'='.$_SESSION['valor']);?>">
          <span class="button-tela">Voltar</span>
        </a>

      </td>
    </tr>
    
  </table>
</form>

</fieldset>
</td>
</tr>
</table>
<?php unset($_SESSION['cadastrar/Sistema']); ?>