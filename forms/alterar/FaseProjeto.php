<?php

$tbFaseProjeto = new TbFaseProjeto();

$_SESSION['alterar/FaseProjeto'] = $tbFaseProjeto->getForm(base64_decode($_SESSION['valorform']));


?>
<table>
	<tr>
		<td>
			<fieldset>
				<legend>Alterar Fase Projeto</legend>
<form name="arquivo" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/FaseProjeto.php">
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="2" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
      </td>
    </tr>
    
    <tr>
      <th width="119" align="left" nowrap="nowrap">Fase:</th>
      <td>
      	<input name="fas_descricao" type="text" value="<?php echo($_SESSION['alterar/FaseProjeto']['fas_descricao']); ?>" />
        <input name="fas_codigo" type="hidden" value="<?php echo($_SESSION['alterar/FaseProjeto']['fas_codigo']); ?>" />
        <input name="pro_codigo" type="hidden" value="<?php echo($_SESSION['alterar/FaseProjeto']['pro_codigo']); ?>" />
      </td>
    </tr>
    <tr>
      <td colspan="2" align="right">
	      <input type="submit" name="cadastrar" id="button" value="Alterar" />
      </td>
      <td>
        <a href="action/formcontroler.php?<?php echo base64_encode('alterar/Projeto'); ?>=<?php echo base64_encode($_SESSION['alterar/FaseProjeto']['pro_codigo']); ?>">
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