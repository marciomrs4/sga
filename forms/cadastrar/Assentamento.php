<?php 
$tbsolicitacao = new TbSolicitacao();

$dados = $tbsolicitacao->getFormAssentamento(base64_decode($_SESSION['valorform']));

?>


<fieldset>
	<legend><b>Assentamento</b></legend>
  <form name="cadastrar/Assentamento" id="Assentamento" enctype="multipart/form-data" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/assentamento.php">
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
      	FormComponente::selectOption('sta_codigo', $tbstatus->selectStatusNaoAberto(),false,$dados[2]);
      ?>
	  </td>
    </tr>    
    <tr>
      <th nowrap="nowrap">Atendente do Chamado:</th>
      <td>
      <?php 
      	$tbatendente = new TbAtendenteSolicitacao();
      	$atendente = $tbatendente->getNomeAtendente($dados[0]);
    
      	$tbusuario = new TbUsuario();
      		#Verifica se há um atendente e não houver, é mostrado o $name
      		#Caso contrario lista os nomes sem o $name
     	  	if($atendente)
   			{$valor = false;}
   			else
   			{FormComponente::$name = 'Não há atendentes';
   			$valor = true;}
      	FormComponente::selectOption('usu_codigo_atendente',$tbusuario->selectUsuarioDepCompleto($_SESSION['dep_codigo']),$valor,$atendente);
      
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
     	if($dados[4])
    	{$valor = false;}
    	else
    	{FormComponente::$name = 'Não há problema técnico indicado';
    	$valor = true;} 
    	FormComponente::selectOption('pro_codigo_tecnico', $tbProblema->listarProblemasTecnicos($_SESSION['dep_codigo']),true,$dados);
    	
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