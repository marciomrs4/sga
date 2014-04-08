<?php 
$tbusuario = new TbUsuario();

$_SESSION['alterar/usuario'] = $tbusuario->getForm(base64_decode($_SESSION['valorform']));


?>
<table>
	<tr>
		<td>
			<fieldset>
				<legend>Alterar <?php echo($_SESSION['config']['usuario']);?></legend>
<form name="alterar/usuario" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/usuario.php">
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="2" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
      </td>
    </tr>
    
    <tr>
      <th width="119" align="left" nowrap="nowrap">Nome:</th>
      <td>
      	<input name="usu_codigo" type="hidden" value="<?php echo($_SESSION['alterar/usuario']['usu_codigo']); ?>" />
      	<input name="usu_nome" type="text" value="<?php echo($_SESSION['alterar/usuario']['usu_nome']); ?>" />
      </td>
    </tr>
    
    <tr>
      <th align="left" nowrap="nowrap">Sobrenome:</th>
	      <td>
	      	<input name="usu_sobrenome" type="text" value="<?php echo($_SESSION['alterar/usuario']['usu_sobrenome']); ?>"/>
	      </td>
    </tr>
    
    <tr>
      <th align="left" nowrap="nowrap">E-mail:</th>
	      <td>
	      	<input name="usu_email" type="text" value="<?php echo($_SESSION['alterar/usuario']['usu_email']); ?>"/>
	      </td>
    </tr>
    
    <tr>
      <th align="left" nowrap="nowrap"><?php echo($_SESSION['config']['ramal']);?>:</th>
	      <td>
	      	<input name="usu_ramal" type="text" value="<?php echo($_SESSION['alterar/usuario']['usu_ramal']); ?>"/>
	      </td>
    </tr>
    
   <tr>
      <th align="left" nowrap="nowrap">Departamento:</th>
	      <td>
	      	<?php 
				$tbdepartamento = new TbDepartamento();
				FormComponente::$name = 'ESCOLHA';
				FormComponente::selectOption('dep_codigo', $tbdepartamento->listarTodosDepartamentos(),true,$_SESSION['alterar/usuario']);
				
				?>
	      </td>
    </tr>    
    
    <tr>
      <th align="left" nowrap="nowrap">Tipo de Acesso:</th>
	      <td>
				<?php 
				$tbtipoacesso = new TbTipoAcesso();
				FormComponente::$name = 'ESCOLHA';
				FormComponente::selectOption('tac_codigo', $tbtipoacesso->listarAcessos(),true,$_SESSION['alterar/usuario']);
				
				?>
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
<?php unset($_SESSION['alterar/usuario']);?>