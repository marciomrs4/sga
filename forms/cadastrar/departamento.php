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
      <th align="left" nowrap="nowrap">Hora de Inicio:</th>
	      <td>
	      	<input name="dep_hora_inicio" class="doisdigitos" size="2" type="text" value="<?php echo($_SESSION['cadastrar/departamento']['dep_hora_inicio']); ?>"/>
	      </td>
    </tr>

    <tr>
      <th align="left" nowrap="nowrap">Hora Fim:</th>
	      <td>
	      	<input name="dep_hora_fim" class="doisdigitos" size="2" type="text" value="<?php echo($_SESSION['cadastrar/departamento']['dep_hora_fim']); ?>"/>
	      </td>
    </tr>

    <tr>
      <th align="left" nowrap="nowrap">Hora de Almoço:</th>
	      <td>
	      	<input name="dep_hora_almoco" class="doisdigitos" size="2" type="text" value="<?php echo($_SESSION['cadastrar/departamento']['dep_hora_almoco']); ?>"/>
	      </td>
    </tr>

    <tr>
      <th align="left" nowrap="nowrap">Carga Horaria de Sábado:</th>
	      <td>
	      	<input name="dep_carga_sabado" class="doisdigitos" size="2" type="text" value="<?php echo($_SESSION['cadastrar/departamento']['dep_carga_sabado']); ?>"/>
	      </td>
    </tr>

    <tr>
        <td>
            &nbsp;
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