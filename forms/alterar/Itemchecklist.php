<?php 
$tbitemchecklist = new TbItemChecklist();
$tbDiaSemana = new TbDiaSemana();

$_SESSION['itemchecklist'] = $tbitemchecklist->getForm(base64_decode($_SESSION['valorform']));

$_SESSION['dia_semana'] = $tbDiaSemana->getForm($_SESSION['itemchecklist']['ich_codigo']);

?>
<form name="itemchecklist" enctype="multipart/form-data" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/itemchecklist.php">
 
<fieldset>
	<legend>Cadastrar Tarefa</legend>
  <table width="300" border="0">
    <tr>
      <td colspan="2">
      <?php Texto::mostrarMensagem($_SESSION['erro']);?>
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
      <td nowrap="nowrap">Tarefa:</td>
      <td>
      <input name="ich_titulo_tarefa" type="text" size="40" value="<?php echo $_SESSION['itemchecklist']['ich_titulo_tarefa']?>" />
      </td>
    </tr>
    <tr>
      <td nowrap="nowrap">Link:</td>
      <td>
      <input name="ich_link" type="text" size="40" value="<?php echo $_SESSION['itemchecklist']['ich_link']?>" />
      <input name="ich_codigo" type="hidden"  value="<?php echo $_SESSION['itemchecklist']['ich_codigo']?>" />      
      </td>
    </tr>
    <tr>
      <td nowrap="nowrap">Ativo:</td>
      <td>
      <?php 
      	$tbsn = new TbSimNao();
      	FormComponente::selectOption('ich_ativo', $tbsn->selectSimNao(),false,$_SESSION['itemchecklist']['ich_ativo']);
      ?>
	  </td>
    </tr>   
	<?php
		$tbanexo = new TbAnexoCheckList();
		$dados = $tbanexo->getForm($_SESSION['itemchecklist']['ich_codigo']);
		if($dados['ane_anexo']){
		?>
	<tr>
		<th>Arquivo Anexo</th>
		<td>
		<a href="BaixarArquivoAnexoCheckList.php?<?php echo(base64_encode('id').'='.base64_encode($dados['ane_codigo'])); ?>" target="_blank" ><?php echo($dados['ane_nome']);?></a>
		 <input name="ane_codigo" type="hidden"  value="<?php echo($dados['ane_codigo']); ?>" /> 
			</td>
	    </tr>
	    <?php }?>     
	<tr>
      <td align="left" nowrap="nowrap">Anexar Procedimento:</td>
	      <td>
			<input type="file" name="arquivo" value=""> 
	      </td>
    </tr>
    <tr>
      <td colspan="2" align="left" nowrap="nowrap"">
	      <input type="submit" name="alterar"  class="button-tela" value="Alterar" />
		<script language="JavaScript"> 
					function pergunta(){ 
   						if(confirm('Tem certeza que deseja deletar este item?')){ 
      					document.itemchecklist.submit(); 
   					} 
				} 
		</script> 	      
	      <input type="button" name="apagar" onclick="pergunta()" class="button-tela" value="Apagar" />	      
</form>
	
<form action="" method="post">
 <input type="submit" name="alterar" class="button-tela" value="Cancelar" />
</form>
	  </td>
    </tr>
  </table>
 </fieldset>
<?php 
unset($_SESSION['itemchecklist']);
unset($_SESSION['dia_semana']);
?>