<?php 

$tbtempoatendimento = new TbTempoAtendimento();
$_SESSION['cadastrar/meutempo'] = $tbtempoatendimento->getForm(base64_decode($_SESSION['valorform']));


?>
<table>
	<tr>
		<td>
			<fieldset>
				<legend>Alterar Tempo</legend>
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
       	<input name="tat_codigo" type="hidden" value="<?php echo($_SESSION['cadastrar/meutempo']['tat_codigo']); ?>" />
      	<input name="tat_descricao" type="text" value="<?php echo($_SESSION['cadastrar/meutempo']['tat_descricao']); ?>" />
      </td>
    </tr>
<tr>
      <th align="left" nowrap="nowrap">Departamento:</th>
	      <td>
	      	<?php 
			$departamento = new TbDepartamento();
	      	FormComponente::selectOption('dep_codigo',$departamento->listarTodosDepartamentos(),false,$_SESSION['cadastrar/meutempo']);	      	
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
<?php unset($_SESSION['cadastrar/meutempo']);?>