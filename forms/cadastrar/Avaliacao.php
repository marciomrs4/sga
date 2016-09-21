<?php
Sessao::validarForm('cadastrar/Avaliacao');
?>
	<table>
		<tr>
			<td>
				<fieldset>
					<legend>Avaliar</legend>
					<form name="arquivo" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/AvaliarChamado.php">
						<table border="0" cellspacing="5">
							<tr>
								<td colspan="2" align="center">
									<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
								</td>
							</tr>

							<tr>
								<th align="left" nowrap="nowrap">Avaliação do Chamado:
									<?php echo base64_decode($_SESSION['valorform']); ?>
								</th>
								<td>
									<?php

									$tbAvaliacao = new TbAvaliacao();
									FormComponente::selectOption('avaliacao_id',
										$tbAvaliacao->listAvaliacao(),
										true,
										$_SESSION['cadastrar/Avaliacao']);

									?>
								</td>
							</tr>

							<tr>
								<th width="119" align="left" nowrap="nowrap">Justificativa:</th>
								<td>
									<input type="hidden" name="sol_codigo" value="<?php echo base64_decode($_SESSION['valorform']); ?>">
									<textarea name="avaliacao_descricao" cols="50" rows="5"><?php echo $_SESSION['cadastrar/Avaliacao']['avaliacao_descricao']; ?></textarea>
								</td>
							</tr>

							<tr>
								<td colspan="2" nowrap="nowrap" align="right">
									<input type="submit" name="cadastrar" id="button" class="button-tela" value=" Salvar " />
								</td>

					</form>

					<td>
					<form action="">
						<input type="submit" name="alterar" class="button-tela" value=" Voltar " />
					</form>

						</td>
					</tr>

				</table>
				</fieldset>
			</td>
		</tr>
	</table>

<?php

include_once 'forms/SolicitacaoAvaliacao.php';

unset($_SESSION['cadastrar/Avaliacao']); ?>