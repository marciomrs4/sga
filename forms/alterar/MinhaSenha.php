<?php 
$tbacesso = new TbAcesso();

$_SESSION['alterar/MinhaSenha'] = $tbacesso->getForm($_SESSION['usu_codigo']);


?>
<table>
	<tr>
		<td>
			<fieldset>
				<legend>Alterar <?php echo($_SESSION['config']['senha']);?></legend>
<form name="arquivo" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/usuario.php">
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="2" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
      </td>
    </tr>

   	<tr>
      <th align="left" nowrap="nowrap"><?php echo($_SESSION['config']['usuario']); ?>:</th>
	      <td>
	      	<input name="ace_codigo" type="hidden" value="<?php echo($_SESSION['alterar/MinhaSenha']['ace_codigo']); ?>"/>	      
	      	<input name="ace_usuario" type="text" disabled="disabled" value="<?php echo($_SESSION['alterar/MinhaSenha']['ace_usuario']); ?>"/>
	      </td>
    </tr>
    
   	<tr>
      <th align="left" nowrap="nowrap"><?php echo($_SESSION['config']['senha']);?></th>
	      <td>
	      	<input name="ace_senha" type="password" value=""/>
	      </td>
    </tr>    
    
   	<tr>
      <th align="left" nowrap="nowrap">Repetir <?php echo($_SESSION['config']['senha']);?>:</th>
	      <td>
	      	<input name="ace_senha2" type="password" value=""/>
	      </td>
    </tr>    
    
    <tr>
      <td colspan="2" align="right">
	      <input type="submit" name="cadastrar" id="button" value="Alterar" />
      </td>
    </tr>
    
  </table>
</form>

</fieldset>
</td>
</tr>
</table>
<?php unset($_SESSION['alterar/MinhaSenha']);?>