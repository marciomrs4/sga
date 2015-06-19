<?php 
Sessao::validarForm('cadastrar/Terceiro');
?>
<table>
	<tr>
		<td>
			<fieldset>
				<legend>Cadastrar Terceiro</legend>
<form name="arquivo" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/Terceiro.php">
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="2" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
      </td>
    </tr>
    
    <tr>
      <th width="119" align="left" nowrap="nowrap">Terceiro:</th>
      <td>
      	<input name="ter_descricao" type="text" value="<?php echo($_SESSION['cadastrar/Terceiro']['ter_descricao']); ?>" />
      </td>
    </tr>
	<tr>
      <th align="left" nowrap="nowrap">Departamento:</th>
	      <td>
	      	<?php 
	      	
	      	$tbDepartamento = new TbDepartamento();
			FormComponente::$name = 'Selecione';
	      	FormComponente::selectOption('dep_codigo',$tbDepartamento->listarDepartamentos(),true,$_SESSION['cadastrar/Terceiro']);	      	
	      	
	      	?>
	      </td>
    </tr>
        
    <tr>
	   <th nowrap="nowrap">Status:</th>
		   	<td nowrap="nowrap"> 
				<input type="checkbox" name="ter_status" checked="checked" value="1" >
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
<?php unset($_SESSION['cadastrar/Terceiro']); ?>