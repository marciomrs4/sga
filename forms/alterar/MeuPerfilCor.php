<?php 
$tblayout = new TbLayout();

$_SESSION['alterar/MeuPerfilCor'] = $tblayout->selecLayoutUsuario($_SESSION['usu_codigo']); 

/* 

lay_codigo

lay_fundo_tela
lay_menu_principal
lay_botoes_menu
lay_botoes_tela

lay_tabela
lay_tabela_linha_par
lay_tabela_linha_impar
lay_passar_mouse_botao
lay_passar_mouse_tabela

 */
?>
<table>
	<tr>
		<td>
			<fieldset>
				<legend>Meu Layout</legend>
<form name="arquivo" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/usuario.php">
  <table border="0" cellspacing="5">
    <tr>
      <td colspan="2" align="center"><?php Texto::mostrarMensagem($_SESSION['erro']); ?>
      </td>
    </tr>
    <tr>
      <th width="119" align="left" nowrap="nowrap">Fundo da Tela:</th>
      <td>
      	<input type="hidden" name="lay_codigo" value="<?php echo($_SESSION['alterar/MeuPerfilCor']['lay_codigo']); ?>" />
      	<input name="lay_fundo_tela"  id="colorpickerField1" class="layout" type="text" readonly="readonly" value="<?php echo($_SESSION['alterar/MeuPerfilCor']['lay_fundo_tela']); ?>" />
      </td>
    </tr>
    <tr>
      <th align="left" nowrap="nowrap">Menu Principal:</th>
	      <td>
	      	<input name="lay_menu_principal" id="colorpickerField2" class="layout" type="text" readonly="readonly" value="<?php echo($_SESSION['alterar/MeuPerfilCor']['lay_menu_principal']); ?>" />
	      </td>
    </tr>
    <tr>
      <th align="left" nowrap="nowrap">Botões do Menu:</th>
	      <td>
	      	<input name="lay_botoes_menu" id="colorpickerField3" class="layout" type="text" value="<?php echo($_SESSION['alterar/MeuPerfilCor']['lay_botoes_menu']); ?>" />
	      </td>
    </tr>    
    <tr>
      <th align="left" nowrap="nowrap">Botões da Tela:</th>
	      <td>
	      	<input name="lay_botoes_tela" id="colorpickerField4" class="layout" type="text" value="<?php echo($_SESSION['alterar/MeuPerfilCor']['lay_botoes_tela']); ?>" />
	      </td>
    </tr>    
    <tr>
      <td colspan="2" align="center">
	      <input type="submit" name="default" id="button" value="Padrão" />

	      <input type="submit" name="cadastrar" id="button" value="Alterar" />
	</td>
</tr>
</table>
</form>
</fieldset>
</td>
</tr>
</table>
<?php unset($_SESSION['alterar/MeuPerfilCor']);?>