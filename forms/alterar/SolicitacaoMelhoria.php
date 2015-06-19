<?php 

Sessao::validarForm('cadastrar/SolicitacaoMelhoria'); 

$tbMelhoria = new TbSolicitacaoMelhoria();

$_SESSION['cadastrar/SolicitacaoMelhoria'] = $tbMelhoria->getForm(base64_decode($_SESSION['valorform']));

$tbsistemas = new TbSistemas();

?>


<fieldset>
	<legend>Nova Melhoria </legend>
  <form name="solicitacaoMelhoria" id="solicitacaoMelhoria"  method="post" enctype="multipart/form-data" action="../<?php echo($_SESSION['projeto']); ?>/action/solicitacaoMelhoria.php">	
  
 
  <fieldset>
	<legend>Ações</legend>
		<div class="acoesmelhoria">	
			<?php if(($tbsistemas->getUsuarioChave($_SESSION['cadastrar/SolicitacaoMelhoria']['sis_codigo']) == $_SESSION['usu_codigo']) AND 
						($_SESSION['cadastrar/SolicitacaoMelhoria']['usu_codigo_atendente'] == '')) {?>
			<a href="./action/atendermelhoria.php?<?php echo(base64_encode('atender/melhoria').'='.base64_encode($_SESSION['cadastrar/SolicitacaoMelhoria']['som_codigo']));?>">
				<img src="./css/images/atender.png" title="Atender"></a>
				<?php }?>			
			<a href="./action/formcontroler.php?<?php echo(base64_encode('cadastrar/apontamentoMelhoria').'='.base64_encode($_SESSION['cadastrar/SolicitacaoMelhoria']['som_codigo']));?>">
				<img src="./css/images/novo.png" title="Apontamento"></a>
		</div>
  </fieldset>
	<hr/>
  
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="2" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
      </td>
    </tr>
    
    <tr>
        <th nowrap="nowrap">
    	Número da melhoria:
    	</th>
    	<td>
    	<?php echo($_SESSION['cadastrar/SolicitacaoMelhoria']['som_codigo']); ?>
    	</td>
    </tr>
    
    <tr>
	  	<th nowrap="nowrap">
	   		Aberto por:
	  	</th>
    	<td>
	    		<?php  
	    		$tbusuario = new TbUsuario(); 
	    		$tbdepartamento = new TbDepartamento();
	    		$Usuario = $tbusuario->getUsuario($_SESSION['cadastrar/SolicitacaoMelhoria']['usu_codigo_solicitante']); 
	    		
	    		echo $Usuario['usu_email'];
	    		
	    		?>
	  	</td>
	 </tr>
	 
	 <tr>
	  	<th>
	   	</th>
	    	<td nowrap="nowrap">
	    	<?php echo 'Ramal: '.$Usuario['usu_ramal'].' / '.$tbdepartamento->getDepDescricao($Usuario['dep_codigo']);?>
	    	</td>
	    </tr>
	 
	 
	<tr>
    	<td colspan="2">
    	&emsp;
    	</td>
    </tr>
	 
	    
      <th width="119" align="left" nowrap="nowrap">Sistema:</th>
      	<input type="hidden" name="som_codigo" value="<?php echo($_SESSION['cadastrar/SolicitacaoMelhoria']['som_codigo']); ?>" />
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
      	
      	<form action="" method="post">
 	    	<input type="submit" name="alterar" class="button-tela" value=" Voltar " />
 	    </form>
	  </td>
  	</tr>

 </table>
 
   	<?php 
  	
  	try
  	{
	  	$tbApontamento = new TbApontamentoMelhoria();
	  	
	  	$tabela = $tbApontamento->listarApontamentoMelhoria($_SESSION['cadastrar/SolicitacaoMelhoria']['som_codigo']);
	
	  	$cabecalho = array('Descrição','Status','Data','Editor');
	  	
	  	$grid = new DataGrid($cabecalho, $tabela);
	  	
	  	$grid->titulofield = 'Apontamento(s)';
	  	$grid->islink = false;
	  	$grid->colunaoculta = 1;
	  	$grid->mostrarDatagrid(1);
	  	
  	}catch (Exception $e)
  	{
  		echo $e->getMessage();
  	}
  	?>
 
</fieldset>

<?php unset($_SESSION['cadastrar/SolicitacaoMelhoria']);?>