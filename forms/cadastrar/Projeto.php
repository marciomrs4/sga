<?php
Sessao::validarForm('cadastrar/Projeto');
?>
<table>
<tr>
	<td>
		<fieldset>
			<legend>Novo Projeto</legend>
			<form name="projeto" id="projeto"  method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/projeto.php">
				<table border="0" cellspacing="5">
					<tr>
						<td colspan="2" align="center">
							<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
						</td>
					</tr>

					<tr>
						<th width="119" align="left" nowrap="nowrap">Código:</th>
						<th>
							<?php $tbprojeto = new TbProjeto();
							echo $tbprojeto->codigoProjeto();
							?>
						</th>
					</tr>

					<tr>
						<th width="119" align="left" nowrap="nowrap">Titulo:</th>
						<td>
							<input name="pro_titulo" type="text" size="40" maxlength="255" value="<?php echo($_SESSION['cadastrar/Projeto']['pro_titulo']); ?>" />
						</td>
					</tr>

					<tr>
						<th nowrap="nowrap"><?php echo($_SESSION['config']['usuario']);?> Solicitante:</th>
						<td>
							<?php
							$tbUsuario = new TbUsuario();
							$SelectSolicitante = new SelectOption();

							$SelectSolicitante->setOptionEmpty('Selecione')
										      ->setSelectedItem($_SESSION['cadastrar/Projeto']['usu_codigo_solicitante'])
											  ->setSelectName('usu_codigo_solicitante')
											  ->setStmt($tbUsuario->selectUsuarios())
										      ->listOption();

							?>
						</td>
					</tr>

					<tr>
						<th nowrap="nowrap"><?php echo($_SESSION['config']['usuario']);?> Responsável:</th>
						<td>
							<?php
							$tbUsuario = new TbUsuario();

							$SelectResponsavel = new SelectOption();

							$SelectResponsavel->setOptionEmpty('Selecione')
												->setSelectedItem($_SESSION['cadastrar/Projeto']['usu_codigo_responsavel'])
												->setSelectName('usu_codigo_responsavel')
												->setStmt($tbUsuario->selectUsuarioDepCompleto($_SESSION['dep_codigo']))
												->listOption();


							?>
						</td>
					</tr>

					<tr>
						<th width="119" align="left" nowrap="nowrap">Previsão Inicio:</th>
						<td>
							<input type="text" id="data-id" class="data" name="pro_previsao_inicio" value="<?php echo($_SESSION['cadastrar/Projeto']['pro_previsao_inicio']); ?>"  />
						</td>
					</tr>

					<tr>
						<th width="119" align="left" nowrap="nowrap">Previsão Fim:</th>
						<td>
							<input type="text" id="data" class="data" name="pro_previsao_fim" value="<?php echo($_SESSION['cadastrar/Projeto']['pro_previsao_fim']); ?>"  />
						</td>
					</tr>


					<tr>
						<th width="119" align="left" nowrap="nowrap">Descrição do Projeto:</th>
						<td>
							<textarea name="pro_descricao" rows="7" cols="80"><?php echo($_SESSION['cadastrar/Projeto']['pro_descricao']); ?></textarea>
						</td>
					</tr>

					<tr>
						<th width="119" align="left" nowrap="nowrap">Observação:</th>
						<td>
							<textarea name="pro_observacao" rows="5" cols="80"><?php echo($_SESSION['cadastrar/Projeto']['pro_observacao']); ?></textarea>
						</td>
					</tr>

					<tr>
						<th width="119" align="left" nowrap="nowrap">Armazenamento Físico:</th>
						<td>
							<input name="pro_local_armazenado" type="text" size="40" maxlength="255" value="<?php echo($_SESSION['cadastrar/Projeto']['pro_local_armazenado']); ?>" />
						</td>
					</tr>

					<tr>
						<td colspan="2" align="left">
							<input type="submit" name="cadastrar" class="button-tela" id="botaoSave" value="Salvar" />
							<span class="botaoSave" style="visibility: hidden"><img src="./css/images/299.GIF"></span>
						</td>
					</tr>

				</table>
			</form>

		</fieldset>
	</td>
</tr>
</table>
<?php unset($_SESSION['cadastrar/Projeto']);?>