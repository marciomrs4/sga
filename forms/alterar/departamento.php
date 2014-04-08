<?php 
$tbdepartamento = new TbDepartamento();

$_SESSION['alterar/departamento'] = $tbdepartamento->getForm(base64_decode($_SESSION['valorform']));


?>
<table>
	<tr>
		<td>
			<fieldset>
				<legend>Alterar Departamento</legend>
<form name="alterar/departamento" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/departamento.php">
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="2" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
      </td>
    </tr>
    
    <tr>
      <th width="119" align="left" nowrap="nowrap">Departamento:</th>
      <td>
      	<input name="dep_codigo" type="hidden" value="<?php echo($_SESSION['alterar/departamento']['dep_codigo']); ?>" />
      	<input name="dep_descricao" type="text" value="<?php echo($_SESSION['alterar/departamento']['dep_descricao']); ?>" />
      </td>
    </tr>
    <tr>
      <th align="left" nowrap="nowrap">Permite Listar no Chamado:</th>
	      <td>
	      	<?php 
			$tbSN = new TbSimNao();
	      	FormComponente::selectOption('pro_permite_listar_chamado',$tbSN->selectSimNao(),false,$_SESSION['alterar/departamento']);	      	
	      	?>
	      </td>
    </tr>
    <tr>
      <th align="left" nowrap="nowrap">E-mail:</th>
	      <td>
	      	<input name="dep_email" type="text" value="<?php echo($_SESSION['alterar/departamento']['dep_email']); ?>"/>
	      </td>
    </tr>
       
    <tr>
      <td colspan="2" align="right">
	      <input type="submit" name="alterar" id="button" value="Alterar" />
      </td>
    </tr>
    
  </table>
</form>

</fieldset>
</td>
</tr>
</table>
<?php unset($_SESSION['alterar/usuario']);?>