<?php 
$tbstatus = new TbStatus();
$_SESSION['cadastrar/MeuStatus'] = $tbstatus->getForm(base64_decode($_SESSION['valorform']));
?>
<table>
	<tr>
		<td>
			<fieldset>
				<legend>Alterar Status</legend>
<form name="arquivo" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/status.php">
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="2" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
      </td>
    </tr>
    
    <tr>
      <th width="119" align="left" nowrap="nowrap">Status:</th>
      <td>
      	<input name="sta_codigo" type="hidden" value="<?php echo($_SESSION['cadastrar/MeuStatus']['sta_codigo']); ?>" />      
      	<input name="sta_descricao" type="text" value="<?php echo($_SESSION['cadastrar/MeuStatus']['sta_descricao']); ?>" />
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
<?php unset($_SESSION['cadastrar/MeuStatus']);?>