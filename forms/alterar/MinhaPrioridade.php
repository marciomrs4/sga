<?php 
$tbprioridade = new TbPrioridade();

$_SESSION['cadastrar/MinhaPrioridade'] = $tbprioridade->getForm(base64_decode($_SESSION['valorform']));

?>
<table>
	<tr>
		<td>
			<fieldset>
				<legend>Alterar Prioridade</legend>
<form name="arquivo" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/prioridade.php">
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="2" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
      </td>
    </tr>
    
    <tr>
      <th width="119" align="left" nowrap="nowrap">Prioridade:</th>
      <td>
       	<input name="pri_codigo" type="hidden" value="<?php echo($_SESSION['cadastrar/MinhaPrioridade']['pri_codigo']); ?>" />
      	<input name="pri_descricao" type="text" value="<?php echo($_SESSION['cadastrar/MinhaPrioridade']['pri_descricao']); ?>" />
      </td>
    </tr>
    
   <tr>
      <th align="left" nowrap="nowrap">Departamento:</th>
	      <td>
	      	<?php 
			$departamento = new TbDepartamento();
			$_SESSION['cadastrar/MinhaPrioridade']['dep_codigo_prioridade'] = $_SESSION['cadastrar/MinhaPrioridade']['dep_codigo'];
			FormComponente::$name = 'Selecione';
	      	FormComponente::selectOption('dep_codigo_prioridade',$departamento->listarTodosDepartamentos(),true,$_SESSION['cadastrar/MinhaPrioridade']);	      	
	      	?>
	      </td>
    </tr>
 <tr>
      <th align="left" nowrap="nowrap">Tempo de Atendimento:</th>
	      <td>
	      	<?php 
	      	$tbtempoatendimento = new TbTempoAtendimento();
	      	
	      	FormComponente::selectOption('tat_codigo',$tbtempoatendimento->selectMeuTempoAtendimento($_SESSION['cadastrar/MinhaPrioridade']['dep_codigo']),false,$_SESSION['cadastrar/MinhaPrioridade']);
	      	
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
<?php unset($_SESSION['cadastrar/MinhaPrioridade']);?>