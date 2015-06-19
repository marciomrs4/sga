<?php 

$tbchecklist = new TbChecklist();

$_SESSION['cadastrar/Checklist'] = $tbchecklist->getForm(base64_decode($_SESSION['valorform']));

$tbDiaSemana = new TbDiaSemanaCheckList();

$_SESSION['dia_semana'] = $tbDiaSemana->getForm($_SESSION['cadastrar/Checklist']['che_codigo']);

?>
<table>
	<tr>
		<td>
			<fieldset>
				<legend>Alterar Checklist</legend>
<form name="Checklist" id="Checklist" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/Checklist.php">
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="2" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
      </td>
    </tr>
    
     <tr>
	   <td>
	  	Dias da semana:
	   </td>
	    	<td nowrap="nowrap"> 
		Domingo: <input type="checkbox" name="dse_domingo" value="1"
			<?php echo $dse_domingo = ($_SESSION['dia_semana']['dse_domingo'] == 1) ? 'checked="checked"' : '' ?>  > |
		Segunda: <input type="checkbox" name="dse_segunda" value="1"
			<?php echo $dse_segunda = ($_SESSION['dia_semana']['dse_segunda'] == 1) ? 'checked="checked"' : '' ?>  > |
		Terça: <input type="checkbox" name="dse_terca" value="1" 
		 	<?php echo $dse_terca = ($_SESSION['dia_semana']['dse_terca'] == 1) ? 'checked="checked"' : '' ?>  > |
		Quarta: <input type="checkbox" name="dse_quarta" value="1" 
			<?php echo $dse_quarta = ($_SESSION['dia_semana']['dse_quarta'] == 1) ? 'checked="checked"' : '' ?>  > |
		Quinta: <input type="checkbox" name="dse_quinta" value="1" 
			<?php echo $dse_quinta = ($_SESSION['dia_semana']['dse_quinta'] == 1) ? 'checked="checked"' : '' ?>  > |
		Sexta: <input type="checkbox" name="dse_sexta" value="1" 
			<?php echo $dse_sexta = ($_SESSION['dia_semana']['dse_sexta'] == 1) ? 'checked="checked"' : '' ?>  > |
		Sábado: <input type="checkbox" name="dse_sabado" value="1" 
			<?php echo $dse_sabado = ($_SESSION['dia_semana']['dse_sabado'] == 1) ? 'checked="checked"' : '' ?>  >
		    </td>
    	</tr>    
    
    <tr>
      <th width="119" align="left" nowrap="nowrap">Titulo:</th>
      <td>
      	<input type="hidden" name="che_codigo" value="<?php echo($_SESSION['cadastrar/Checklist']['che_codigo']); ?>" />      
      	<input type="text" name="che_titulo" value="<?php echo($_SESSION['cadastrar/Checklist']['che_titulo']); ?>" />
      </td>
    </tr>
 	<tr>
      <th width="119" align="left" nowrap="nowrap">E-mail de Envio:</th>
      <td>
      	<input type="text" name="che_email_envio" value="<?php echo($_SESSION['cadastrar/Checklist']['che_email_envio']); ?>" />
      </td>
    </tr>  
 	<tr>
      <th width="119" align="left" nowrap="nowrap">Descrição:</th>
      <td>
	      	<textarea name="che_descricao" rows="10" cols="50"><?php echo($_SESSION['cadastrar/Checklist']['che_descricao']); ?></textarea>
      </td>
    </tr>        
    <tr>
      <th align="left" nowrap="nowrap">Departamento:</th>
	      <td nowrap="nowrap">
	      	<?php 
	      	$tbdepartamento = new TbDepartamento();
	      	FormComponente::selectOption('dep_codigo',$tbdepartamento->listarDepartamentos(),true,$_SESSION['cadastrar/Checklist']);
			?>
	      </td>
    </tr>
 <tr>
      <td nowrap="nowrap">Ativo:</td>
      <td>
      <?php 
      	$tbsn = new TbSimNao();
      	FormComponente::selectOption('che_ativo', $tbsn->selectSimNao(),false,$_SESSION['cadastrar/Checklist']);
      ?>
	  </td>
    </tr>  
     
    <tr>
      <td colspan="3" align="left">
	      <input type="submit" name="alterar" class="button-tela" value="Alterar" />
	      <script language="JavaScript"> 
					function pergunta(){ 
   						if(confirm('Tem certeza que deseja deletar este item?')){ 
      					document.Checklist.submit(); 
   					} 
				} 
		</script> 
	      <input type="button" class="button-tela" onclick="pergunta()" name="apagar" value="Apagar" />	      
      </td>
    </tr>
    
  </table>
</form>

</fieldset>
</td>
</tr>
</table>
<?php 
unset($_SESSION['cadastrar/Checklist']);
unset($_SESSION['dia_semana']);
?>