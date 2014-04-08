<?php 
Sessao::validarForm('cadastrar/meutempo'); 
?>
<table>
	<tr>
		<td>
			<fieldset>
				<legend>Cadastrar Tempo</legend>
<form name="arquivo" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/tempo.php">
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="2" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
      </td>
    </tr>
    
    <tr>
      <th width="119" align="left" nowrap="nowrap">Tempo de Atendimento:</th>
      <td>
      	<input name="tat_descricao" type="text" value="<?php echo($_SESSION['cadastrar/meutempo']['pri_descricao']); ?>" />
      </td>
    </tr>
	<tr>
      <th align="left" nowrap="nowrap">Departamento:</th>
	      <td>
	      	<?php 
			$departamento = new TbDepartamento();
			$_SESSION['cadastrar/meutempo']['dep_codigo'] = $_SESSION['dep_codigo'];
	      	FormComponente::selectOption('dep_codigo',$departamento->listarTodosDepartamentos(),false,$_SESSION['cadastrar/meutempo']);	      	
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
<?php unset($_SESSION['cadastrar/meutempo']);?>