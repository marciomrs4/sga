<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

//resolve o problema de acentos
header('Content-Type: text/html; charset=ISO-8859-1');

 
/* $codigo = $_POST['sol_codigo'];

echo 'Aqui: ',$codigo;*/


$busca = new Busca();
$busca->validarPost($_POST);


try
{

$_SESSION['buscaRapida'] = $busca->buscaRapidaChamado();

?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Informações do Chamado</h3>
  </div>
  <div class="panel-body">

<form name="arquivo" method="post" enctype="multipart/form-data" action="../<?php echo($_SESSION['projeto']); ?>/action/solicitacao.php">

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
    		#Pega a data da solicita??o pelo STATUS informado, no caso 1 ? ABERTURA
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
		//FormComponente::selectOption('pro_codigo',$tbproblema->listarProblema($_SESSION['buscaRapida']['dep_codigo']),false,$_SESSION['buscaRapida']);
        FormComponente::selectOption('pro_codigo',$tbproblema->listarProblemasTecnicos($_SESSION['buscaRapida']['dep_codigo']),false,$_SESSION['buscaRapida']);
		?>
	  </td>
    </tr>
    <tr>
      <th align="left" nowrap="nowrap">Descrição do <?php echo($_SESSION['config']['problema']);?>:</th>
	      <td>
	      	<textarea name="sol_descricao_solicitacao" rows="10" cols="80"><?php echo($_SESSION['buscaRapida']['sol_descricao_solicitacao']); ?></textarea>
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

    </div>
</div>
  	<?php 
  	try
  	{
	  	$tbassentamento = new TbAssentamento();
	  	$tabela = $tbassentamento->listarAssentamento($_SESSION['buscaRapida']['sol_codigo']);
	  	
	  	$tabela = $tabela->fetchAll(PDO::FETCH_NUM);
	
	  	$cabecalho = array('Descrição','Data','Editor');
	  	
	  	$Grid = new Grid();
	  	$Grid->colunaoculta = 1;
	  	$Grid->colunaoculta = 1;
	  	$Grid->setCabecalho($cabecalho)
	  		 ->setDados($tabela);

        $PainelAssentamento = new Painel();
        $PainelAssentamento->setPainelTitle('Assentamento(s)')
                           ->addGrid($Grid)
                           ->show();

        $tbSolicitacaoTerceiro = new TbSolicitacaoTerceiro();

        $GridEnvios = new Grid();
        $GridEnvios->setCabecalho(array('#','Terceiro','Usuario','Data de Envio','Descricao'))
                   ->setDados($tbSolicitacaoTerceiro->listarEnvioTerceiro($_SESSION['buscaRapida']['sol_codigo'])->fetchAll(\PDO::FETCH_NUM));

        $PainelEnvios = new Painel();
        $PainelEnvios->setPainelTitle('Envio(s)')
            ->addGrid($GridEnvios)
            ->show();


        $GridRemocao = new Grid();
        $GridRemocao->setCabecalho(array('#','Terceiro','Usuario','Remocao','Descricao'))
            ->setDados($tbSolicitacaoTerceiro->listarRemocaoTerceiro($_SESSION['buscaRapida']['sol_codigo'])->fetchAll(\PDO::FETCH_NUM));

        $PainelRemocao = new Painel();
        $PainelRemocao->setPainelTitle('Remoção(ões)')
            ->addGrid($GridRemocao)
            ->show();
	  	
  	}catch (Exception $e)
  	{
  		echo $e->getMessage();
  	}
  	?>     
     </div>

  
</form>
<?php 


unset($_SESSION['buscaRapida']);
	

}catch (Exception $e)
{
	Texto::mostrarMensagem(Texto::letterRed($e->getMessage()));
}


?>