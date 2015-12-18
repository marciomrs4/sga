<?php 

$tbSolicitacaoTerceiro = new TbSolicitacaoTerceiro();
$SolicitacaoTerceiro = $tbSolicitacaoTerceiro->getTerceiro(base64_decode($_SESSION['valorform']))
                                             ->fetch(\PDO::FETCH_ASSOC);

$tbsolicitacao = new TbSolicitacao();
$dados = $tbsolicitacao->getFormAssentamento($SolicitacaoTerceiro['sol_codigo']);

?>

<fieldset>
	<legend><b>Remover de terceiro</b></legend>
  <form name="cadastrar/EnvioTerceiro" id="EnvioTerceiro" enctype="multipart/form-data" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/envioterceiro.php">
	<table width="300" border="0">

    <tr>
      <td colspan="2">	
      <?php Texto::mostrarMensagem($_SESSION['erro']);?>
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
      <th nowrap="nowrap">Descrição do Chamado:</th>
      <td>
      	<?php echo($dados[1]); ?>
      </td>
    </tr>    
    
    <tr>
    	<td>
    	&nbsp;
    	</td>
    </tr>
    
    <tr>
      <th nowrap="nowrap">Descrição:</th>
      <td>
      <textarea name="sot_descricao_remocao" cols="55" rows="7"	><?php echo($_SESSION['cadastrar/EnvioTerceiro']['sot_descricao_remocao']); ?></textarea>
        <input type="hidden" name="sol_codigo" value="<?php echo($dados[0]); ?>">
        <input type="hidden" name="sot_codigo" value="<?php echo($SolicitacaoTerceiro['sot_codigo']); ?>">
      </td>
    </tr>
   
   <tr>
      <th nowrap="nowrap">Data:</th>
    	<td>
    	<input type="text" readonly value="<?php echo(date('d-m-Y')); ?>" name="dataenvio" />
    	</td>
    </tr>

   <tr>
       <th nowrap="nowrap">Hora:</th>
    	<td>
    	<input type="text" readonly value="<?php echo(date('H:i:s')); ?>" name="horaenvio" />
    	</td>
    </tr>

    
    
    <tr>
      <th nowrap="nowrap">Terceiro:</th>
      <td>
      <?php 
      	$tbTerceiro = new TbTerceiro();

        $FormTerceiro = new SelectOption();
        $FormTerceiro->setStmt($tbTerceiro->listarTerceiroPorDepartamento($_SESSION['dep_codigo']))
                     ->setSelectName('ter_codigo')
                     ->setOptionEmpty('Selecione')
                     ->setSelectedItem($SolicitacaoTerceiro['ter_codigo'])
                     ->listOption();
      ?>
	  </td>
    </tr>    
    
    <tr>
	    <th nowrap="nowrap">Enviar e-mail para:</th>
	    	<td nowrap="nowrap"> 
		    		Departamento Atendente: <input type="checkbox" name="Departamento" checked="checked" value="1" >
		    		|
		    		Usuário Solicitante: <input type="checkbox" name="Solicitante" checked="checked" value="1" >
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

	<a href="action/formcontroler.php?<?php echo base64_encode('alterar/Solicitacao'); ?>=<?php echo base64_encode($dados['0']); ?>">
		<span class="button-tela">Voltar</span>
	</a>

	  </td>
  	</tr>

 </table>
 
<hr>
  	<?php

  	try
  	{

	  	$grid = new DataGrid(array('#','Terceiro','Usuario','Data de Envio','Descricao'),
                             $tbSolicitacaoTerceiro->listarEnvioTerceiro($SolicitacaoTerceiro['sol_codigo']));
	  	
	  	$grid->titulofield = 'Envio(s) para terceiro(s)';
	  	$grid->islink = false;
	  	$grid->mostrarDatagrid(1);

        $grid2 = new DataGrid(array('#','Terceiro','Usuario','Remocao','Descricao'),
                              $tbSolicitacaoTerceiro->listarRemocaoTerceiro($SolicitacaoTerceiro['sol_codigo']));

        $grid2->titulofield = 'Remocao(s) de terceiro(s)';
        $grid2->islink = false;
        $grid2->mostrarDatagrid(1);
	  	
  	}catch (Exception $e)
  	{
  		echo $e->getMessage();
  	}
  	?>
 </fieldset>
<?php 
unset($_SESSION['cadastrar/EnvioTerceiro']);?>