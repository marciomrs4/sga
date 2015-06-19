<?php 

$tbSistema = new TbSistemas();

$_SESSION['cadastrar/Sistema'] = $tbSistema->getForm(base64_decode($_SESSION['valorform']));


?>
<table>
	<tr>
		<td>
			<fieldset>
				<legend>Alterar Sistema</legend>
<form name="arquivo" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/Sistema.php">
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="2" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
      </td>
    </tr>
    
    <tr>
      <th width="119" align="left" nowrap="nowrap">Sistema:</th>
      <td>
      	<input name="sis_descricao" type="text" value="<?php echo($_SESSION['cadastrar/Sistema']['sis_descricao']); ?>" />
      	<input name="sis_codigo" type="hidden" value="<?php echo($_SESSION['cadastrar/Sistema']['sis_codigo']); ?>" />      	
      </td>
    </tr>
	<tr>
      <th align="left" nowrap="nowrap">Usuário Chave:</th>
	      <td>
	      	<?php 
	      	
	      	$tbUsuario = new TbUsuario();
			FormComponente::$name = 'Selecione';
	      	FormComponente::selectOption('usu_codigo_usuario_chave',$tbUsuario->selectUsuarios(),true,$_SESSION['cadastrar/Sistema']);	      	
	      	
	      	?>
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