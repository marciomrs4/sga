<?php 
Sessao::validarForm('cadastrar/usuario'); 
?>
<table>
	<tr>
		<td>
			<fieldset>
				<legend>Cadastrar Usuário</legend>
<form name="arquivo" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/usuario.php">
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="2" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
      </td>
    </tr>
    
    <tr>
      <th width="119" align="left" nowrap="nowrap">Nome:</th>
      <td>
      	<input name="usu_nome" type="text" value="<?php echo($_SESSION['cadastrar/usuario']['usu_nome']); ?>" />
      </td>
    </tr>
    
    <tr>
      <th align="left" nowrap="nowrap">Sobrenome:</th>
	      <td>
	      	<input name="usu_sobrenome" type="text" value="<?php echo($_SESSION['cadastrar/usuario']['usu_sobrenome']); ?>"/>
	      </td>
    </tr>
    
    <tr>
      <th align="left" nowrap="nowrap">E-mail:</th>
	      <td>
	      	<input name="usu_email" type="text" value="<?php echo($_SESSION['cadastrar/usuario']['usu_email']); ?>"/>
	      </td>
    </tr>
    
    <tr>
      <th align="left" nowrap="nowrap">Ramal:</th>
	      <td>
	      	<input name="usu_ramal" type="text" value="<?php echo($_SESSION['cadastrar/usuario']['usu_ramal']); ?>"/>
	      </td>
    </tr>
    
   <tr>
      <th align="left" nowrap="nowrap">Departamento:</th>
	      <td>
	      	<?php 
				$tbdepartamento = new TbDepartamento();
				FormComponente::selectOption('dep_codigo', $tbdepartamento->listarMeusDepartamentos($_SESSION['dep_codigo']),false,$_SESSION['cadastrar/usuario']);
				
				?>
	      </td>
    </tr>    
    
    <tr>
      <th align="left" nowrap="nowrap">Tipo de Acesso:</th>
	      <td>
				<?php 
				$tbtipoacesso = new TbTipoAcesso();
				FormComponente::$name = 'ESCOLHA';
				FormComponente::selectOption('tac_codigo', $tbtipoacesso->listarMeusAcessos(),true,$_SESSION['cadastrar/usuario']);
				
				?>
	      </td>
    </tr>    
    
   	<tr>
      <th align="left" nowrap="nowrap">Usuário:</th>
	      <td>
	      	<input name="ace_usuario" type="text" value="<?php echo($_SESSION['cadastrar/usuario']['ace_usuario']); ?>"/>
	      </td>
    </tr>
    
   	<tr>
      <th align="left" nowrap="nowrap">Senha:</th>
	      <td>
	      	<input name="ace_senha" type="password" value=""/>
	      </td>
    </tr>    
    
   	<tr>
      <th align="left" nowrap="nowrap">Repetir Senha:</th>
	      <td>
	      	<input name="ace_senha2" type="password" value=""/>
	      </td>
    </tr>    
    
    <tr>
      <td colspan="2" align="center">
	      <input type="submit" name="cadastrar" id="button" value="Cadastrar" />
      </td>
    </tr>
    
  </table>
</form>

</fieldset>
</td>
</tr>
</table>
<?php unset($_SESSION['cadastrar/usuario']);?>