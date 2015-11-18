<fieldset>
	<legend> Abrir Chamado </legend>
  <form name="solicitacao" id="solicitacao"  method="post" enctype="multipart/form-data" action="criararquivo.php">

      <tr>
          <th>Tipo de Documento</th>
          <td>
              <input type="text" name="documento" />
          </td>
      </tr>

    <tr>
    	<th>Anexo:</th>
    	<td>
    		<input type="file" name="arquivo" />
    	</td>
    </tr>
    
    <tr>
    	<td colspan="2">
    	&emsp;
    	</td>
    </tr>
    
    <tr>
    <td>
    </td>
      <td nowrap="nowrap">
	      <input type="submit" name="cadastrar" class="button-tela" id="botaoSave" value="Salvar" />
	      <span class="botaoSave" style="visibility: hidden"><img src="./css/images/299.GIF"></span>


</form>
		<hr>
      	
      	<form action="">
 	    	<input type="submit" name="alterar" class="button-tela" value=" Voltar " />
 	    </form>
	  </td>
  	</tr>

 </table>
</fieldset>