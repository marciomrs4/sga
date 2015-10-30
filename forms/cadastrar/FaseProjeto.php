<?php 
Sessao::validarForm('cadastrar/FaseProjeto');
?>
<table>
	<tr>
		<td>
			<fieldset>
				<legend>Cadastrar Fase Projeto</legend>
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
      	<input name="fas_descricao" type="text" value="<?php echo($_SESSION['cadastrar/FaseProjeto']['fas_descricao']); ?>" />
        <input name="pro_codigo" type="hidden" value="<?php echo(base64_decode($_SESSION['valor'])); ?>" />
      </td>
    </tr>
    <tr>
      <td colspan="2" align="right">
	      <input type="submit" name="cadastrar" id="button" value="Cadastrar" />
      </td>
    </tr>
    
  </table>
</form>

</fieldset>
</td>
</tr>
</table>
<?php unset($_SESSION['cadastrar/Sistema']); ?>