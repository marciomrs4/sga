<?php 
Sessao::validarForm('cadastrar/Solicitacao'); 
?>


<fieldset>
	<legend> Abrir Chamado </legend>
  <form name="solicitacao" id="solicitacao"  method="post" enctype="multipart/form-data" action="../<?php echo($_SESSION['projeto']); ?>/action/solicitacao.php">	
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="2" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
      </td>
    </tr>
    
    <tr>
      <th width="119" align="left" nowrap="nowrap">Departamento:</th>
      <td>
		<?php 
		$tbdepartamento = new TbDepartamento();

        $FormDepCodigo = new SelectOption();
        $FormDepCodigo->setStmt($tbdepartamento->listarDepartamentos())
                      ->setOptionEmpty('Selecione')
                      ->setSelectedItem($_SESSION['cadastrar/Solicitacao']['dep_codigo'])
                      ->setSelectName('dep_codigo')
                      ->listOption();

		?>
      </td>
    </tr>
    <tr>
      <th align="left" nowrap="nowrap"><?php echo($_SESSION['config']['problema']); ?>:</th>
	      <td>
              <select name="pro_codigo"></select>
          </td>
    </tr>
    <tr>
      <th align="left" nowrap="nowrap">Descri��o do <?php echo($_SESSION['config']['problema']); ?>:</th>
	      <td>
	      	<textarea name="sol_descricao_solicitacao" rows="10" cols="50"><?php echo($_SESSION['cadastrar/Solicitacao']['sol_descricao_solicitacao']); ?></textarea>
	      </td>
    </tr>
        
         <tr>
	   <th nowrap="nowrap">Enviar e-mail para:</th>
	   	<td nowrap="nowrap"> 
	   		Departamento: <input type="checkbox" name="Departamento" checked="checked" value="1" >
	   		|
	   		Solicitante: <input type="checkbox" name="Solicitante" checked="checked" value="1" >
	   	</td>
    </tr>    
        
    <tr>
    	<th>Anexo:</th>
    	<td>
    		<input type="file" name="arquivo" />
    	</td>
    </tr>
    
    <tr>
    	<td colspan="2">
    	&emsp;
    	</td>
    </tr>
    
    <tr>
    <td>
    </td>
      <td nowrap="nowrap">
	      <input type="submit" name="cadastrar" class="button-tela" id="botaoSave" value="Salvar" />
	      <span class="botaoSave" style="visibility: hidden"><img src="./css/images/299.GIF"></span>


</form>
		<hr>
      	
      	<form action="">
 	    	<input type="submit" name="alterar" class="button-tela" value=" Voltar " />
 	    </form>
	  </td>
  	</tr>

 </table>
</fieldset>

<?php unset($_SESSION['cadastrar/Solicitacao']);?>