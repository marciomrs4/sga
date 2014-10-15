<?php 
if(!$_SESSION['ace_codigo'])
{
Texto::mostrarMensagem(Texto::erro($_SESSION['erro']));
?>
<form id="form1" name="form1" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/login.php">
  <table width="200" border="0">
    <tr>
      <td width="55" nowrap="nowrap">NOME:</td>
      <td width="129" nowrap="nowrap"><label for="textfield"></label>
      <input type="text" name="ace_usuario" id="textfield" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center" nowrap="nowrap"><label for="textfield2">
      </label></td>
    </tr>
    <tr>
      <td nowrap="nowrap">SENHA:</td>
      <td nowrap="nowrap"><input type="password" name="ace_senha" id="textfield2" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center" nowrap="nowrap"><input type="submit" name="button" id="button" value="ENTRAR" /></td>
    </tr>
  </table>
</form>
<?php 

}else
{
echo ('<fieldset>
		<legend>Logado como</legend> 
			<a href="../'.$_SESSION['projeto'].'/action/logout.php"><img src="/SGA/css/images/sair.png" /></a>
	   		<a href="CentralUsuario.php"><img src="/SGA/css/images/perfil.jpg" /></a><br />
	   	'.ucfirst($_SESSION['usu_nome']).'<br />
		IP: '.$_SERVER['REMOTE_ADDR'].'
	   </fieldset>');	
}
?>