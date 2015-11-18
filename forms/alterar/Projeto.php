<?php
Sessao::validarForm('alterar/Projeto');

$tbprojeto = new TbProjeto();
$_SESSION['alterar/Projeto'] = $tbprojeto->getFormAlteracao(base64_decode($_SESSION['valorform']));

?>
	<table>
		<tr>
			<td>
				<fieldset>
					<legend>Alterar Projeto</legend>
					<form name="arquivo" id="projeto" method="post" action="../<?php echo($_SESSION['projeto']); ?>/action/projeto.php">

						<fieldset>
							<legend>Ações</legend>
							<div class="acoeschamado">
								<a href="./GerarRelatorioProjetoPdf.php?<?php echo(base64_encode('codigo').'='.base64_encode($_SESSION['alterar/Projeto']['pro_codigo']));?>" target="blank"><img src="./css/images/pdf.png" title="Gerar PDF"></a>
								<a href="./action/formcontroler.php?<?php echo(base64_encode('cadastrar/UsuarioProjeto').'='.base64_encode($_SESSION['alterar/Projeto']['pro_codigo']));?>">
									<img src="./css/images/new_usuario.png" title="Adcionar Usuário participante">
								</a>
								<a href="./action/formcontroler.php?<?php echo(base64_encode('cadastrar/FaseProjeto').'='.base64_encode($_SESSION['alterar/Projeto']['pro_codigo']));?>"><img src="./css/images/addfases.png" title="Adcionar fase"></a>
								<a href="./action/formcontroler.php?<?php echo(base64_encode('cadastrar/ApontamentoProjeto').'='.base64_encode($_SESSION['alterar/Projeto']['pro_codigo']));?>"><img src="./css/images/novo.png" title="Adcionar Apontamento"></a>
								<a href="./action/formcontroler.php?<?php echo(base64_encode('cadastrar/AtaReuniao').'='.base64_encode($_SESSION['alterar/Projeto']['pro_codigo']));?>"><img src="./css/images/new_ocorrencia.png" title="Criar Ata de reunião"></a>
								<a href="./action/formcontroler.php?<?php echo(base64_encode('cadastrar/uploadfilesprojeto').'='.base64_encode($_SESSION['alterar/Projeto']['pro_codigo']));?>"><img src="./css/images/anexo.png" title="Anexar Arquivos"></a>
							</div>
						</fieldset>
						<hr/>

						<table border="0" cellspacing="5">

							<tr>
								<td colspan="2" align="center">
									<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
								</td>
							</tr>

							<tr>
								<th width="119" align="left" nowrap="nowrap">Código:</th>
								<th>
									<?php
									echo $_SESSION['alterar/Projeto']['pro_cod_projeto'];
									?>
								</th>
							</tr>

							<tr>
								<th>
									<input name="pro_codigo" type="hidden" value="<?php echo($_SESSION['alterar/Projeto']['pro_codigo']);?>" />
									<input name="stp_codigo" type="hidden" value="<?php echo($_SESSION['alterar/Projeto']['stp_codigo']);?>" />
								</th>
							</tr>

							<tr>
								<th width="119" align="left" nowrap="nowrap">Titulo:</th>
								<td>
									<input name="pro_titulo" type="text" size="40" maxlength="255" value="<?php echo($_SESSION['alterar/Projeto']['pro_titulo']); ?>" />
								</td>
							</tr>

							<tr>
								<th nowrap="nowrap"><?php echo($_SESSION['config']['usuario']);?> Solicitante:</th>
								<td>
									<?php
									/*		$tbUsuario = new TbUsuario();
                                            FormComponente::selectOption('usu_codigo_solicitante', $tbUsuario->selectUsuarios(),false,$_SESSION['alterar/Projeto']);*/

									$tbUsuario = new TbUsuario();
									$SelectSolicitante = new SelectOption();

									$SelectSolicitante->setOptionEmpty('Selecione')
										->setSelectedItem($_SESSION['alterar/Projeto']['usu_codigo_solicitante'])
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

									$SelectResponsavel->setSelectedItem($_SESSION['alterar/Projeto']['usu_codigo_responsavel'])
										->setSelectName('usu_codigo_responsavel')
										->setStmt($tbUsuario->selectUsuarioDepCompleto($_SESSION['dep_codigo']))
										->listOption();


									?>
								</td>
							</tr>

							<tr>
								<th width="119" align="left" nowrap="nowrap">Previsão Inicio:</th>
								<td>
									<input type="text" id="data-id" class="data" name="pro_previsao_inicio" value="<?php echo(ValidarDatas::dataCliente($_SESSION['alterar/Projeto']['pro_previsao_inicio'])); ?>"  />
								</td>
							</tr>

							<tr>
								<th width="119" align="left" nowrap="nowrap">Previsão Fim:</th>
								<td>
									<input type="text" id="data" class="data" name="pro_previsao_fim" value="<?php echo(ValidarDatas::dataCliente($_SESSION['alterar/Projeto']['pro_previsao_fim'])); ?>"  />
								</td>
							</tr>

							<tr>
								<th width="119" align="left" nowrap="nowrap">Quantidade de Dias:</th>
								<td>
									<input type="text" id="data" value="<?php
									$inicio = new DateTime($_SESSION['alterar/Projeto']['pro_previsao_inicio']);
									$fim = new DateTime($_SESSION['alterar/Projeto']['pro_previsao_fim']);

									echo $inicio->diff($fim)->days;
									?>"  />
								</td>
							</tr>


							<tr>
								<th nowrap="nowrap">Status do Projeto:</th>
								<td>
									<?php

									$tbStatusProjeto = new TbStatusProjeto();

									$StatusProjeto = $tbStatusProjeto->getDescricaoStatus($_SESSION['alterar/Projeto']['stp_codigo']);

									echo $StatusProjeto['stp_descricao'];

									?>
								</td>
							</tr>


							<tr>
								<th width="119" align="left" nowrap="nowrap">Descrição do Projeto:</th>
								<td>
									<textarea name="pro_descricao" rows="7" cols="80"><?php echo($_SESSION['alterar/Projeto']['pro_descricao']); ?></textarea>
								</td>
							</tr>

							<tr>
								<th width="119" align="left" nowrap="nowrap">Observação:</th>
								<td>
									<textarea name="pro_observacao" rows="5" cols="80"><?php echo($_SESSION['alterar/Projeto']['pro_observacao']); ?></textarea>
								</td>
							</tr>

							<tr>
								<th width="119" align="left" nowrap="nowrap">Armazenamento Físico:</th>
								<td>
									<input name="pro_local_armazenado" type="text" size="40" maxlength="255" value="<?php echo($_SESSION['alterar/Projeto']['pro_local_armazenado']); ?>" />
								</td>
							</tr>

							<tr>
								<td colspan="2" align="left">
									<input type="submit" name="cadastrar" class="button-tela" value="Salvar" />
								</td>
							</tr>

						</table>
					</form>
					<hr>
	<span id="mostrarpauta">
		<img src="css/images/entrada.png"> Lista de Ata de Reunião
	</span>

					<div id="pautadereuniao" style="display: none">
						<table class="tabela">
							<tr class="linha3">
								<td>#</td>
								<td>Pauta</td>
								<td>Usuário</td>
								<td>Data Criacao</td>
							</tr>

							<?php

							$tbAtaReuniao = new TbAtaReuniao();

							$x = 1;

							foreach($tbAtaReuniao->listarPauta($_SESSION['alterar/Projeto']['pro_codigo'])
										->fetchAll(\PDO::FETCH_ASSOC) as $ataReuniaoDados):


								$formData = unserialize($ataReuniaoDados['form_ata_reuniao']);

								$linha = ($x % 2 == 0) ? 'linha1' : 'linha2';

								$PermiteEdicao = ($formData['usu_codigo_criador'] == $_SESSION['usu_codigo']) ? '<img src="./css/images/editar.gif" title="Editar" />' : '';

								echo '<tr class=' . $linha . '>',
									'<td>
				<a href="./action/formcontroler.php?'. base64_encode('alterar/AtaReuniao').'='. base64_encode($ataReuniaoDados['ata_codigo']) .'">',
								$PermiteEdicao,
								'</a>',
								'</td>',
								'<td>',$formData['ata_pauta'],'</td>',
								'<td>',$ataReuniaoDados['usu_codigo_criador'],'</td>'.
									'<td>',	$ataReuniaoDados['ata_data_criacao'],'</td>',
								'</tr>';
								$x++;

							endforeach;
							?>

						</table>
					</div>

					<?php

					$tbApontamentoProjeto = new TbApontamentoProjeto();

					$grid = new DataGrid(array('Descrição','Data',$_SESSION['config']['usuario']),
						$tbApontamentoProjeto->listarApontamento($_SESSION['alterar/Projeto']['pro_codigo']));

					$grid->titulofield = 'Apontamento(s) do projeto';
					$grid->islink = false;
					$grid->mostrarDatagrid(1);


					$tbFaseProjeto = new TbFaseProjeto();

					$dataGridFases = new DataGrid();
					$dataGridFases->setCabecalho(array('#','Fase(s)'));
					$dataGridFases->setDados($tbFaseProjeto->findByProjeto($_SESSION['alterar/Projeto']['pro_codigo']));
					$dataGridFases->acao = 'alterar/FaseProjeto';
					$dataGridFases->titulofield = 'Fase(s) do projeto';
					$dataGridFases->mostrarDatagrid(1);


					$tbUsuarioProjeto = new TbUsuarioProjeto();

					$dataGridFases = new DataGrid();
					$dataGridFases->setCabecalho(array('#','Usuário(s)'));
					$dataGridFases->setDados($tbUsuarioProjeto->findByProjeto($_SESSION['alterar/Projeto']['pro_codigo']));
					$dataGridFases->acao = 'alterar/UsuarioProjeto';
					$dataGridFases->titulofield = 'Usuário(s) participantes do projeto';
					$dataGridFases->mostrarDatagrid(1);

					try {

					$dirProjeto = new DirectoryIterator(DirectoryCreate::PATH . DirectoryCreate::PROJETOS .
						$_SESSION['alterar/Projeto']['pro_codigo']);

					?>

					<hr>
					<table border="1">
						<thead>
						<tr>
							<th>
								Arquivo(s) anexado(s) ao projeto.
							</th>
						</tr>
						</thead>


						<?php
						foreach ($dirProjeto as $dir):

							if ($dir->isDot()) {
								continue;
							}

							?>
							<tr>
								<td>
									<a href="action/downloadfile.php?tipo=projetos&codigo=<?php echo($_SESSION['alterar/Projeto']['pro_codigo']);?>&file=<?php echo $dir->getFilename();?>" target="_blank"><?php echo($dir->getFilename()); ?></a>
								</td>
							</tr>
							<?php
						endforeach;

						}catch(\Exception $e){
							echo 'Esse projeto não possui arquivos';
						}
						?>
						</table>

				</fieldset>
			</td>
		</tr>
	</table>
<?php unset($_SESSION['alterar/Projeto']);?>