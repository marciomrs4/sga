<?php 
$tbsolicitacao = new TbSolicitacao();

$dados = $tbsolicitacao->getFormAssentamento(base64_decode($_SESSION['valorform']));

$tbSolicitacaoTerceiro = new TbSolicitacaoTerceiro();
$SolicitacaoTerceiro = $tbSolicitacaoTerceiro->getChamadoInTerceiro($dados['sol_codigo']);

?>


<fieldset>
	<legend><b>Assentamento</b></legend>
<form name="cadastrar/AssentamentoSolicitante" id="Assentamento" class="<?php echo ($SolicitacaoTerceiro['sot_status'] == 'S') ? 'solicitacao-emterceiro' : ''; ?>"
      enctype="multipart/form-data" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/assentamento.php">
  <table width="300" border="0">
    <tr>
      <td colspan="2">
      <?php Texto::mostrarMensagem($_SESSION['erro']);?>

      <span class="aviso-em-terceiro" >
          <?php
          if($SolicitacaoTerceiro['sot_status'] == 'S'){
              echo 'Chamado com ',$tbSolicitacaoTerceiro->getDescricaoTerceiro($SolicitacaoTerceiro['sot_codigo']),
                   '. Tempo:  ',$tbSolicitacaoTerceiro->getTempoEmTerceiro($SolicitacaoTerceiro['sot_codigo']);
          }
          ?>
      </span>

    </td>
    </tr>
      <tr>
          <td>
              &nbsp;
          </td>
      </tr>
    <tr>
      <th nowrap="nowrap">Número do Chamado:</th>
      <td>
      	<?php echo($dados[0]); ?>
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
      <th nowrap="nowrap">Descri??o da Atividade:</th>
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
      <td colspan="2" align="left">
			&nbsp;
	  </td>
	</tr>
	
        
    <tr>
    <td>
    </td>
      <td nowrap="nowrap">
	  <?php
	  if($dados[2] != 3)
	  { 
	      echo('<input type="submit" name="alterar" class="button-tela" id="botaoSave" value=" Salvar " />');
	  }
	  ?>
	  	      <span class="botaoSave" style="visibility: hidden"><img src="./css/images/299.GIF"></span>

</form>
		<hr>
      	
      	<form action="">
 	    	<input type="submit" name="alterar" class="button-tela" value=" Voltar " />
 	    </form>
	  </td>
  	</tr>

 </table>

<hr>
  	<?php 
  	try
  	{
	  	$tbassentamento = new TbAssentamento();
	  	$tabela = $tbassentamento->listarAssentamento($dados[0]);
	
	  	$cabecalho = array('Descri??o','Data','Editor');
	  	
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