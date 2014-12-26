<?php 
$tbsolicitacao = new TbSolicitacao();
$_SESSION['alterar/Solicitacao'] = $tbsolicitacao->getFormReceptor(base64_decode($_SESSION['valorform']));

$tbatendimentosolicitante = new TbAtendenteSolicitacao();
$usu_codigo = $tbatendimentosolicitante->confirmarAtendente($_SESSION['alterar/Solicitacao']['sol_codigo'])

?>

	<fieldset>
		<legend>Alterar Chamado</legend>
			<form name="solicitacao" id="solicitacao" method="post" enctype="multipart/form-data" action="../<?php echo($_SESSION['projeto']); ?>/action/solicitacao.php">				
			<fieldset>
				<legend>Ações</legend>
				<div class="acoeschamado">
				<?php 
				if($usu_codigo)
				{}else{
				?>
				<a href="./action/atenderchamado.php?<?php echo(base64_encode('atender/chamado').'='.base64_encode($_SESSION['alterar/Solicitacao']['sol_codigo']));?>"><img src="./css/images/atender.png" title="Atender"></a>
				
				<?php
				 } 
				?>
				<a href="./action/formcontroler.php?<?php echo(base64_encode('cadastrar/Assentamento').'='.base64_encode($_SESSION['alterar/Solicitacao']['sol_codigo']));?>"><img src="./css/images/novo.png" title="Assentamento"></a>
				
				<a href="./GerarRelatorioPdf.php?<?php echo(base64_encode('codigo').'='.base64_encode($_SESSION['alterar/Solicitacao']['sol_codigo']));?>" target="blank"><img src="./css/images/pdf.png" title="Gerar PDF"></a>
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
	    		Número do Chamado:
	    	</th>
    		<td>
	    		<?php echo($_SESSION['alterar/Solicitacao']['sol_codigo']); ?>
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
	    		$Usuario = $tbusuario->getUsuario($_SESSION['alterar/Solicitacao']['usu_codigo_solicitante']); 
	    		
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
	    		<th>
	    			Status do Chamado:
	    		</th>
	    		<td>
	    			<?php 
	    			$tbstatuschamado = new TbStatus();
	    			echo $tbstatuschamado->getDescricao($_SESSION['alterar/Solicitacao']['sta_codigo']);
	    			?>
	    		</td>
    		</tr>
	    	<tr>
	    		<th>
	    			Prioridade:
	    		</th>
	    		<td>
	    			<?php 
	    			$solicitacao = $tbsolicitacao->getPrioridadeTempoAtendimento($_SESSION['alterar/Solicitacao']['sol_codigo']);
	    			echo($solicitacao[2]);
	    			?>
	    		</td>
    		</tr>    		    		
	    	<tr>
	    		<th>
	    			SLA:
	    		</th>
	    		<td>
	    			<?php 
	    			echo($solicitacao[3]);
	    			?>
	    		</td>
    		</tr>
			<tr>
	    		<th>
	    			Atendente:
	    		</th>
	    		<td>
	    			<?php 
					if($usu_codigo)
					{
					$tbusuario = new TbUsuario();
					$Atendente = $tbusuario->getUsuario($usu_codigo);
					echo($Atendente[2]);
					}else{
						echo("Sem atendente");
					}
	    			?>
	    		</td>
    		</tr>    		    		    		
    	<tr>
	    	<th>
	    		Data de Abertura:
	    	</th>
    		<td>
    		<?php 
    		$tbcalcatendimento = new TbCalculoAtendimento();
    		#Pega a data da solicitação pelo STATUS informado, no caso 1 é ABERTURA
    		echo $tbcalcatendimento->getDataPorStatus($_SESSION['alterar/Solicitacao']['sol_codigo'],1);
			?>
    		</td>
    	</tr>    	
    <tr>
      <th width="119" align="left" nowrap="nowrap">Departamento:</th>
      <td>
      	<input type="hidden" name="sol_codigo" value="<?php echo($_SESSION['alterar/Solicitacao']['sol_codigo']); ?>">
		<?php 
		$tbdepartamento = new TbDepartamento();
		FormComponente::$name = 'Selecione';
		FormComponente::selectOption('dep_codigo',$tbdepartamento->listarDepartamentos(),true,$_SESSION['alterar/Solicitacao']);
		?>
      </td>
    </tr>
    <tr>
      <th align="left" nowrap="nowrap"><?php echo($_SESSION['config']['problema']);?>:</th>
	  <td>
		<?php 
		$tbproblema = new TbProblema();
		FormComponente::selectOption('pro_codigo',$tbproblema->listarProblema($_SESSION['alterar/Solicitacao']['dep_codigo']),false,$_SESSION['alterar/Solicitacao']);
		?>
	  </td>
    </tr>
    <tr>
      <th align="left" nowrap="nowrap">Descrição do <?php echo($_SESSION['config']['problema']);?>:</th>
	      <td>
	      	<textarea name="sol_descricao_solicitacao" rows="10" cols="50"><?php echo($_SESSION['alterar/Solicitacao']['sol_descricao_solicitacao']); ?></textarea>
	      </td>
    </tr>
		<?php
		$tbanexo = new TbAnexo();
		$dados = $tbanexo->getForm($_SESSION['alterar/Solicitacao']['sol_codigo']);
		if($dados['ane_anexo']){
		?>
	<tr>
		<th>Arquivo Anexo</th>
		<td>
		<a href="BaixarArquivo.php?<?php echo(base64_encode('id').'='.base64_encode($dados['ane_codigo'])); ?>" target="_blank" ><?php echo($dados['ane_nome']);?></a>
			</td>
	    </tr>
	    <?php }?>
		<tr>
    	<th><?php if( !$usu_codigo){ echo('Alterar Anexo:');  ?></th>     		
    	<td><input type="file" name="arquivo" /><?php }?></td>
    </tr>
        
    <tr>
      <td colspan="2" align="left">
			&nbsp;
	  </td>
	</tr>
    
    <tr>
    
    <td>
    	&emsp;	
    </td>
    
      <td colspan="2" align="left">
      <?php if($usu_codigo){}else{?>
	      <input type="submit" name="cadastrar" class="button-tela" id="botaoSave" value="Salvar" />
	      <span class="botaoSave" style="visibility: hidden"><img src="./css/images/299.GIF"></span>
	      <?php }?>

</form>

		<hr>
      	
      	<form action="">
 	    	<input type="submit" name="alterar" class="button-tela" value=" Voltar " />
 	    </form>
	  </td>
  	</tr>

 </table>

       <div id="insere_aqui">
  	<?php 
  	try
  	{
	  	$tbassentamento = new TbAssentamento();
	  	$tabela = $tbassentamento->listarAssentamento($_SESSION['alterar/Solicitacao']['sol_codigo']);
	
	  	$cabecalho = array('Descrição','Data','Editor');
	  	
	  	$grid = new DataGrid($cabecalho, $tabela);
	  	
	  	$grid->titulofield = 'Assentamento(s)';
	  	$grid->acao = 'alterar/Assentamento';
	  	$grid->islink = false;
	  	$grid->colunaoculta = 1;
	  	$grid->mostrarDatagrid(1);
	  	
  	}catch (Exception $e)
  	{
  		echo $e->getMessage();
  	}
  	?>     
     </div>
</fieldset>

<?php unset($_SESSION['alterar/Solicitacao']);?>