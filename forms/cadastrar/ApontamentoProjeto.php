<?php 

$tbProjeto = new TbProjeto();

$_SESSION['cadastrar/ApontamentoProjeto'] = $tbProjeto->getProjetoToCadastroApontamento(base64_decode($_SESSION['valorform']));

?>

<form name="ApontamentoProjeto" id="ApontamentoProjeto" enctype="multipart/form-data" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/ApontamentoProjeto.php">
<fieldset>
	<legend><b>Criar Apontamento do Projeto</b></legend>
  <table width="300" border="0">
    <tr>
      <td colspan="2">	
      <?php Texto::mostrarMensagem($_SESSION['erro']);?>
    </td>
    </tr>

    <tr>
      <th nowrap="nowrap">Titulo do Projeto:</th>
      <td>
      	    <?php echo $_SESSION['cadastrar/ApontamentoProjeto']['pro_titulo']; ?>
      </td>
    </tr>

    <tr>
      <td colspan="2">
        &nbsp;
    </td>
    </tr>

    <tr>
      <th nowrap="nowrap">Descrição do Apontamento:</th>
      <td>
      <textarea name="ap_descricao" cols="55" rows="7"	><?php echo($_SESSION['cadastrar/ApontamentoProjeto']['ap_descricao']); ?></textarea>
      <input type="hidden" name="pro_codigo" value="<?php echo($_SESSION['cadastrar/ApontamentoProjeto']['pro_codigo']); ?>">
      </td>
    </tr>
    <tr>
      <th nowrap="nowrap">Status do Projeto:</th>
      <td>
      <?php 
          $tbStatusProjeto = new TbStatusProjeto();

        $SelectStatusProjeto = new SelectOption();
        $SelectStatusProjeto
                  ->setSelectedItem($_SESSION['cadastrar/ApontamentoProjeto']['stp_codigo'])
                  ->setSelectName('stp_codigo')
                  ->setStmt($tbStatusProjeto->selectStatusToApontamento())
                  ->listOption();

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
	  	$tbApontamentoProjeto = new TbApontamentoProjeto();

	  	$grid = new DataGrid(array('Descrição','Data',$_SESSION['config']['usuario']),
	  	                     $tbApontamentoProjeto->listarApontamento($_SESSION['cadastrar/ApontamentoProjeto']['pro_codigo']));
	  	
	  	$grid->titulofield = 'Apontamento(s)';
	  	$grid->islink = false;
	  	$grid->mostrarDatagrid(1);
	  	
  	}catch (Exception $e)
  	{
  		echo $e->getMessage();
  	}
  	?>
 </fieldset>
<?php 
unset($_SESSION['cadastrar/ApontamentoProjeto']);?>