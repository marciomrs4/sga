<?php 
$tbassentamento = new TbAssentamento();

$_SESSION['assentamento'] = $tbassentamento->getForm(base64_decode($_SESSION['valorform']));

$tbsolicitacao = new TbSolicitacao();
$solicitacao = $tbsolicitacao->getFormAssentamento($_SESSION['assentamento']['sol_codigo']);

?>

<form name="assentamento" enctype="multipart/form-data" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/assentamento.php">
<fieldset>
	<legend><b>Assentamento</b></legend>
  <table width="300" border="0">
    <tr>
      <td colspan="2">	
      <?php Texto::mostrarMensagem($_SESSION['erro']);?>
    </td>
    </tr>

    <tr>
      <th nowrap="nowrap">Descrição do Chamado:</th>
      <td>
      	<?php echo($solicitacao[1]); ?>
      </td>
    </tr>    
    
    <tr>
      <th nowrap="nowrap">Assentamento:</th>
      <td>
      <textarea name="ass_descricao" cols="55" rows="7"	><?php echo($_SESSION['assentamento']['ass_descricao']); ?></textarea> 
      <input type="hidden" name="sol_codigo" value="<?php echo($_SESSION['assentamento']['sol_codigo']); ?>">	
      <input type="hidden" name="ass_codigo" value="<?php echo($_SESSION['assentamento']['ass_codigo']); ?>">	      
      </td>
    </tr>
    <tr>
      <td colspan="2" align="center">
	      <input type="submit" name="alterar" value=" Salvar " />
	  </td>
    </tr>
  </table>
</form>
<hr>
  	<?php 
  	try
  	{
	  	$tbassentamento = new TbAssentamento();
	  	$tabela = $tbassentamento->listarAssentamento($_SESSION['assentamento']['sol_codigo']);
	
	  	$cabecalho = array('Descrição','Data','Editor');
	  	
	  	$grid = new DataGrid($cabecalho, $tabela);
	  	
	  	$grid->titulofield = 'Assentameto(s)';
	  	$grid->acao = 'alterar/Assentamento';
	  	//$grid->islink = false;
	  	$grid->colunaoculta = 1;
	  	$grid->mostrarDatagrid();
	  	
  	}catch (Exception $e)
  	{
  		echo $e->getMessage();
  	}
  	?>
 </fieldset>
<?php 
unset($_SESSION['assentamento']);?>