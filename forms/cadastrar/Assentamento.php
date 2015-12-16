<?php 
$tbsolicitacao = new TbSolicitacao();

$dados = $tbsolicitacao->getFormAssentamento(base64_decode($_SESSION['valorform']));

$tbSolicitacaoTerceiro = new TbSolicitacaoTerceiro();
$SolicitacaoTerceiro = $tbSolicitacaoTerceiro->getChamadoInTerceiro($dados['sol_codigo']);

?>

<fieldset>
	<legend><b>Assentamento</b></legend>
  <form name="cadastrar/Assentamento" id="Assentamento" class="<?php echo ($SolicitacaoTerceiro['sot_status'] == 'S') ? 'solicitacao-emterceiro' : ''; ?>" enctype="multipart/form-data" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/assentamento.php">
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
      <th nowrap="nowrap">Descrição do Chamado:</th>
      <td>
      	<?php echo($dados[1]); ?>
      </td>
    </tr>    
    
    <tr>
      <th nowrap="nowrap">Assentamento:</th>
      <td>
      <textarea name="ass_descricao" cols="55" rows="7"	><?php echo($_SESSION['cadastrar/Assentamento']['ass_descricao']); ?></textarea> 
      <input type="hidden" name="sol_codigo" value="<?php echo($dados[0]); ?>">	
      </td>
    </tr>
    <tr>
      <th nowrap="nowrap">Status do Chamado:</th>
      <td>
      <?php 
      	$tbstatus = new TbStatus();

			  $SelectStatus = new SelectOption();
			  $SelectStatus->setStmt( $tbstatus->selectStatusNaoAberto())
						  ->setSelectName('sta_codigo')
						  ->setSelectedItem($dados['2'])
						  ->listOption();

      ?>
	  </td>
    </tr>    
    <tr>
      <th nowrap="nowrap">Atendente do Chamado:</th>
      <td>
      <?php 
      		$tbatendente = new TbAtendenteSolicitacao();
      		$atendente = $tbatendente->getNomeAtendente($dados['0']);
    
      		$tbusuario = new TbUsuario();

	  		$SelectAtendente = new SelectOption();

	  		$SelectAtendente->setStmt($tbusuario->selectUsuarioDepCompleto($_SESSION['dep_codigo']))
				->setSelectName('usu_codigo_atendente')
				->setClass('usu_codigo_atendente')
				->setSelectedItem($atendente['usu_codigo_atendente'])
				->setOptionEmpty('Não hão atendentes')
				->listOption();

      ?>
	  </td>
    </tr>
    
    <tr>
    	<th>
    		Problema técnico:
    	</th>
    	<td>
    	<?php 
    	$tbProblema = new TbProblema();

		$SelectProblemaTecnico = new SelectOption();

		$SelectProblemaTecnico->setStmt($tbProblema->listarProblemasTecnicos($_SESSION['dep_codigo']))
						->setSelectName('pro_codigo_tecnico')
						->setSelectedItem($dados[4])
						->setOptionEmpty('Não há problema técnico indicado')
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
	  	$tbassentamento = new TbAssentamento();
	  	
	  	$grid = new DataGrid(array('Descrição','Data','Editor'),
							$tbassentamento->listarAssentamento($dados['0']));
	  	
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