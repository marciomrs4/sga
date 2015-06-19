<?php 

$tbAtividade = new TbAtividade();

$dados = $tbAtividade->getFormAlteracao(base64_decode($_SESSION['valorform']));


?>

<form name="Apontamento" id="Apontamento" enctype="multipart/form-data" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/apontamento.php">
<fieldset>
	<legend><b>Apontamento</b></legend>
  <table width="300" border="0">
    <tr>
      <td colspan="2">	
      <?php Texto::mostrarMensagem($_SESSION['erro']);?>
    </td>
    </tr>

    <tr>
      <th nowrap="nowrap">Descri��o da Atividade:</th>
      <td>
      	<?php echo($dados['at_descricao']); ?>
      </td>
    </tr>    
    
    <tr>
      <th nowrap="nowrap">Descri��o do Apontamento:</th>
      <td>
      <textarea name="ap_descricao" cols="55" rows="7"	><?php echo($_SESSION['cadastrar/Apontamento']['ap_descricao']); ?></textarea> 
      <input type="hidden" name="at_codigo" value="<?php echo($dados[0]); ?>">	
      </td>
    </tr>
    <tr>
      <th nowrap="nowrap">Status da Atividade:</th>
      <td>
      <?php 
      	$tbStatusAtividade = new TbStatusAtividade();
      	FormComponente::selectOption('sta_codigo',$tbStatusAtividade->listarStatusAtividadeApontamento(),false,$dados);
      ?>
	  </td>
    </tr>    

    <tr>
      <td colspan="2" align="left">
	      <input type="submit" name="alterar" class="button-tela" value="Salvar" />
	  </td>
    </tr>
  </table>
</form>
<hr>
  	<?php 
  	try
  	{
	  	$tbApontamento = new TbApontamento();
	  	$tabela = $tbApontamento->listarApontamento($dados[0]);
	
	  	$cabecalho = array('Descri��o','Data',$_SESSION['config']['usuario']);
	  	
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
<?php 
unset($_SESSION['cadastrar/Apontamento']);?>