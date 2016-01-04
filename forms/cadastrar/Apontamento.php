<?php 

$tbAtividade = new TbAtividade();

$dados = $tbAtividade->getFormAlteracao(base64_decode($_SESSION['valorform']));


?>

<form name="Apontamento" id="Apontamento" enctype="multipart/form-data" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/apontamento.php">
<fieldset>
	<legend><b>Apontamento</b></legend>
  <table width="300" border="0">
    <tr>
      <td colspan="2">	
      <?php Texto::mostrarMensagem($_SESSION['erro']);?>
    </td>
    </tr>

    <tr>
      <th nowrap="nowrap">Número da Atividade:</th>
      <td>
      	    <?php echo($dados['at_titulo']); ?>
      </td>
    </tr>
    <tr>
      <th nowrap="nowrap">Descrição da Atividade:</th>
      <td>
      	<?php echo($dados['at_descricao']); ?>
      </td>
    </tr>    

    <tr>
      <th nowrap="nowrap">Descrição do Apontamento:</th>
      <td>
      <textarea name="ap_descricao" cols="55" rows="7"	><?php echo($_SESSION['cadastrar/Apontamento']['ap_descricao']); ?></textarea> 
      <input type="hidden" name="at_codigo" value="<?php echo($dados[0]); ?>">	
      </td>
    </tr>
    <tr>
      <th nowrap="nowrap">Status da Atividade:</th>
      <td>
      <?php 
      	$tbStatusAtividade = new TbStatusAtividade();
      	FormComponente::selectOption('sta_codigo',$tbStatusAtividade->listarStatusAtividadeApontamento(),false,$dados);
      ?>
	  </td>
    </tr>    

  <tr>
    <td>
     &nbsp;
    </td>
  </tr>

   <tr>
      <td colspan="2" align="left">
        <fieldset>
            <legend>Notificações</legend>
            <p>
              Usuários Informados: <input type="checkbox" name="informados" checked> |
              Usuários Consultados: <input type="checkbox" name="consultados" checked> |
              Participantes do projeto: <input type="checkbox" name="participantes" checked>
            </p>
        </fieldset>

	  </td>
    </tr>

  <tr>
    <td>
     &nbsp;
    </td>
  </tr>

    <tr>
      <td>
	      <input type="submit" name="alterar" class="button-tela" id="botaoSave" value="Salvar" />
   	      <span class="botaoSave" style="visibility: hidden"><img src="./css/images/299.GIF"></span>
      </td>
      <td>
        <a href="action/formcontroler.php?<?php echo base64_encode('alterar/Atividade'); ?>=<?php echo base64_encode($dados[0]); ?>">
            <span class="button-tela">Voltar</span>
        </a>
      </td>
    </tr>
  </table>
</form>
<hr>
  	<?php 
  	try
  	{
	  	$tbApontamento = new TbApontamento();
	  	$tabela = $tbApontamento->listarApontamento($dados[0]);
	
	  	$cabecalho = array('Descrição','Data',$_SESSION['config']['usuario']);
	  	
	  	$grid = new DataGrid($cabecalho, $tabela);
	  	
	  	$grid->titulofield = 'Apontamento(s)';
	  	$grid->islink = false;
	  	$grid->colunaoculta = 1;
	  	$grid->mostrarDatagrid(1);
	  	
  	}catch (Exception $e)
  	{
  		echo $e->getMessage();
  	}
  	?>
 </fieldset>
<?php 
unset($_SESSION['cadastrar/Apontamento']);?>