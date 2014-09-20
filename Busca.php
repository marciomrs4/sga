<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');

$ControleAcesso = new ControleDeAcesso();
$ControleAcesso->permitirAcesso(array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico,ControleDeAcesso::$Solicitante));

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");

$busca = new Busca();

$busca->validarPost($_POST);

echo"<div class='sub_menu_principal'>";
echo FormComponente::actionButton('<img src="./css/images/addchamado.png" title="Novo Chamado"  >','cadastrar/Solicitacao');
Texto::criarTitulo("Busca Rápida");
echo "</div>";


try
{

?>
<form action="" method="post">
<fieldset>
	<legend>Pesquisar Chamado</legend>
<table border="0">
	<tr>
	</tr>
	<tr>
		<td>
			Número do Chamado:
				<input type="text" name="sol_codigo" value="<?php echo($busca->getDados('sol_codigo')); ?>">
		</td>
		<td>
			<input type="submit" value="Pesquisar" />
		</td>
	</tr>
</table>
</fieldset>
</form>
<br />

<?php


#Carrega dinamicamente os formularios	
Arquivo::includeForm();


$_SESSION['buscaRapida'] = $busca->buscaRapidaChamado();



//$_SESSION['acaoform'] = base64_encode('alterar/Solicitacao');

?>
<form name="arquivo" method="post" enctype="multipart/form-data" action="../<?php echo($_SESSION['projeto']); ?>/action/solicitacao.php">
	<fieldset>
				<legend>Chamado</legend>
			<fieldset>
				<legend>Ações</legend>
				<div class="acoeschamado">
				<?php 
				if($_SESSION['buscaRapida']['usu_codigo'])
				{}elseif($_SESSION['tac_codigo'] != ControleDeAcesso::$Solicitante){
				?>
				<a href="./action/atenderchamado.php?<?php echo(base64_encode('atender/chamado').'='.base64_encode($_SESSION['buscaRapida']['sol_codigo']));?>"><img src="./css/images/atender.png" title="Atender"></a>
				
				<?php
				 }
				?>
				
				<?php 
				if($_SESSION['tac_codigo'] == ControleDeAcesso::$Solicitante)
				{ ?>
				<a href="./action/formcontroler.php?<?php echo(base64_encode('cadastrar/AssentamentoSolicitante').'='.base64_encode($_SESSION['buscaRapida']['sol_codigo']));?>"><img src="./css/images/novo.png" title="Assentamento"></a>
				<?php
				} 
				else{
				?>
				<a href="./action/formcontroler.php?<?php echo(base64_encode('cadastrar/Assentamento').'='.base64_encode($_SESSION['buscaRapida']['sol_codigo']));?>"><img src="./css/images/novo.png" title="Assentamento"></a>
				<?php }?>
				<a href="./GerarRelatorioPdf.php?<?php echo(base64_encode('codigo').'='.base64_encode($_SESSION['buscaRapida']['sol_codigo']));?>" target="blank"><img src="./css/images/pdf.png" title="Gerar PDF"></a>
			</div>
			</fieldset>
				<hr/>
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="2" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['mensagem'],$_SESSION['erro']); ?>
      </td>
    </tr>
    	<tr>
	    	<th nowrap="nowrap">
	    		Número do Chamado:
	    	</th>
    		<td>
	    		<?php echo($_SESSION['buscaRapida']['sol_codigo']); ?>
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
	    		$Usuario = $tbusuario->getUsuario($_SESSION['buscaRapida']['usu_codigo_solicitante']); 
	    		
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
	    			echo $tbstatuschamado->getDescricao($_SESSION['buscaRapida']['sta_codigo']);
	    			?>
	    		</td>
    		</tr>
	    	<tr>
	    		<th>
	    			Prioridade:
	    		</th>
	    		<td>
	    			<?php 
	    			$tbsolicitacao = new TbSolicitacao();
	    			$solicitacao = $tbsolicitacao->getPrioridadeTempoAtendimento($_SESSION['buscaRapida']['sol_codigo']);
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
					if($_SESSION['buscaRapida']['usu_codigo'])
					{
					$tbusuario = new TbUsuario();
					$Atendente = $tbusuario->getUsuario($_SESSION['buscaRapida']['usu_codigo']);
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
    		echo $tbcalcatendimento->getDataPorStatus($_SESSION['buscaRapida']['sol_codigo'],1);
			?>
    		</td>
    	</tr>    	
    <tr>
      <th width="119" align="left" nowrap="nowrap">Departamento:</th>
      <td>
      	<input type="hidden" name="sol_codigo" value="<?php echo($_SESSION['buscaRapida']['sol_codigo']); ?>">
		<?php 
		$tbdepartamento = new TbDepartamento();
		FormComponente::$name = 'Selecione';
		FormComponente::selectOption('dep_codigo',$tbdepartamento->listarDepartamentos(),true,$_SESSION['buscaRapida']);
		?>
      </td>
    </tr>
    <tr>
      <th align="left" nowrap="nowrap"><?php echo($_SESSION['config']['problema']);?>:</th>
	  <td>
		<?php 
		$tbproblema = new TbProblema();
		FormComponente::selectOption('pro_codigo',$tbproblema->listarProblema($_SESSION['buscaRapida']['dep_codigo']),false,$_SESSION['buscaRapida']);
		?>
	  </td>
    </tr>
    <tr>
      <th align="left" nowrap="nowrap">Descrição do <?php echo($_SESSION['config']['problema']);?>:</th>
	      <td>
	      	<textarea name="sol_descricao_solicitacao" rows="10" cols="50"><?php echo($_SESSION['buscaRapida']['sol_descricao_solicitacao']); ?></textarea>
	      </td>
    </tr>
		<?php
		$tbanexo = new TbAnexo();
		$dados = $tbanexo->getForm($_SESSION['buscaRapida']['sol_codigo']);
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
    	<th><?php if(!$_SESSION['buscaRapida']['usu_codigo']){ echo('Alterar Anexo:'); ?></th>     		
    	<td><input type="file" name="arquivo" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
	     	<input type="submit" name="cadastrar" class="button-tela" value="Salvar" />
	      <?php }?>
      </td>
    </tr>

  </table>
       <div id="insere_aqui">
  	<?php 
  	try
  	{
	  	$tbassentamento = new TbAssentamento();
	  	$tabela = $tbassentamento->listarAssentamento($_SESSION['buscaRapida']['sol_codigo']);
	
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
  
</form>
<?php 

unset($_SESSION['buscaRapida']);
	

}catch (Exception $e)
{
	Texto::mostrarMensagem(Texto::letterRed($e->getMessage()));
}

Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menusecundario.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");

?>