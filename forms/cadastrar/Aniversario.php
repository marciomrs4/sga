<fieldset>
	<legend>Novo Aniversariante</legend>
<form name="Apontamento" id="Apontamento" enctype="multipart/form-data" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/Aniversario.php">
  <table width="300" border="0">
    <tr>
      <td colspan="4">	
      <?php Texto::mostrarMensagem($_SESSION['erro']);?>
    </td>
    </tr>

    <tr>
      <th nowrap="nowrap">DRT:</th>
      <td>
		<input type="text" name="ani_drt" class="drt" value="<?php echo($_SESSION['cadastrar/Aniversario']['ani_drt']); ?>" />
      </td>
    </tr>    
    
    <tr>
      <th nowrap="nowrap">Nome:</th>
      <td>
		<input type="text" name="ani_nome" value="<?php echo($_SESSION['cadastrar/Aniversario']['ani_nome']); ?>" />
      </td>
    </tr>

    <tr>
      <th nowrap="nowrap">Setor:</th>
      <td>
		<input type="text" name="ani_setor" value="<?php echo($_SESSION['cadastrar/Aniversario']['ani_setor']);?>" />		
      </td>
    </tr>    

    <tr>
      <th nowrap="nowrap">Data Nascimento:</th>
      <td>
		<input type="text" name="ani_data_nascimento" class="data" value="<?php echo($_SESSION['cadastrar/Aniversario']['ani_data_nascimento']); ?>" />
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
	  </td>
    </tr>
  </table>
</form>
</fieldset>
<?php 
unset($_SESSION['cadastrar/Aniversario']);?>