<?php 

$tbAtividade =  new TbAtividade();

$_SESSION['alterar/Atividade'] = $tbAtividade->getFormAlteracao(base64_decode($_SESSION['valorform'])); 

$tbUsuAtividade = new TbUsuarioAtividade();
$at_codigo = $tbUsuAtividade->verificaUsuariosAtividade($_SESSION['alterar/Atividade']['at_codigo']);

?>
<fieldset>
	<legend>Alterar Atividade</legend>
<form name="projeto" id="projeto" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/atividade.php">

			<fieldset>
				<legend>Ações</legend>
				<div class="acoeschamado">
					<a href="./action/formcontroler.php?<?php echo(base64_encode('cadastrar/UsuarioAtividade').'='.base64_encode($_SESSION['alterar/Atividade']['at_codigo']));?>">
						<img src="./css/images/new_usuario.png" title="Adcionar Usuário">
					</a>
					
					<a href="./action/formcontroler.php?<?php echo(base64_encode('cadastrar/Apontamento').'='.base64_encode($_SESSION['alterar/Atividade']['at_codigo']));?>">
						<img src="./css/images/novo.png" title="Adcionar Apontamento">
					</a>
				<a href="./GerarRelatorioAtividadePdf.php?<?php echo(base64_encode('codigo').'='.base64_encode($_SESSION['alterar/Atividade']['at_codigo']));?>" target="blank"><img src="./css/images/pdf.png" title="Gerar PDF"></a>
				</div>
			</fieldset>
			
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="2" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
   		<input name="at_codigo" type="hidden" value="<?php echo($_SESSION['alterar/Atividade']['at_codigo']); ?>" />     	       	
      </td>
    </tr>

	<tr>
		<th nowrap="nowrap">Projeto:</th>
		<td>
	    <?php 
		$tbProjeto = new TbProjeto();
		FormComponente::$name = 'Selecione...';
		FormComponente::selectOption('pro_codigo', $tbProjeto->listarProjetoAlteracaoAtividade($_SESSION['dep_codigo']),true,$_SESSION['alterar/Atividade']);
		?>
		</td>
     </tr>
	
	<tr>
		<th nowrap="nowrap"><?php echo($_SESSION['config']['usuario']);?> Executor:</th>
		<td>
	    <?php
		$tbUsuario = new TbUsuario(); 

		if($at_codigo == '')
	    {
			FormComponente::$name = 'Selecione...';
			FormComponente::selectOption('usu_codigo_responsavel', $tbUsuario->selectUsuarioDepCompleto($_SESSION['dep_codigo']),true,$_SESSION['alterar/Atividade']);
	    }else
	    {
	    	$dadosUsuario = $tbUsuario->getForm($_SESSION['alterar/Atividade']['usu_codigo_responsavel']);
	    ?>	
	    	<input type="text" value="<?php echo($dadosUsuario[1].' '.$dadosUsuario[2]);?>"  />
	    	<input type="hidden" name="usu_codigo_responsavel" value="<?php echo($dadosUsuario[0]);?>"  />
	    <?php
	    }
		?>
		</td>
     </tr>
	<tr>
		<th nowrap="nowrap">Status:</th>
		<td>
	    <?php 
		$tbStatusAtividade = new TbStatusAtividade();
		FormComponente::selectOption('sta_codigo', $tbStatusAtividade->listarStatusAtividade(),false,$_SESSION['alterar/Atividade']);
		?>
		</td>
     </tr>     
     
     <tr>
       <th width="119" align="left" nowrap="nowrap">Previsão Inicio:</th>
     	<td> 	
      		<input type="text" id="data-id" class="data" name="at_previsao_inicio" value="<?php echo(ValidarDatas::dataCliente($_SESSION['alterar/Atividade']['at_previsao_inicio'])); ?>"  />
     	</td>
     </tr>
     
      <tr>
       <th width="119" align="left" nowrap="nowrap">Previsão Fim:</th>	
      	<td>
      		<input type="text" id="data" class="data" name="at_previsao_fim" value="<?php echo(ValidarDatas::dataCliente($_SESSION['alterar/Atividade']['at_previsao_fim'])); ?>"  />
     	</td>
     </tr>

    <tr>
      <th width="119" align="left" nowrap="nowrap">Descrição:</th>
      <td>
      	<textarea name="at_descricao" rows="5" cols="32"><?php echo($_SESSION['alterar/Atividade']['at_descricao']); ?></textarea>
      </td>
    </tr>
    
    <tr>
      <th width="119" align="left" nowrap="nowrap">Observação:</th>
      <td>
      	<textarea name="at_observacao" rows="5" cols="32"><?php echo($_SESSION['alterar/Atividade']['at_observacao']); ?></textarea>
      </td>
    </tr>    
    
    <tr>
      <td colspan="2" align="left">
	      <input type="submit" name="cadastrar" class="button-tela" value="Salvar" />
      </td>
    </tr>
    
  </table>

	</form>
	
	<hr>
  	<?php 
  	try
  	{
	  	$tbApontamento = new TbApontamento();
	  	$tabela = $tbApontamento->listarApontamento($_SESSION['alterar/Atividade']['at_codigo']);
	
	  	$cabecalho = array('Descrição','Data',$_SESSION['config']['usuario']);
	  	
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

<?php unset($_SESSION['alterar/Atividade']);?>