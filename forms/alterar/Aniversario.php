<?php 
$tbAniversariante = new TbAniversariante();

$_SESSION['alterar/Aniversario'] = $tbAniversariante->getForm(base64_decode($_SESSION['valorform']));


?>

<fieldset>
	<legend>Novo Aniversariante</legend>
<form name="Aniversariante" id="Aniversariante" enctype="multipart/form-data" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/Aniversario.php">
  <table width="300" border="0">
    <tr>
      <td colspan="4">	
      <?php Texto::mostrarMensagem($_SESSION['erro']);?>
    </td>
    </tr>

    <tr>
      <th nowrap="nowrap">DRT:</th>
      <td>
		<input type="text" name="ani_drt" class="drt" value="<?php echo($_SESSION['alterar/Aniversario']['ani_drt']); ?>" />
		<input type="hidden" name="ani_codigo" value="<?php echo($_SESSION['alterar/Aniversario']['ani_codigo']); ?>" />		
      </td>
    </tr>    
    
    <tr>
      <th nowrap="nowrap">Nome:</th>
      <td>
		<input type="text" name="ani_nome" size="<?php echo(strlen($_SESSION['alterar/Aniversario']['ani_nome'])+5); ?>" value="<?php echo($_SESSION['alterar/Aniversario']['ani_nome']); ?>" />
      </td>
    </tr>

    <tr>
      <th nowrap="nowrap">Setor:</th>
      <td>
		<input type="text" name="ani_setor" size="<?php echo(strlen($_SESSION['alterar/Aniversario']['ani_setor'])+5);?>" value="<?php echo($_SESSION['alterar/Aniversario']['ani_setor']);?>" />		
      </td>
    </tr>    

    <tr>
      <th nowrap="nowrap">Data Nascimento:</th>
      <td>
		<input type="text" name="ani_data_nascimento" class="data" value="<?php echo(ValidarDatas::dataCliente($_SESSION['alterar/Aniversario']['ani_data_nascimento'],'/')); ?>" />
      </td>
    </tr>    

    <tr>
      <th nowrap="nowrap">Unidade:</th>
      <td>
		<?php FormComponente::selectOption('ani_unidade',TbConfigAniversario::listarUnidade(),false,$_POST)?>
      </td>
    </tr>    

    <tr>
      <td colspan="2" align="left">
	      <input type="submit" name="alterar" class="button-tela" value="Salvar" />
	      <script language="JavaScript"> 
					function pergunta(){ 
   						if(confirm('Tem certeza que deseja deletar este item?')){ 
      					document.Aniversariante.submit(); 
   					} 
				} 
		</script> 
	      <input type="button" class="button-tela" onclick="pergunta()" name="apagar" value="Apagar" />	      
	  </td>
    </tr>
  </table>
</form>
</fieldset>
<?php 
unset($_SESSION['alterar/Aniversario']);?>