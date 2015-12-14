<?php
$tbRnc = new TbCadastroRnc();
$tbUsuario = new TbUsuario();

$verRnc = $tbRnc->getFormRnc(base64_decode($_SESSION['valorform']));

$statusRnc = new TbStatusRnc();

$userDados = $tbUsuario->getUsuario($verRnc['usu_emitente_codigo']);
?>

<fieldset>
	<legend>Alterar RNC</legend>
	<form name="rnc" id="rnc" method="post" enctype="multipart/form-data" action="">
		<fieldset>
			<legend>Ações</legend>
			<div class="acoeschamado">

				<a href="./action/formcontroler.php?<?php echo(base64_encode('cadastrar/uploadfilesRNC').'='.base64_encode($verRnc['nc_codigo']));?>"><img src="./css/images/anexo.png" title="Anexar Arquivos"></a>

				<a href="./rncVerificacao.php?<?php echo(base64_encode('cadastrar/Ocorrencia').'='.base64_encode($verRnc['nc_codigo']));?>" target="_blank">
					<img src="./css/images/verificar.png" title="Fazer Verificacao">
				</a>
				<?php
				if($verRnc['nc_edicao_gestor'] == 1){
				?>
				<a href="./action/liberarGestor.php?<?php echo(base64_encode('alterar/RncGestor').'='.base64_encode($verRnc['nc_codigo']));?>">
					<img src="./css/images/ck.png" title="Liberar Edição do Gestor">
				</a>
				<?php
				}

				?>



			</div>
		</fieldset>

		<table border="0" cellspacing="5">
			<tr>
				<td colspan="2" align="center">
					<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
				</td>
			</tr>

			<tr>
				<th colspan="2" align="center">
					CRIAÇÃO DA RNC
				</th>
			</tr>

			<tr>
				<th nowrap="nowrap">
					RNC Número:
				</th>
				<td>
					<?php echo($tbRnc->getNumberRncFormatado($verRnc['nc_codigo'])); ?>
				</td>
			</tr>

			<tr>
				<th nowrap="nowrap">
					Emitente:
				</th>
				<td>
					<?php echo $userDados['usu_nome'] . ' ' . $userDados['usu_sobrenome']; ?>
				</td>
			</tr>

			<tr>
				<th nowrap="nowrap">
					Status da RNC:
				</th>
				<td>
					<?php echo $statusRnc->getStatusRnc($verRnc['snc_codigo']); ?>
				</td>
			</tr>
			<tr>
				<th>
					Local Ocorrência:
				</th>
				<td>
					<?php echo $verRnc['nc_local_ocorrencia']; ?>
				</td>
			</tr>
			<tr>
				<th>
					Data da Ocorrência:
				</th>
				<td>
					<?php echo ValidarDatas::dataCliente($verRnc['nc_data_ocorrencia']); ?>
				</td>
			</tr>
			<tr>
				<th>
					Ação Imediata:
				</th>
				<td>
					<?php echo $verRnc['nc_acao_imediata']; ?>
				</td>
			</tr>

			<tr>
				<th align="left" nowrap="nowrap">Descrição:</th>
				<td>
					<?php echo($verRnc['nc_descricaocompleta']); ?>
				</td>
			</tr>

			<tr>
				<td colspan="2" align="left">
					&nbsp;
				</td>
			</tr>

			<tr>
				<th colspan="2" align="center">
					RESPOSTA DO GESTOR
				</th>
			</tr>

			<tr>
				<th>
					Causas:
				</th>
				<td>
					<?php echo $verRnc['nc_causas']; ?>
				</td>
			</tr>

			<tr>
				<th>
					Ações de melhoria:
				</th>
				<td>
					<?php echo $verRnc['nc_acao_melhoria']; ?>
				</td>
			</tr>

			<tr>
				<th>
					Prazo de Implantação:
				</th>
				<td>
					<?php echo $verRnc['nc_prazo_implatacao']; ?>
				</td>
			</tr>

			<tr>
				<th>
					Responsável da Implantação:
				</th>
				<td>
					<?php echo $verRnc['nc_resp_implantacao']; ?>
				</td>
			</tr>

			<tr>
				<th>
					Respondido em:
				</th>
				<td>
					<?php echo ValidarDatas::dataCliente($verRnc['nc_data_resposta_gestor']); ?>
				</td>
			</tr>


			<tr>
				<td colspan="2" align="left">
					&nbsp;
				</td>
			</tr>

			<tr>
				<th colspan="2" align="center">
					MAIS INFORMACOES
				</th>
			</tr>

			<tr>
				<th>
					Permite Edição do Gestor:
				</th>
				<td>
					<?php if($verRnc['nc_edicao_gestor']){
						echo 'NÃO';
					}else{
						echo 'SIM';
					};
					?>
				</td>
			</tr>

			<tr>
				<td colspan="2" align="left">
					&nbsp;
				</td>
			</tr>

			<tr>
				<td colspan="2" align="left">

					<?php

					$tbRncVerificacao = new TbRncVerificacao();

					$GridVerificao  = new DataGrid(array('Eficaz','Data','Encerrado','Parecer'),$tbRncVerificacao->listarVerificaoByRnc($verRnc['nc_codigo']));
					$GridVerificao->titulofield = 'Lista de Verificações';
					$GridVerificao->colunaoculta = 1;
					$GridVerificao->islink = false;
					$GridVerificao->mostrarDatagrid(1);


					?>

				</td>
			</tr>

			<tr>
				<td colspan="2" align="left">
					<?php

					$tbOcorrenciaRnc = new TbOcorrenciaRnc();

					$GridVerificao  = new DataGrid(array('Chamado'),$tbOcorrenciaRnc->listarChamadoByRnc($verRnc['nc_codigo']));
					$GridVerificao->titulofield = 'Lista de Chamado(s)';
					$GridVerificao->islink = false;
					$GridVerificao->mostrarDatagrid(1);


					?>
				</td>
			</tr>
			<hr>
			<tr>
				<td colspan="2" align="left">
					&nbsp;
				</td>
			</tr>

			<tr>
				<td colspan="2">
					<input type="submit" name="cadastrar" class="button-tela" id="botaoSave" value="Voltar" />
				</td>
			</tr>
	</form>

	</td>
	</tr>

	</table>


</fieldset>