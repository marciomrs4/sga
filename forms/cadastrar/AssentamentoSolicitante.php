<?php 
$tbsolicitacao = new TbSolicitacao();

$dados = $tbsolicitacao->getFormAssentamento(base64_decode($_SESSION['valorform']));

?>

<form name="cadastrar/AssentamentoSolicitante" id="Assentamento" enctype="multipart/form-data" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/assentamento.php">
<fieldset>
	<legend><b>Assentamento</b></legend>
  <table width="300" border="0">
    <tr>
      <td colspan="2">	
      <?php Texto::mostrarMensagem($_SESSION['erro']);?>
    </td>
    </tr>

    <tr>
      <th nowrap="nowrap">Descrição da Atividade:</th>
      <td>
      	<?php echo($dados[1]); ?>
      </td>
    </tr>    
    
    <tr>
      <th nowrap="nowrap">Assentamento:</th>
      <td>
      <textarea name="ass_descricao" cols="55" rows="7"	><?php echo($_SESSION['cadastrar/AssentamentoSolicitante']['ass_descricao']); ?></textarea> 
      <input type="hidden" name="sol_codigo" value="<?php echo($dados[0]); ?>">	
      </td>
    </tr>
    
        <tr>
		    <th nowrap="nowrap">Enviar e-mail para:</th>
		    	<td nowrap="nowrap"> 
		    		Departamento Atendente: <input type="checkbox" name="Departamento" checked="checked" value="1" >
		    		|
		    		Meu e-mail: <input type="checkbox" name="Solicitante" checked="checked" value="1" >
		    	</td>
    	</tr>    
    
    <tr>
      <td colspan="2" align="left">
			&nbsp;
	  </td>
	</tr>
    
    <tr>
      <th nowrap="nowrap">Fechar Chamado:</th>
      <td>
      <input type="checkbox" name="sta_codigo" value="3" 
      <?php 
      if($dados[2] == 3)
      {
      	echo('checked="checked" disabled="disabled"'); 
      } 
      ?>
      >
      <?php
      /* 
      	$tbstatus = new TbStatus();
      	FormComponente::selectOption('sta_codigo', $tbstatus->selectStatusNaoAberto(),false,$dados[2]);
      */
      ?>
	  </td>
    </tr>    
    <tr>
      <td colspan="2" align="center">
	  <?php
	  if($dados[2] != 3)
	  { 
	      echo('<input type="submit" name="alterar" class="button-tela" id="botaoSave" value=" Salvar " />');
	  }
	  ?>
	  	      <span class="botaoSave" style="visibility: hidden"><img src="./css/images/299.GIF"></span>
	  </td>
    </tr>
  </table>
</form>
<hr>
  	<?php 
  	try
  	{
	  	$tbassentamento = new TbAssentamento();
	  	$tabela = $tbassentamento->listarAssentamento($dados[0]);
	
	  	$cabecalho = array('Descrição','Data','Editor');
	  	
	  	$grid = new DataGrid($cabecalho, $tabela);
	  	
	  	$grid->titulofield = 'Assentameto(s)';
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
unset($_SESSION['cadastrar/Assentamento']);?>