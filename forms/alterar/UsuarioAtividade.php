<?php 
Sessao::validarForm('cadastrar/UsuarioAtividade'); 


$tbUsuarioAtividade = new TbUsuarioAtividade();

$dados = $tbUsuarioAtividade->getForm(base64_decode($_SESSION['valorform']));

$tbAtividade =  new TbAtividade();

$_SESSION['alterar/Atividade'] = $tbAtividade->getFormAlteracao($dados[1]); 

?>

<fieldset>
	<legend><?php echo($_SESSION['config']['usuario']);?> Atividade:</legend>

<fieldset id="telausuarioatividade">
	<legend><a href="#"><span id="usuarioatividade">Informações da Atividade [Mostrar/Esconder]</span></a></legend>
			
  <table border="0" cellspacing="5" id="esconder">
	<tr>
		<th nowrap="nowrap">Projeto:</th>
		<td>
	    <?php 
		$tbProjeto = new TbProjeto();
		FormComponente::$name = 'Selecione...';
		FormComponente::selectOption('pro_codigo', $tbProjeto->listarProjetoAtivo($_SESSION['dep_codigo']),true,$_SESSION['alterar/Atividade']);
		?>
		</td>
     </tr>
	
	<tr>
		<th nowrap="nowrap"><?php echo($_SESSION['config']['usuario']);?> Executor:</th>
		<td>
	    <?php 
		$tbUsuario = new TbUsuario();
		FormComponente::$name = 'Selecione...';
		FormComponente::selectOption('usu_codigo_responsavel', $tbUsuario->selectUsuarios(),true,$_SESSION['alterar/Atividade']);
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
	</table>
</fieldset>

<form name="UsuarioAtividade" id="UsuarioAtividade" method="post" enctype="multipart/form-data" action="../<?php echo($_SESSION['projeto']); ?>/action/atividade.php">
<fieldset>
	<legend>Alterar <?php echo($_SESSION['config']['usuario']); ?> Atividade</legend>
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="5" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['mensagem'],Erro::verificarErro($_SESSION['erro'])); ?>
   		<input name="ua_codigo" type="hidden" value="<?php echo($dados[0]); ?>" />
   	    <input name="at_codigo" type="hidden" value="<?php echo($dados[1]); ?>" />
	  </td>
    </tr>
    
    <tr>
      <th width="119" align="left" nowrap="nowrap"><?php echo($_SESSION['config']['usuario']); ?>:</th>
      
      <td>
		<?php 
			$tbUsuario = new TbUsuario();
			#Retorna os dados da Atividade, Atividade, Projeto, usuario_sol e usuario_responsavel
			$dadosAtividade = $tbAtividade->getUsuarioAtividadeProjeto($_SESSION['alterar/Atividade']['at_codigo']);
			
			FormComponente::$name = 'Selecione...';
			FormComponente::selectOption('usu_codigo', $tbUsuario->selectUsuariosAtividade($dadosAtividade),true,$dados);
		?>
	  </td>
      
      <th align="left" nowrap="nowrap">Tipo de <?php echo($_SESSION['config']['usuario']); ?>:</th>
	      <td>
  		   <?php 
		       $tbTipoUsuarioAtividade = new TbTipoUsuarioAtividade();
		       FormComponente::selectOption('tua_codigo',$tbTipoUsuarioAtividade->listar(),true,$dados);
		   ?>
		 </td>

      <td colspan="2" align="left">
	      <input type="submit" name="alterar" value="Salvar" />
	      
	       <script language="JavaScript"> 
					function pergunta(){ 
   						if(confirm('Tem certeza que deseja deletar este item?')){ 
      					document.UsuarioAtividade.submit(); 
   					} 
				} 
		</script> 
	      <input type="button" onclick="pergunta()" name="apagar" value="Apagar" />	
	      </td>
	      <td>
	      <a href="./action/formcontroler.php?<?php echo(base64_encode('alterar/Atividade').'='.base64_encode($_SESSION['alterar/Atividade']['at_codigo']));?>">
						<img src="./css/images/voltar.png" title="Voltar para Atividade">
					</a>
      </td>
    </tr>

  </table>
</fieldset>
</form>
<?php 

$tbUsuarioAtividade = new TbUsuarioAtividade();

$DataGridAtividade = new DataGrid(array($_SESSION['config']['usuario'],'Tipo '.$_SESSION['config']['usuario']), 
										$tbUsuarioAtividade->listar($_SESSION['alterar/Atividade']['at_codigo']));

$DataGridAtividade->titulofield = $_SESSION['config']['usuario'].'e(s)';
$DataGridAtividade->acao = 'alterar/UsuarioAtividade';										
$DataGridAtividade->colunaoculta = 1;										
$DataGridAtividade->mostrarDatagrid(1);


unset($_SESSION['alterar/UsuarioAtividade'],$_SESSION['alterar/Atividade']);
?>
</fieldset>