<?php 
Sessao::validarForm('alterar/Projeto'); 

$tbprojeto = new TbProjeto();
$_SESSION['alterar/Projeto'] = $tbprojeto->getFormAlteracao(base64_decode($_SESSION['valorform']));

?>
<table>
	<tr>
		<td>
			<fieldset>
				<legend>Alterar Projeto</legend>
<form name="arquivo" id="projeto" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/projeto.php">
  
  	<fieldset>
		<legend>Ações</legend>
			<div class="acoeschamado">
				<a href="./GerarRelatorioProjetoPdf.php?<?php echo(base64_encode('codigo').'='.base64_encode($_SESSION['alterar/Projeto']['pro_codigo']));?>" target="blank"><img src="./css/images/pdf.png" title="Gerar PDF"></a>
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
      <th width="119" align="left" nowrap="nowrap">Código:</th>
      <th>
      	<?php 
			echo $_SESSION['alterar/Projeto']['pro_cod_projeto'];
      	 ?>
      </th>
    </tr>
     
     <tr>
     	<th>
      		<input name="pro_codigo" type="hidden" value="<?php echo($_SESSION['alterar/Projeto']['pro_codigo']);?>" />     	 
     	</th>
     </tr>
     
     <tr>
      <th width="119" align="left" nowrap="nowrap">Titulo:</th>
      <td>
      	<input name="pro_titulo" type="text" size="40" maxlength="255" value="<?php echo($_SESSION['alterar/Projeto']['pro_titulo']); ?>" />
      </td>
    </tr>
     
     <tr>
		<th nowrap="nowrap"><?php echo($_SESSION['config']['usuario']);?> Solicitante:</th>
		<td>
	    <?php 
		$tbUsuario = new TbUsuario();
		FormComponente::selectOption('usu_codigo_solicitante', $tbUsuario->selectUsuarios(),false,$_SESSION['alterar/Projeto']);
		?>
		</td>
     </tr>
     
     <tr>
       <th width="119" align="left" nowrap="nowrap">Previsão Inicio:</th>
     	<td> 	
      		<input type="text" id="data-id" class="data" name="pro_previsao_inicio" value="<?php echo(ValidarDatas::dataCliente($_SESSION['alterar/Projeto']['pro_previsao_inicio'])); ?>"  />
     	</td>
     </tr>
     
      <tr>
       <th width="119" align="left" nowrap="nowrap">Previsão Fim:</th>	
      	<td>
      		<input type="text" id="data" class="data" name="pro_previsao_fim" value="<?php echo(ValidarDatas::dataCliente($_SESSION['alterar/Projeto']['pro_previsao_fim'])); ?>"  />
     	</td>
     </tr>

	<tr>
		<th nowrap="nowrap">Status do Projeto:</th>
		<td>
	    <?php 
		$tbStatusProjeto = new TbStatusProjeto();
		FormComponente::selectOption('stp_codigo', $tbStatusProjeto->selectStatus(),false,$_SESSION['alterar/Projeto']);
		?>
		</td>
     </tr>


    <tr>
      <th width="119" align="left" nowrap="nowrap">Descrição do Projeto:</th>
      <td>
      	<textarea name="pro_descricao" rows="5" cols="32"><?php echo($_SESSION['alterar/Projeto']['pro_descricao']); ?></textarea>
      </td>
    </tr>
   
    <tr>
      <td colspan="2" align="left">
	      <input type="submit" name="cadastrar" class="button-tela" value="Salvar" />
      </td>
    </tr>
    
  </table>
</form>

</fieldset>
</td>
</tr>
</table>
<?php unset($_SESSION['alterar/Projeto']);?>