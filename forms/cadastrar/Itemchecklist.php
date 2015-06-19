<form name="cadastrar/ItemChecklist" enctype="multipart/form-data" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/itemchecklist.php">
 
<fieldset>
	<legend>Cadastrar Tarefa</legend>
  <table width="300" border="0">
    <tr>
      <td colspan="2" align="center">
      <?php Texto::mostrarMensagem($_SESSION['erro']);?>
    	</td>
    </tr>
    
        <tr>
		    <td>
		    	Dias da semana:
		    </td>
		    	<td nowrap="nowrap"> 
		    		Domingo: <input type="checkbox" name="dse_domingo" checked="checked" value="1" > |
		    		Segunda: <input type="checkbox" name="dse_segunda" checked="checked" value="1" >  |
		    		Terça: <input type="checkbox" name="dse_terca" checked="checked" value="1" > |
		    		Quarta: <input type="checkbox" name="dse_quarta" checked="checked" value="1" > |
		    		Quinta: <input type="checkbox" name="dse_quinta" checked="checked" value="1" > |
		    		Sexta: <input type="checkbox" name="dse_sexta" checked="checked" value="1" > |
		    		Sábado: <input type="checkbox" name="dse_sabado" checked="checked" value="1" >
		    	</td>
    	</tr>    
    	
    <tr>
      <td nowrap="nowrap">Tarefa:</td>
      <td>
      <input name="ich_titulo_tarefa" type="text" size="40" value="<?php echo $_SESSION['cadastrar/ItemChecklist']['ich_titulo_tarefa']?>" />
      </td>
    </tr>
    <tr>
      <td nowrap="nowrap">Link:</td>
      <td>
      <input name="ich_link" type="text" size="40" value="<?php echo $_SESSION['cadastrar/ItemChecklist']['ich_link']?>" />
      <input name="che_codigo" type="hidden"  value="<?php echo $_SESSION['cadastrar/ItemChecklist']['che_codigo']?>" />      
      </td>
    </tr>
    <tr>
      <td nowrap="nowrap">Ativo:</td>
      <td>
      <?php 
      	$tbsn = new TbSimNao();
      	FormComponente::selectOption('ich_ativo', $tbsn->selectSimNao(),false,$_SESSION['cadastrar/ItemChecklist']['ich_ativo']);
      ?>
	  </td>
    </tr>
	<tr>
      <td align="left" nowrap="nowrap">Anexar Procedimento:</td>
	      <td>
			<input type="file" name="arquivo" value=""> 
	      </td>
    </tr>
    <tr>
      <td colspan="2" align="left">
	      <input type="submit" name="alterar" class="button-tela" value="Cadastrar" />
</form>
<form action="" method="post">
 <input type="submit" name="alterar" class="button-tela" value="Cancelar" />
</form>
	  </td>
    </tr>
  </table>
 </fieldset>
<?php unset($_SESSION['cadastrar/ItemChecklist']);?>