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
          <th align="left" nowrap="nowrap">Hora de Inicio:</th>
          <td>
              <input name="dep_hora_inicio" class="doisdigitos" size="2" type="text" value="<?php echo($_SESSION['alterar/departamento']['dep_hora_inicio']); ?>"/>
          </td>
      </tr>

      <tr>
          <th align="left" nowrap="nowrap">Hora Fim:</th>
          <td>
              <input name="dep_hora_fim" class="doisdigitos" size="2" type="text" value="<?php echo($_SESSION['alterar/departamento']['dep_hora_fim']); ?>"/>
          </td>
      </tr>

      <tr>
          <th align="left" nowrap="nowrap">Hora de Almoço:</th>
          <td>
              <input name="dep_hora_almoco" class="doisdigitos" size="2" type="text" value="<?php echo($_SESSION['alterar/departamento']['dep_hora_almoco']); ?>"/>
          </td>
      </tr>

      <tr>
          <th align="left" nowrap="nowrap">Carga Horaria de Sábado:</th>
          <td>
              <input name="dep_carga_sabado" class="doisdigitos" size="2" type="text" value="<?php echo($_SESSION['alterar/departamento']['dep_carga_sabado']); ?>"/>
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