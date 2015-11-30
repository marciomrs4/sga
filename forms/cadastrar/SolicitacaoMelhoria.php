<?php 
Sessao::validarForm('cadastrar/SolicitacaoMelhoria'); 
?>


<fieldset>
	<legend>Nova Melhoria </legend>
  <form name="solicitacaoMelhoria" id="solicitacaoMelhoria"  method="post" enctype="multipart/form-data" action="../<?php echo($_SESSION['projeto']); ?>/action/solicitacaoMelhoria.php">	
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="2" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
      </td>
    </tr>
    
    <tr>
      <th width="119" align="left" nowrap="nowrap">Sistema:</th>
      <td>
		<?php 
		$tbsistemas = new TbSistemas();
		FormComponente::$name = 'Selecione';
		FormComponente::selectOption('sis_codigo',$tbsistemas->listarSistemas(),true,$_SESSION['cadastrar/SolicitacaoMelhoria']);
		?>
      </td>
    </tr>
    
    <tr>
      <th align="left" nowrap="nowrap">Descrição do <?php echo($_SESSION['config']['problema']); ?>:</th>
	      <td>
	      	<textarea name="som_descricao" rows="10" cols="50"><?php echo($_SESSION['cadastrar/SolicitacaoMelhoria']['som_descricao']); ?></textarea>
	      </td>
    </tr>
    <tr>
      <th>Anexar Arquivo:</th>
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