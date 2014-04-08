<?php 
$tbproblema = new TbProblema();
$_SESSION['cadastrar/MeuProblema'] = $tbproblema->getForm(base64_decode($_SESSION['valorform']));
?>
<table>
	<tr>
		<td>
			<fieldset>
				<legend>Alterar <?php echo($_SESSION['config']['problema']);?>:</legend>
<form name="arquivo" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/problema.php">
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="2" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
      </td>
    </tr>
    
    <tr>
      <th width="119" align="left" nowrap="nowrap">Descrição:</th>
      <td>
      	<input name="pro_codigo" type="hidden" value="<?php echo($_SESSION['cadastrar/MeuProblema']['pro_codigo']); ?>" />      
      	<input name="pro_descricao" type="text" value="<?php echo($_SESSION['cadastrar/MeuProblema']['pro_descricao']); ?>" />
      </td>
    </tr>
 <tr>
      <th align="left" nowrap="nowrap">Departamento:</th>
	      <td>
	      	<?php 
			$departamento = new TbDepartamento();
			FormComponente::$name = '';
			$_SESSION['cadastrar/MeuProblema']['dep_codigo_problema'] = $_SESSION['cadastrar/MeuProblema']['dep_codigo'];
	      	FormComponente::selectOption('dep_codigo_problema',$departamento->listarTodosDepartamentos(),true,$_SESSION['cadastrar/MeuProblema']);	      	
	      	?>
	      </td>
    </tr>
    <tr>
      <th align="left" nowrap="nowrap">Prioridade:</th>
	      <td>
	      	<?php 
	      	$tbprioridade = new TbPrioridade();
	      	FormComponente::selectOption('pri_codigo', $tbprioridade->selectMinhasPrioridades($_SESSION['cadastrar/MeuProblema']['dep_codigo']),false,$_SESSION['cadastrar/MeuProblema']);	      	
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
<?php unset($_SESSION['cadastrar/MeuProblema']);?>