<?php 
Sessao::validarForm('cadastrar/departamento'); 
?>
<form name="arquivo" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/departamento.php">
<fieldset>
				<legend>Novo Departamento</legend>

  <table border="0" cellspacing="5">
    <tr>
      <td colspan="2" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
      </td>
    </tr>
    
    <tr>
      <th width="119" align="left" nowrap="nowrap">Departamento:</th>
      <td>
      	<input name="dep_descricao" type="text" value="<?php echo($_SESSION['cadastrar/departamento']['dep_descricao']); ?>" />
      </td>
    </tr>
    <tr>
      <th align="left" nowrap="nowrap">Permite Listar no Chamado:</th>
	      <td>
	      	<?php 
			$tbSN = new TbSimNao();
	      	FormComponente::selectOption('pro_permite_listar_chamado',$tbSN->selectSimNao(),false,$_SESSION['cadastrar/departamento']);	      	
	      	?>
	      </td>
    </tr>
    
    <tr>
      <th align="left" nowrap="nowrap">E-mail:</th>
	      <td>
	      	<input name="dep_email" type="text" value="<?php echo($_SESSION['cadastrar/departamento']['dep_email']); ?>"/>
	      </td>
    </tr>

    <tr>
      <td colspan="2" align="left">
	      <input type="submit" name="cadastrar" class="button-tela" value="Cadastrar" />

</form>
<form action="" method="post">
 <input type="submit" name="alterar" class="button-tela" value="Cancelar" />
</form>
      </td>
    </tr>
  </table>
</fieldset>


<?php unset($_SESSION['cadastrar/departamento']);?>