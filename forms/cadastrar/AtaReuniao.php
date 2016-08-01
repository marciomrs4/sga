<?php 
$tbProjeto = new TbProjeto();

$_SESSION['cadastrar/AtaReuniao'] = $tbProjeto->getProjetoToCadastroApontamento(base64_decode($_SESSION['valorform']));

?>

<form name="ApontamentoProjeto" id="ApontamentoProjeto" enctype="multipart/form-data" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/AtaReuniao.php">
<fieldset>
	<legend><b>Ata de reunião</b></legend>
  <table width="300" border="0">
    <tr>
      <td colspan="2">	
      <?php Texto::mostrarMensagem($_SESSION['erro']);?>
    </td>
    </tr>

    <tr>
      <th nowrap="nowrap">Titulo do Projeto:</th>
      <td>
      	    <?php echo $_SESSION['cadastrar/AtaReuniao']['pro_titulo']; ?>
      </td>
    </tr>

    <tr>
      <td colspan="2">
        &nbsp;
    </td>
    </tr>

     <tr>
      <th width="119" align="left" nowrap="nowrap">Assunto:</th>
      <td>
      	<input name="ata_assunto" type="text" size="40" maxlength="255" value="" />
      <input type="hidden" name="pro_codigo" value="<?php echo($_SESSION['cadastrar/AtaReuniao']['pro_codigo']); ?>">
      </td>
    </tr>

     <tr>
      <th width="119" align="left" nowrap="nowrap">Data:</th>
      <td>
      	<input name="ata_data" class="data" id="data-id" type="text" value="" />
      </td>
    </tr>

    <tr>
      <th width="119" align="left" nowrap="nowrap">Responsável:</th>
      <td>
      	<input name="ata_responsavel" type="text" size="40" maxlength="255" value="" />
      </td>
    </tr>

     <tr>
      <th width="119" align="left" nowrap="nowrap">Duração:</th>
      <td>
      	<input name="ata_duracao" type="text" class="hora" size="40" maxlength="255" value="" />
      </td>
    </tr>

     <tr>
      <th width="119" align="left" nowrap="nowrap">Emitida por:</th>
      <td>
      	<input name="ata_emissao" type="text" size="40" maxlength="255" value="" />
      </td>
    </tr>

    <tr>
      <th width="119" align="left" nowrap="nowrap">Local:</th>
      <td>
      	<input name="ata_local" type="text" size="40" maxlength="255" value="" />
      </td>
    </tr>

    <tr>
      <th width="119" align="left" nowrap="nowrap">Pauta:</th>
      <td>
      	<input name="ata_pauta" type="text" size="40" maxlength="255" value="" />
      </td>
    </tr>

    <tr>
      <th>Participantes: <span id="adcionarparticipante">Adicionar</span></th> </th>
      <td>
      	<textarea name="ata_participantes" cols="55" rows="7"></textarea>
      </td>
    </tr>

    <span id="inserirparticipante">

    </span>

    <tr>
      <th nowrap="nowrap">Resumo tratado:</th>
      <td>
        <textarea name="ata_resumo_tratado" cols="55" rows="7"></textarea>
      </td>
    </tr>

    <tr>
      <th nowrap="nowrap">Pendência para próxima reunião:
      <td>
          <textarea name="ata_acoes_pendencias" cols="55" rows="7"></textarea>
      </td>
    </tr>

    <tr>
      <td>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align="left">
	      <input type="submit" name="salvar" class="button-tela" value="Salvar" />
	  </td>
	  <td>
        <a href="action/formcontroler.php?<?php echo base64_encode('alterar/Projeto'); ?>=<?php echo base64_encode($_SESSION['cadastrar/AtaReuniao']['pro_codigo']); ?>">
            <span class="button-tela">Voltar</span>
        </a>
      </td>
    </tr>

  </table>
</form>
 </fieldset>
<?php 
unset($_SESSION['cadastrar/AtaReuniao']);?>