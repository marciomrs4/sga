<?php 
$tbUsuarioProjeto = new TbUsuarioProjeto();

$_SESSION['alterar/UsuarioProjeto'] = $tbUsuarioProjeto->getForm(base64_decode($_SESSION['valorform']));

?>
<table>
	<tr>
		<td>
			<fieldset>
				<legend>Alterar Usuario Projeto</legend>
<form name="UsuarioProjeto" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/UsuarioProjeto.php">
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="2" align="center">
      	<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
      </td>
    </tr>
    
    <tr>
      <th width="119" align="left" nowrap="nowrap">Usuário:</th>
      <td>
        <?php
        $tbUsuario = new TbUsuario();

        $SelectUsuarioProjeto = new SelectOption();

        $SelectUsuarioProjeto->setOptionEmpty('Selecione')
        ->setSelectedItem($_SESSION['alterar/UsuarioProjeto']['usu_codigo_integrante'])
        ->setSelectName('usu_codigo_integrante')
        ->setStmt($tbUsuario->selectUsuarios())
        ->listOption();

        ?>

        <input name="pro_codigo" type="hidden" value="<?php echo($_SESSION['alterar/UsuarioProjeto']['pro_codigo']); ?>" />
        <input name="usp_codigo" type="hidden" value="<?php echo($_SESSION['alterar/UsuarioProjeto']['usp_codigo']); ?>" />
      </td>

      <td colspan="2" align="right">
	      <input type="submit" name="alterar" id="button" value="Alterar" />


      <script language="JavaScript">
        function pergunta(){
          if(confirm('Tem certeza que deseja deletar este item?')){
            document.UsuarioProjeto.submit();
          }
        }
      </script>
      <input type="button" onclick="pergunta()" name="apagar" value="Remover" />

        <a href="./action/formcontroler.php?<?php echo(base64_encode('alterar/Projeto').'='.base64_encode($_SESSION['alterar/UsuarioProjeto']['pro_codigo']));?>">
          <img src="./css/images/voltar.png" title="Voltar para Projeto">
        </a>

      </td>
    </tr>
    
  </table>
</form>

</fieldset>
</td>
</tr>
</table>
<?php unset($_SESSION['alterar/UsuarioProjeto']); ?>