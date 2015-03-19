<?php 
$tbsolicitacaoMelhoria = new TbSolicitacaoMelhoria();

$dados = $tbsolicitacaoMelhoria->getForm(base64_decode($_SESSION['valorform']));

?>


<fieldset>
	<legend><b>Apontamento</b></legend>
  <form name="cadastrar/ApontamentoMelhoria" id="ApontamentoMelhoria" enctype="multipart/form-data" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/apontamentoMelhoria.php">
	<table width="300" border="0">

    <tr>
      <td colspan="2">	
      <?php Texto::mostrarMensagem($_SESSION['erro']);?>
    </td>
    </tr>

    <tr>
      <th nowrap="nowrap">Número da Melhoria:</th>
      <td>
      	<?php echo($dados['som_codigo']); ?>
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
	    		
	    		$Usuario = $tbusuario->getUsuario($dados['usu_codigo_solicitante']); 
	    		
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
    	<td>
    	&nbsp;
    	</td>
    </tr>
    
    <tr>
      <th nowrap="nowrap">Descrição da melhoria:</th>
      <td>
      	<?php echo($dados['som_descricao']); ?>
      </td>
    </tr>
    
    <tr>
    	<td>
    	&nbsp;
    	</td>
    </tr>    
    
    <tr>
      <th nowrap="nowrap">Descricão:</th>
      <td>
      <textarea name="apm_descricao" cols="55" rows="7"	><?php echo($_SESSION['cadastrar/ApontamentoMelhoria']['apm_descricao']); ?></textarea> 
      <input type="hidden" name="som_codigo" value="<?php echo($dados['som_codigo']); ?>">	
      </td>
    </tr>
    <tr>
      <th nowrap="nowrap">Status:</th>
      <td>
      <?php 
      	$tbstatus = new TbStatusMelhoria();
      	FormComponente::selectOption('stm_codigo', $tbstatus->listarStatusSemPendente(),false,$dados['stm_codigo']);
      ?>
	  </td>
    </tr>    
    
    <tr>
	    <th nowrap="nowrap">Enviar e-mail para:</th>
	    	<td nowrap="nowrap"> 
	    			Atendente: <input type="checkbox" name="Atendente" checked="checked" value="1" >
		    		|
		    		Solicitante: <input type="checkbox" name="Solicitante" checked="checked" value="1" >
		    	</td>
    	</tr>    
            
    <tr>
      <td colspan="2" align="left">
			&nbsp;
	  </td>
	</tr>
	
	<tr>	
  	  <td>
  	   </td>
  	   <td nowrap="nowrap">
  	    <input type="submit" name="alterar" class="button-tela" id="botaoSave" value=" Salvar " />
	    <span class="botaoSave" style="visibility: hidden"><img src="./css/images/299.GIF"></span>

    
</form>
		<hr>
      	
      	<form action="" method="post">
 	    	<input type="submit" name="alterar" class="button-tela" value=" Voltar " />
 	    </form>
	  </td>
  	</tr>

 </table>
 
<hr>
  	<?php 
  	
  	try
  	{
	  	$tbApontamento = new TbApontamentoMelhoria();
	  	
	  	$tabela = $tbApontamento->listarApontamentoMelhoria($dados['som_codigo']);
	
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
<?php 
unset($_SESSION['cadastrar/AssentamentoMelhoria']);?>