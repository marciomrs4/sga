<?php
class Cadastro extends Dados
{

	public function cadastrarUsuario()
	{
		try
		{

			ValidarCampos::campoVazio($this->dados['usu_nome'],'Nome');
			ValidarCampos::campoVazio($this->dados['usu_sobrenome'],'Sobrenome');

			ValidarString::validarEmail($this->dados['usu_email'],'E-mail');

			ValidarCampos::campoVazio($this->dados['usu_ramal'],$_SESSION['config']['ramal']);
			ValidarCampos::campoVazio($this->dados['dep_codigo'],'Departamento');
			ValidarCampos::campoVazio($this->dados['tac_codigo'],'Tipo de Acesso');
			ValidarCampos::campoVazio($this->dados['ace_usuario'],$_SESSION['config']['usuario']);

			ValidarCampos::campoVazio($this->dados['ace_senha'],$_SESSION['config']['senha']);
			ValidarCampos::campoVazio($this->dados['ace_senha2'],'Repetir '.$_SESSION['config']['senha']);

			ValidarCampos::validarQtdCaracter($this->dados['ace_senha'],6,$_SESSION['config']['senha']);

			ValidarCampos::compararCampos($this->dados['ace_senha'],$this->dados['ace_senha2'],$_SESSION['config']['senha'].' e Repetir '.$_SESSION['config']['senha']);

			$this->dados['ace_senha'] = Validacao::hashSenha($this->dados['ace_senha']);

			#Instancia Tabela usuario
			$ValidarEmailUsuario = new TbUsuario();
			#Valida se j? existe um usu?rio cadastrado
			if($ValidarEmailUsuario->validaEmailUsuario($this->dados['usu_email']))
			{
				throw new Exception('E-mail j? cadastrado para outro '.$_SESSION['config']['usuario'],300);
			}

			#Instancia Tabela de acesso
			$ValidaUsuario = new TbAcesso();
			#Valida se j? existe um acesso com esse nome
			//if($ValidaUsuario->validaLoginAcesso($this->dados['ace_usuario']));
			//{
			//	throw new Exception('J? existe um '.$_SESSION['config']['usuario'].' ['.$this->dados['ace_usuario'].'] cadastrado no sistema.',300);
			//	}


			try
			{

				$this->conexao->beginTransaction();

				$tbusuario = new TbUsuario();
				$this->dados['usu_codigo'] = $tbusuario->insert($this->dados);

				$tbacesso = new TbAcesso();
				$tbacesso->insert($this->dados);

				#Cria o layout padr?o para o usu?rio
				$tblayout = new TbLayout();
				$tblayout->insertLayout($this->dados['usu_codigo']);

				$this->conexao->commit();

			}catch (PDOException $e)
			{
				$this->conexao->rollBack();
				throw new PDOException($e->getMessage(), $e->getCode());
			}
		} catch (Exception $e)
		{

			throw new Exception($e->getMessage(),$e->getCode());
		}

	}



	public function cadastrarDepartamento()
	{
		try
		{

			ValidarCampos::campoVazio($this->dados['dep_descricao'],'Departamento');
			ValidarCampos::campoVazio($this->dados['dep_email'],'E-Mail');

			ValidarString::validarEmail($this->dados['dep_email'],'E-mail');

			ValidarCampos::campoVazio($this->dados['dep_hora_inicio'],'Hora Inicio');
			ValidarCampos::campoVazio($this->dados['dep_hora_fim'],'Hora Fim');
			ValidarCampos::campoVazio($this->dados['dep_hora_almoco'],'Hora de almo�o');
			ValidarCampos::campoVazio($this->dados['dep_carga_sabado'],'Carga Hor�rio de S�bado');

			try
			{

				$this->conexao->beginTransaction();

				$tbdepartamento = new TbDepartamento();
				$this->dados['dep_codigo'] = $tbdepartamento->insert($this->dados);

				//				$tbacesso = new TbAcesso();
				//				$tbacesso->insert($this->dados);

				#Cria o layout padr?o para o usu?rio
				//				$tblayout = new TbLayout();
				//				$tblayout->insertLayout($this->dados['usu_codigo']);

				$this->conexao->commit();

			}catch (PDOException $e)
			{
				$this->conexao->rollBack();
				throw new PDOException($e->getMessage(), $e->getCode());
			}
		} catch (Exception $e)
		{

			throw new Exception($e->getMessage(),$e->getCode());
		}

	}


	public function cadastrarProjeto()
	{
		try
		{

			$tbprojeto = new TbProjeto();

			ValidarCampos::campoVazio($this->dados['pro_titulo'],'Titulo');
			ValidarCampos::campoVazio($this->dados['usu_codigo_solicitante'],$_SESSION['config']['usuario'].' Solicitante');
			ValidarCampos::campoVazio($this->dados['pro_descricao'],'Descri��o');
			ValidarCampos::campoVazio($this->dados['pro_previsao_inicio'],'Previs�o Inicio');
			ValidarCampos::campoVazio($this->dados['pro_previsao_fim'],'Previs�o Fim');

			$this->dados['pro_previsao_inicio'] = ValidarDatas::dataBanco($this->dados['pro_previsao_inicio']);
			$this->dados['pro_previsao_fim'] = ValidarDatas::dataBanco($this->dados['pro_previsao_fim']);

			$this->dados['stp_codigo'] = ($this->dados['stp_codigo'] == '') ? 1 : $this->dados['stp_codigo'];

			$this->dados['dep_codigo'] = $_SESSION['dep_codigo'];
			$this->dados['pro_cod_projeto'] = $tbprojeto->codigoProjeto();

			$pro_previsao_inicio = strtotime($this->dados['pro_previsao_inicio']);

			$pro_previsao_fim = strtotime($this->dados['pro_previsao_fim']);

			if($pro_previsao_inicio > $pro_previsao_fim){
				throw new \Exception('A data de previs�o de inicio deve ser menor que a previs�o de fim do projeto.');
			}

			try
			{

				$this->conexao->beginTransaction();

				$this->dados['pro_codigo'] = $tbprojeto->insert($this->dados);

				$this->conexao->commit();

			}catch (PDOException $e)
			{
				$this->conexao->rollBack();
				throw new PDOException($e->getMessage(), $e->getCode());
			}
		} catch (Exception $e)
		{

			throw new Exception($e->getMessage(),$e->getCode());
		}

	}



	public function cadastrarTempo()
	{
		try
		{
			ValidarCampos::campoVazio($this->dados['tat_descricao'],'Tempo de Atendimento');
			ValidarCampos::campoVazio($this->dados['dep_codigo'],'Departamento');


			$tbtempoatendimento = new TbTempoAtendimento();
			$tbtempoatendimento->insert($this->dados);

		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}

	#Gerar RNC
	public function cadastrarRnc()
	{

		try
		{

			ValidarCampos::campoVazio($this->dados['nc_descricaocompleta'], 'DESCRI��O');
			ValidarCampos::campoVazio($this->dados['nc_local_ocorrencia'], 'LOCAL');
			ValidarCampos::campoVazio($this->dados['usu_emitente_codigo'], 'EMITENTE');
			ValidarCampos::campoVazio($this->dados['dep_responsavel_codigo'], 'DEPTO RESPONS�VEL');
			ValidarCampos::campoVazio($this->dados['nc_acao_imediata'], 'A��O IMEDIATA');
			ValidarCampos::campoVazio($this->dados['nc_data_ocorrencia'],'DATA DA OCORR�NCIA');
			ValidarCampos::campoVazio($this->dados['sol_codigo'],'Codigo da Ocorr�ncia');

			$this->dados['nc_data_ocorrencia'] = date('Y-m-d',strtotime(str_replace('/','-',$this->dados['nc_data_ocorrencia'])));

			$this->dados['usu_codigo_criador'] = $_SESSION['usu_codigo'];


			$tbrnc = new TbCadastroRnc();
			$tbOcorrenciaRnc = new TbOcorrenciaRnc();

			$tbassentamento = new TbAssentamento();
			$tbsolicitacao = new TbSolicitacao();
			$tbatendente = new TbAtendenteSolicitacao();
			$tbproblema = new TbProblema();

			//Inicia a transacao
			$this->conexao->beginTransaction();

			//Recupera o codigo da NC gerado
			$this->dados['nc_codigo'] = $tbrnc->insert($this->dados);
			$this->dados['sol_codigo'];
			//Inseri a ocorrencia com o chamado na lista
			$tbOcorrenciaRnc->insert($this->dados);


			//Coloca o problema indicado na RNC como problema Tecnico
			$this->dados['pro_codigo_tecnico'] = $this->dados['pro_codigo_tecnico_rnc'];


			$this->dados['numero_rnc'] = $tbrnc->getNumberRncFormatado($this->dados['nc_codigo']);
			$this->dados['usu_codigo'] = $_SESSION['usu_codigo'];
			$this->dados['ass_descricao'] = 'Este chamado esta sendo encerrado devido a abertura da RNC '
				. $this->dados['numero_rnc'] .'.';

			$tbassentamento->insert($this->dados);


			//Altera o status do chamado para FECHADO (3)
			$this->dados['sta_codigo'] = 3;
			$tbsolicitacao->alterarStatus($this->dados);

			#Instancia da Classe CalculoAtendimento
			$tbcalculoatendimento = new TbCalculoAtendimento();

			$tbcalculoatendimento->insertCalculoAtendimento($this->dados);

			$this->conexao->commit();

			//Cria o diretorio para RNC
			$directoryCreate = new DirectoryCreate();
			$directoryCreate->createDirRnc($this->dados['nc_codigo']);

			//Pega todos os arquivos que houver no chamado e coloca na RNC
			$fileCopy = new FileCopy();
			$fileCopy->setChamado($this->dados['sol_codigo'])
				->setRnc($this->dados['nc_codigo'])
				->copyChamadoToRnc();

			$email = new Email();
			$this->dados['Solicitante'] = true;
			$this->dados['Departamento'] = true;
			$email->interacaoAssentamento($this->dados);

			$emailReclamante = new Email();
			$emailReclamante->notificarCriacaoRncReclamente($this->dados);

			$emailDepartamento = new Email();
			$emailDepartamento->notificarCriacaoRncDepartamento($this->dados);


		} catch (\Exception $e)
		{
			$this->conexao->rollBack();

			throw new \Exception($e->getMessage(), $e->getCode());
		}
	}

	#Resposta Gestor RNC
	public function cadastrarRespostaRnc()
	{

		try
		{

			ValidarCampos::campoVazio($this->dados['nc_causas'], 'CAUSA DA OCORR�NCIA');
			ValidarCampos::campoVazio($this->dados['nc_acao_melhoria'], 'MELHORIA');
			ValidarCampos::campoVazio($this->dados['nc_prazo_implatacao'], 'PRAZO PARA IMPLANTA��O');
			ValidarCampos::campoVazio($this->dados['nc_resp_implantacao'], 'RESPONS�VEL PELA IMPLANTA��O');


			$tbrnc = new TbCadastroRnc();

			$this->dados['nc_data_implantacao'] = date('Y-m-d',strtotime(str_replace('/','-',$this->dados['nc_data_implantacao'])));
			$this->dados['nc_edicao_gestor'] = 1;

			$this->dados['nc_prazo_implatacao'] = date('Y-m-d',strtotime(str_replace('/','-',$this->dados['nc_prazo_implatacao'])));

			$this->dados['nc_data_resposta_gestor'] = date('Y-m-d');

			if($tbrnc->getStatus($this->dados['nc_codigo']) == 1) {
				$this->dados['snc_codigo'] = 2;
			}else{
				$this->dados['snc_codigo'] = $tbrnc->getStatus($this->dados['nc_codigo']);
			}

			$this->dados['usu_codigo_repondedor'] = $_SESSION['usu_codigo'];

			//$this->conexao->beginTransaction();


			$this->dados['numero_rnc'] = $tbrnc->getNumberRncFormatado($this->dados['nc_codigo']);
			$tbrnc->update($this->dados);


			$email = new Email();
			$email->notificarRespostaRncGestor($this->dados);

		} catch (\Exception $e)
		{
			throw new \Exception($e->getMessage(), $e->getCode());
		}
	}

	public function cadastrarPrioridade()
	{
		try
		{
			ValidarCampos::campoVazio($this->dados['pri_descricao'],'Prioridade');
			ValidarCampos::campoVazio($this->dados['tat_codigo'],'Tempo de Atendimento');

			ValidarCampos::campoVazio($this->dados['dep_codigo_prioridade'],'Tempo de Atendimento');

			$this->dados['dep_codigo'] = $this->dados['dep_codigo_prioridade'];

			$tbprioridade = new TbPrioridade();
			$tbprioridade->insert($this->dados);

		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}

	public function cadastrarProblema()
	{
		try
		{

			ValidarCampos::campoVazio($this->dados['pro_descricao'],$_SESSION['config']['problema']);
			ValidarCampos::campoVazio($this->dados['dep_codigo_problema'],'Departamento');
			ValidarCampos::campoVazio($this->dados['pri_codigo'],'Prioridade');

			$this->dados['pro_mostrar_usuario'] = ValidarCampos::campoEmptyTernario($this->dados['pro_mostrar_usuario'],1, '');
			$this->dados['pro_status_ativo'] = ValidarCampos::campoEmptyTernario($this->dados['pro_status_ativo'],1, '');

			ValidarCampos::campoVazio($this->dados['pro_tempo_solucao'],'Tempo de Solu��o');

			$this->dados['dep_codigo'] = $this->dados['dep_codigo_problema'];

			$tbproblema = new TbProblema();
			$tbproblema->insert($this->dados);

		} catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}

	public function cadastrarStatus($dep_codigo)
	{
		try
		{
			ValidarCampos::campoVazio($this->dados['sta_descricao'],'Status');

			$this->dados['dep_codigo'] = $dep_codigo;

			$tbstatus = new TbStatus();
			$tbstatus->insert($this->dados);

		} catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}

	/**
	 *
	 * Enter description here ...
	 * @param unknown_type $usu_codigo_solicitante
	 * @param unknown_type $file
	 * @throws PDOException
	 * @throws Exception
	 * @example para cadastrar uma solicita??o s?o necessarios 3 tabelas
	 * 1 - tb_solicitacao
	 * 2 - tb_anexo [N?o obrigat?rio
	 * 3 - tb_calculo_atendimento
	 * 	1: Grava os dados da solicitacao
	 * 	2: Grava um anexo da solicita??o se houver
	 * 	3: Grava a data de cria??o para o acompanhamento da solicita??o
	 */
	public function cadastrarSolicitacao($usu_codigo_solicitante = null,$file)
	{
		try
		{

			#Metodos de valida??o
			ValidarCampos::campoVazio($this->dados['dep_codigo'],'Departamento');
			ValidarCampos::campoVazio($this->dados['pro_codigo'],$_SESSION['config']['problema']);
			ValidarCampos::campoVazio($this->dados['sol_descricao_solicitacao'],'Descri��o do '.$_SESSION['config']['problema']);
			ValidarCampos::validarQtdCaracter($this->dados['sol_descricao_solicitacao'],5,'Descri��o do'.$_SESSION['config']['problema']);
			$this->dados['sol_descricao_solicitacao'] = strip_tags($this->dados['sol_descricao_solicitacao']);
			#Capturando o codigo do usu?rio solicitante
			$this->dados['usu_codigo_solicitante'] = ($usu_codigo_solicitante == null) ? $this->dados['usu_codigo_solicitante'] : $usu_codigo_solicitante;
			#Capturando o c?digo do DEPTO solicitado
			$this->dados['dep_codigo_solicitado'] = $this->dados['dep_codigo'];
			#Capta o status do chamado, no caso em atendimento
			$this->dados['sta_codigo'] = 1;

			try
			{

				#Inicia a transa??o
				$this->conexao->beginTransaction();

				#Grava na tabela de solicitacao
				$tbsolicitacao = new TbSolicitacao();
				$this->dados['sol_codigo'] = $tbsolicitacao->insert($this->dados);


				/*  Instancia da classe Arquivo que manipula os aquivos
					$arquivo = new Arquivo();
					#Metodo setDados que serve para setar o $file que cont?m todo o arquivo
					$arquivo->setDados($file);

					 /* Capturando os dados do arquivo

					$this->dados['ane_anexo'] = $arquivo->arquivoBinario();
					$this->dados['ane_nome'] = $arquivo->arquivoNome();
					$this->dados['ane_tamanho'] = $arquivo->arquivoTamanho();
					$this->dados['ane_tipo'] = $arquivo->arquivoTipo();

					/*Gravando o arquivo no banco dentro da tabela de anexo
					$tbanexo = new TbAnexo();
					$tbanexo->insert($this->dados);*/

				#Grava a data de abertura da solicita??o
				$tbcalculoatendimento = new TbCalculoAtendimento();
				$tbcalculoatendimento->insertCalculoAtendimento($this->dados);

				#Se tudo deu certo, faz commit
				$this->conexao->commit();


				$this->dados['sol_codigo'] = base64_encode($this->dados['sol_codigo']);
				$this->cadastrarAnexoChamado($file);
				$this->dados['sol_codigo'] = base64_decode($this->dados['sol_codigo']);



				if($this->dados['Departamento'] || $this->dados['Solicitante'])
				{
					$email = new Email();
					$email->aberturaChamado($this->dados);
				}

			}catch (PDOException $e)
			{
				#Se algo deu errado faz o rollBack
				$this->conexao->rollBack();
				#Lan?a uma exe??o do tipo PDOException
				throw new PDOException($e->getMessage(), $e->getCode());
			}



		}catch (Exception $e)
		{
			#Lan?a uma exce??o do tipo Exception
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}

	#cadastra as solicitacaoes tecnicas
	public function cadastrarSolicitacaoTecnico($usu_codigo_solicitante = null, $file)
	{
		try
		{

			#Metodos de valida??o
			ValidarCampos::campoVazio($this->dados['dep_codigo_tecnico'],'Departamento');
			ValidarCampos::campoVazio($this->dados['pro_codigo'],$_SESSION['config']['problema']);
			ValidarCampos::campoVazio($this->dados['sol_descricao_solicitacao'],'Descri��o do '.$_SESSION['config']['problema']);
			ValidarCampos::validarQtdCaracter($this->dados['sol_descricao_solicitacao'],5,'Descri��o do'.$_SESSION['config']['problema']);
			$this->dados['sol_descricao_solicitacao'] = strip_tags($this->dados['sol_descricao_solicitacao']);
			#Capturando o codigo do usu?rio solicitante
			$this->dados['usu_codigo_solicitante'] = ($usu_codigo_solicitante == null) ? $this->dados['usu_codigo_solicitante'] : $usu_codigo_solicitante;
			#Capturando o c?digo do DEPTO solicitado
			$this->dados['dep_codigo_solicitado'] = $this->dados['dep_codigo_tecnico'];
			#Capta o status do chamado, no caso em atendimento
			$this->dados['sta_codigo'] = 1;

			try
			{

				#Inicia a transa??o
				$this->conexao->beginTransaction();

				#Grava na tabela de solicitacao
				$tbsolicitacao = new TbSolicitacao();
				$this->dados['sol_codigo'] = $tbsolicitacao->insert($this->dados);


				#Grava a data de abertura da solicita??o
				$tbcalculoatendimento = new TbCalculoAtendimento();
				$tbcalculoatendimento->insertCalculoAtendimento($this->dados);


				#Se tudo deu certo, faz commit
				$this->conexao->commit();



				/*					#Instancia da classe Arquivo que manipula os aquivos
                                    $arquivo = new Arquivo();
                                    #Metodo setDados que serve para setar o $file que cont?m todo o arquivo
                                    $arquivo->setDados($file);

                                    * Capturando os dados do arquivo

                                    $this->dados['ane_anexo'] = $arquivo->arquivoBinario();
                                    $this->dados['ane_nome'] = $arquivo->arquivoNome();
                                    $this->dados['ane_tamanho'] = $arquivo->arquivoTamanho();
                                    $this->dados['ane_tipo'] = $arquivo->arquivoTipo();

                                    #Gravando o arquivo no banco dentro da tabela de anexo
                                    $tbanexo = new TbAnexo();
                                    $tbanexo->insert($this->dados);*/

				$this->dados['sol_codigo'] = base64_encode($this->dados['sol_codigo']);
				$this->cadastrarAnexoChamado($file);



				if($this->dados['Departamento'] || $this->dados['Solicitante'])
				{
					$email = new Email();
					$this->dados['sol_codigo'] = base64_decode($this->dados['sol_codigo']);
					$email->aberturaChamado($this->dados);
				}

			}catch (PDOException $e)
			{
				#Se algo deu errado faz o rollBack
				$this->conexao->rollBack();
				#Lan?a uma exe??o do tipo PDOException
				throw new PDOException($e->getMessage(), $e->getCode());
			}



		}catch (Exception $e)
		{
			#Lan?a uma exce??o do tipo Exception
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}


	public function cadastrarAssentamento()
	{
		try
		{

			$this->dados['ass_descricao'] = strip_tags($this->dados['ass_descricao']);
			ValidarCampos::campoVazio($this->dados['ass_descricao'],'Descri��o');
			ValidarCampos::campoVazio($this->dados['usu_codigo_atendente'],'Atendente do Chamado');




			$this->dados['usu_codigo'] = $_SESSION['usu_codigo'];

			$this->dados['sta_codigo'];

			//Valida se est�o tentando encerrar o chamado que est� em poder de terceiro, em caso sim, n�o deixa encerrar
			$TbSolicitacaoTerceiro = new TbSolicitacaoTerceiro();
			$Solicitacao = $TbSolicitacaoTerceiro->getChamadoInTerceiro($this->dados['sol_codigo']);

			if(($this->dados['sta_codigo'] == 3) or ($this->dados['sta_codigo'] == 4)) {

				if ($Solicitacao['sot_status'] == 'S') {
					throw new Exception('Esse chamado esta em poder de terceiro e n�o pode ser concluido!', 300);
				}
			}
			//

			try
			{
				$tbassentamento = new TbAssentamento();
				$tbsolicitacao = new TbSolicitacao();
				$tbatendente = new TbAtendenteSolicitacao();
				$tbproblema = new TbProblema();


				if($this->dados['pro_codigo_tecnico'] == ''){
					$this->dados['pro_codigo_tecnico'] = $tbsolicitacao->getProblema($this->dados['sol_codigo']);
				}


				#Inicia a trans??o
				$this->conexao->beginTransaction();

				if($tbatendente->confirmarAtendente($this->dados['sol_codigo']))
				{
					$tbatendente->update($this->dados);

				}else{

					#Pega o codigo do problema da solicitacao
					$pro_codigo = $tbsolicitacao->getProblema($this->dados['sol_codigo']);

					#Com o codigo do problema eu pego o codigo da prioridade para
					#Colocar na tabela de atendente
					$this->dados['pri_codigo'] = $tbproblema->getPrioridade($pro_codigo);

					$tbatendente->insert($this->dados);
				}



				$tbassentamento->insert($this->dados);
				$tbsolicitacao->alterarStatus($this->dados);

				#Instancia da Classe CalculoAtendimento
				$tbcalculoatendimento = new TbCalculoAtendimento();

				#Verifica se j? houve um cadastro em abertura
				//if($tbcalculoatendimento->verificaAberto($this->dados))
				//{
				//	$this->dados['sta_codigo'] = 5;
				//$tbcalculoatendimento->insertCalculoAtendimento($this->dados);
				//}else
				//{
				$tbcalculoatendimento->insertCalculoAtendimento($this->dados);
				//}

				#Faz commit se tudo deu certo
				$this->conexao->commit();

				if($this->dados['Departamento'] || $this->dados['Solicitante'])
				{
					#Envia e-mail ao colocar um assentamento
					$email = new Email();
					$email->interacaoAssentamento($this->dados);
				}

			} catch (PDOException $e)
			{
				#Faz Rollback se algo der errado
				$this->conexao->rollBack();
				throw new PDOException($e->getMessage(), $e->getCode());
			}


		} catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}

	public function cadastrarAssentamentoSolicitante()
	{
		try
		{

			//filter_var_array($this->dados,FILTER_SANITIZE_STRING);

			$this->dados['ass_descricao'] = strip_tags($this->dados['ass_descricao']);
			ValidarCampos::campoVazio($this->dados['ass_descricao'],'Assentamento');

			$this->dados['usu_codigo'] = $_SESSION['usu_codigo'];

			$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? $this->dados['sta_codigo'] : 3;

			//Valida se est�o tentando encerrar o chamado que est� em poder de terceiro, em caso sim, n�o deixa encerrar
			$TbSolicitacaoTerceiro = new TbSolicitacaoTerceiro();
			$Solicitacao = $TbSolicitacaoTerceiro->getChamadoInTerceiro($this->dados['sol_codigo']);

			if($this->dados['sta_codigo'] == 3) {

				if ($Solicitacao['sot_status'] == 'S') {
					throw new Exception('Esse chamado esta em poder de terceiro e n�o pode ser concluido!', 300);
				}
			}
			//

			try
			{
				$tbassentamento = new TbAssentamento();
				$tbsolicitacao = new TbSolicitacao();
				$tbproblema = new TbProblema();
				$tbAtendenteSolicitacao = new TbAtendenteSolicitacao();

				#Inicia a trans??o
				$this->conexao->beginTransaction();


				/* 				#Verifica se existe um atendente no chamado
                 * 				#Removido devido a necessidade da Lilian fechar o chamado mesmo sem atendente.
                                if($tbAtendenteSolicitacao->confirmarAtendente($this->dados['sol_codigo']) == '')
                                {
                                    throw new Exception('N?o existe um atendente para esse chamado!');
                                } */


				#Insere um assentamento
				$tbassentamento->insert($this->dados);
				#Altera a Data do Chamado para atual
				$tbsolicitacao->alterarDataFim($this->dados);

				if($this->dados['sta_codigo'] == 3)
				{
					#Alterar status da solicita??o
					$tbsolicitacao->alterarStatusSolicitante($this->dados);

					#Grava a data de alteracao de status da solicita??o
					$tbcalculoatendimento = new TbCalculoAtendimento();
					$tbcalculoatendimento->insertCalculoAtendimento($this->dados);

				}

				#Faz commit se tudo deu certo
				$this->conexao->commit();


				#Enviar e-mail com assentamentos 

				if($this->dados['Departamento'] || $this->dados['Solicitante'])
				{
					$email = new Email();
					$email->interacaoAssentamento($this->dados);
				}

			} catch (Exception $e)
			{
				#Faz Rollback se algo der errado
				$this->conexao->rollBack();
				throw new PDOException($e->getMessage(), $e->getCode());
			}


		} catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}

	public function cadastrarChecklist()
	{
		try
		{
			ValidarCampos::campoVazio($this->dados['che_titulo'],'Titulo');
			ValidarCampos::campoVazio($this->dados['che_email_envio'],'E-mail de Envio');
			ValidarCampos::campoVazio($this->dados['che_descricao'],'Descri��o');
			ValidarCampos::campoVazio($this->dados['dep_codigo'],'Departamento');
			ValidarCampos::campoVazio($this->dados['che_ativo'],'Departamento');

			ValidarString::validarEmail($this->dados['che_email_envio'],'E-mail com sintaxe incorreta');

			$this->dados['usu_codigo'] = $_SESSION['usu_codigo'];

			try
			{
				$this->conexao->beginTransaction();

				$tbchecklist = new TbChecklist();
				$this->dados['che_codigo'] = $tbchecklist->insert($this->dados);

				$tbDiaSemana = new TbDiaSemanaCheckList();
				$tbDiaSemana->insert($this->dados);

				$this->conexao->commit();

			} catch (PDOException $e)
			{
				$this->conexao->rollBack();
				throw new PDOException($e->getMessage(), $e->getCode());
			}

		} catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}

	public function cadastrarItemChecklist($file)
	{

		$this->listarDados();

		try
		{

			ValidarCampos::campoVazio($this->dados['ich_titulo_tarefa'],'Tarefa');
			//ValidarCampos::campoVazio($this->dados['ich_link'],'');
			//$this->dados['ich_ativo']

			try
			{

				$this->conexao->beginTransaction();

				$tbitemcklist = new TbItemChecklist();
				$this->dados['ich_codigo'] = $tbitemcklist->insert($this->dados);

				$tbDiaSemana = new TbDiaSemana();
				$tbDiaSemana->insert($this->dados);

				if($file['tmp_name'] != '')
				{
					#Instancia da classe Arquivo que manipula os aquivos
					$arquivo = new Arquivo();
					#Metodo setDados que serve para setar o $file que cont?m todo o arquivo
					$arquivo->setDados($file);
					/*
					 * Capturando os dados do arquivo
					 */

					$this->dados['ane_anexo'] = $arquivo->arquivoBinario();
					$this->dados['ane_nome'] = $arquivo->arquivoNome();
					$this->dados['ane_tamanho'] = $arquivo->arquivoTamanho();
					$this->dados['ane_tipo'] = $arquivo->arquivoTipo();

					#Gravando o arquivo no banco dentro da tabela de anexo
					$tbanexo = new TbAnexoCheckList();
					$tbanexo->insert($this->dados);
				}

				$this->conexao->commit();


			} catch (PDOException $e)
			{
				$this->conexao->rollBack();

				throw new PDOException($e->getMessage(), $e->getCode());
			}

		} catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}

	}

	public function cadastrarExecutarChecklist()
	{
		$tarefa = '';

		try
		{
			$observacao = $this->dados['obs'];
			$EmailEnvio = $this->dados['che_email_envio'];
			$CheCodigo = $this->dados['che_codigo'];
			$CheTitulo = $this->dados['che_titulo'];

			ValidarCampos::campoVazio($observacao,'Observa��o');
			ValidarCampos::validaQtdCaracter($observacao,20,'Observa��o');

			array_pop($this->dados);
			array_pop($this->dados);
			array_pop($this->dados);
			array_pop($this->dados);

			try
			{

				foreach ($this->dados as $campo => $valor)
				{

					ValidarCampos::campoVazio($valor,$campo);

					$tarefa .= $campo." - ".ValidarCampos::retornarStatus($valor,Texto::letterBlue('OK'),Texto::letterRed('ERRO'))."<br />";

				}


				$tbhistoricocklist = new TbHistoricoCheckList();

				$this->dados['usu_email'] = $_SESSION['usu_email'];
				$this->dados['hck_status'] = 1;

				$this->dados['che_codigo'] = $CheCodigo;
				$this->dados['che_titulo'] = $CheTitulo;

				$tbhistoricocklist->insert($this->dados);

				$email = new Email();
				$email->cabecalho = 'CheckList: '.$this->dados['che_titulo'];

				$email->AddAddress($EmailEnvio);

				$email->mensagem ="Em: ".date("d-m-Y H:i:s")."<br />";
				$email->mensagem .= "O usu�rio: <b>{$this->dados['usu_email']}</b> verificou as seguintes tarefas:<br /><br />";
				$email->mensagem .= "$tarefa <br />";
				$email->mensagem .= $observacao;
				$email->enviarEmail();

			}catch (PDOException $e)
			{
				throw new PDOException($e->getMessage(), $e->getCode());
			}

		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}

	}

	public function cadastrarAtividade()
	{
		try
		{

			ValidarCampos::campoVazio($this->dados['pro_codigo'],'Projeto');
			ValidarCampos::campoVazio($this->dados['usu_codigo_responsavel'],$_SESSION['config']['usuario'].' Executor');
			ValidarCampos::campoVazio($this->dados['at_previsao_inicio'],'Previs�o Inicio');
			ValidarCampos::campoVazio($this->dados['at_previsao_fim'],'Previs�o Fim');
			ValidarCampos::campoVazio($this->dados['at_descricao'],'Descri��o');


			$this->dados['at_previsao_inicio'] = ValidarDatas::dataBanco($this->dados['at_previsao_inicio']);
			$this->dados['at_previsao_fim'] = ValidarDatas::dataBanco($this->dados['at_previsao_fim']);

			$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? 1 : $this->dados['sta_codigo'];

			$this->dados['usu_codigo_criador'] = $_SESSION['usu_codigo'];

			$this->dados['at_notificacao'] = ($this->dados['at_notificacao'] == '') ? null : '1';

			$this->dados['fas_codigo'] = ($this->dados['fas_codigo'] == '') ? null : $this->dados['fas_codigo'];
			$this->dados['at_codigo_dependente'] = ($this->dados['at_codigo_dependente'] == '') ? null : $this->dados['at_codigo_dependente'];


			try
			{

				$this->conexao->beginTransaction();

				$tbProjeto = new TbProjeto();

				$dataProjeto = $tbProjeto->getDataIncioFimProjeto($this->dados['pro_codigo']);


				$pro_previsao_inicio = strtotime($dataProjeto['pro_previsao_inicio']);

				$pro_previsao_fim = strtotime($dataProjeto['pro_previsao_fim']);

				$at_previsao_inicio = strtotime($this->dados['at_previsao_inicio']);
				$at_previsao_fim = strtotime($this->dados['at_previsao_fim']);

				//valida se a data de inicio da atividade e menor que a data final da atividade
				if($at_previsao_inicio > $at_previsao_fim){
					throw new \Exception('A data inicial da atividade deve ser menor que a data final.');
				}

				//Valida se a data inicial da atividade � maior que a data inicial do projeto
				if($at_previsao_inicio < $pro_previsao_inicio){
					throw new \Exception('A data inicial da atividade deve ser maior que a data inicial do projeto. '.date('d-m-Y',$pro_previsao_inicio));
				}

				//Valida se a data final da atividade � menor que a data final do projeto
				if($at_previsao_fim > $pro_previsao_fim){
					throw new \Exception('A data final da atividade deve ser menor ou igual que a data final do projeto.' .date('d-m-Y',$pro_previsao_fim));
				}



				$status = $tbProjeto->getStatusProjeto($this->dados['pro_codigo']);

				if($status > 2)
				{
					throw new Exception('N�o � poss�vel criar essa atividade: Este projeto n�o esta em andamento');
				}else
				{

					$tbAtividade = new TbAtividade();

					$projeto = $this->dados['pro_codigo']-1;
					$atividade = $tbAtividade->getNumeroAtividadeProjeto($this->dados['pro_codigo'])+1;

					$this->dados['at_titulo'] = $projeto . '-' .$atividade;

					$this->dados['at_codigo'] = $tbAtividade->insert($this->dados);

					$qtd = $tbAtividade->getCountQtdAtividadeByProjetos($this->dados['pro_codigo']);

					if($qtd['qtd_atividade'] != 0){
						$this->dados['at_tipo_atividade'] = 1;
						$tbAtividade->updateTipoAtividade($this->dados);
					}

					$this->conexao->commit();
				}

			}catch (PDOException $e)
			{
				$this->conexao->rollBack();
				throw new PDOException($e->getMessage(), $e->getCode());
			}
		} catch (Exception $e)
		{

			throw new Exception($e->getMessage(),$e->getCode());
		}

	}

	public function cadastrarUsuarioAtividade()
	{

		try
		{
			ValidarCampos::campoVazio($this->dados['at_codigo']);
			ValidarCampos::campoVazio($this->dados['usu_codigo'],$_SESSION['config']['usuario']);
			ValidarCampos::campoVazio($this->dados['tua_codigo'],'Tipo de '.$_SESSION['config']['usuario']);

			try
			{
				$this->conexao->beginTransaction();

				$tbUsuarioAtividade = new TbUsuarioAtividade();

				$tbUsuarioAtividade->insert($this->dados);

				$this->conexao->commit();


			} catch (PDOException $e)
			{
				$this->conexao->rollBack();
				throw new PDOException($e->getMessage(), $e->getCode());
			}


		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}

	}

	public function cadastrarApontamento()
	{

		try
		{

			ValidarCampos::campoVazio($this->dados['at_codigo']);
			ValidarCampos::campoVazio($this->dados['ap_descricao'],'Descri��o do Apontamento');

			$this->dados['usu_codigo'] = $_SESSION['usu_codigo'];

			try
			{
				$this->conexao->beginTransaction();

				$tbAtividade = new TbAtividade();

				$dataAtividade = $tbAtividade->getDataInicioFimAtividade($this->dados['at_codigo']);


				//Atualiza a data Inicio ao ter um apontamento com status em andamento e ainda data inicio vazia
				if(($this->dados['sta_codigo'] == 2) and ($dataAtividade['at_inicio'] == '')){

					$dados['at_inicio'] = date('Y-m-d H:i:s');
					$dados['at_codigo'] = $this->dados['at_codigo'];

					$tbAtividade->updateDataInicioAtividade($dados);
				}

				//Atualiza a data de Fim ao ter um apontamento com status em concluido e ainda data fim vazia
				if(($this->dados['sta_codigo'] == 3) and ($dataAtividade['at_fim'] == '')){

					$dados['at_codigo'] = $this->dados['at_codigo'];

					$dados['at_fim'] = date('Y-m-d H:i:s');
					$tbAtividade->updateDataFimAtividade($dados);

					if ($dataAtividade['at_inicio'] == '') {

						$dados['at_inicio'] = date('Y-m-d H:i:s');
						$tbAtividade->updateDataInicioAtividade($dados);
					}
				}


				//Atualiza a data de Fim ao ter um apontamento com status cancelado e ainda data fim vazia
				if(($this->dados['sta_codigo'] == 4) and ($dataAtividade['at_fim'] == '')) {

					$dados['at_codigo'] = $this->dados['at_codigo'];

					$dados['at_fim'] = date('Y-m-d H:i:s');
					$tbAtividade->updateDataFimAtividade($dados);

					if ($dataAtividade['at_inicio'] == '') {

						$dados['at_inicio'] = date('Y-m-d H:i:s');
						$tbAtividade->updateDataInicioAtividade($dados);
					}

				}




				$tbApontamento = new TbApontamento();


				$atividadeDependete = $tbAtividade->getAtividadeDependente($this->dados['at_codigo']);


				if($atividadeDependete['sta_codigo'] == 1){
					throw new \Exception("A atividade {$atividadeDependete['at_titulo']} �
					dependente, vc n�o pode iniciar essa atividade!");
				}



				$status = $tbAtividade->getStatusAtividade($this->dados['at_codigo']);

				if($status > 2)
				{
					throw new Exception('N�o � poss�vel criar apontamento: Esta atividade n�o esta em Andamento ou Pendente');
				}else
				{

					$tbApontamento->insert($this->dados);
					$tbAtividade->updateStatusAtividade($this->dados);

					$this->conexao->commit();




					if(($this->dados['informados']) or ($this->dados['consultados']) or ($this->dados['participantes'])) {

						$Email = new Email();
						$Email->apontamentoAtividade($this->dados);

					}
				}


			} catch (PDOException $e)
			{
				$this->conexao->rollBack();
				throw new PDOException($e->getMessage(), $e->getCode());
			}


		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}

	}

	public function cadastrarAniversario()
	{

		try
		{

			ValidarCampos::campoVazio($this->dados['ani_drt'],'DRT');
			ValidarCampos::campoVazio($this->dados['ani_nome'],'Nome');
			ValidarCampos::campoVazio($this->dados['ani_setor'],'Setor');
			ValidarCampos::campoVazio($this->dados['ani_data_nascimento'],'Data Nascimento');
			ValidarCampos::campoVazio($this->dados['ani_unidade'],'Unidade');

			ValidarDatas::validarData($this->dados['ani_data_nascimento'],'Data Nascimento');

			$ani_data_nascimento = ValidarDatas::dataBanco($this->dados['ani_data_nascimento']);

			$this->dados['ani_data_nascimento'] = $ani_data_nascimento;

			$data = strtotime($ani_data_nascimento);

			$this->dados['ani_dia'] = date('d',$data);
			$this->dados['ani_mes'] = date('m',$data);
			$this->dados['ani_ano'] = date('Y',$data);


			try
			{
				$tbAniversariante = new TbAniversariante();

				$tbAniversariante->insert($this->dados);

			}catch (PDOException $e)
			{
				throw new PDOException($e->getMessage(), $e->getCode());
			}


		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}


	}


	public function cadastrarSolicitacaoMelhoria($file)
	{

		try
		{

			ValidarCampos::campoVazio($this->dados['sis_codigo'],'Sistema');
			ValidarCampos::campoVazio($this->dados['som_descricao'],'Descricao');

			$this->dados['usu_codigo_solicitante'] = $_SESSION['usu_codigo'];
			$this->dados['stm_codigo'] = 1;


			try
			{
				$tbMelhoria = new TbSolicitacaoMelhoria();

				$this->conexao->beginTransaction();

				$this->dados['som_codigo'] = $tbMelhoria->insert($this->dados);

				$this->conexao->commit();

				$this->dados['som_codigo'] = base64_encode($this->dados['som_codigo']);
				$this->cadastrarAnexoMelhoria($file);

				#Envio de e-mail
				$email = new Email();

				$this->dados['som_codigo'] = base64_decode($this->dados['som_codigo']);
				$email->aberturaMelhoria($this->dados);

			}catch (PDOException $e)
			{
				throw new PDOException($e->getMessage(), $e->getCode());
			}


		}catch (Exception $e)
		{
			$this->conexao->rollBack();
			throw new Exception($e->getMessage(), $e->getCode());
		}


	}

	public function cadastrarApontamentoMelhoria()
	{

		try
		{

			ValidarCampos::campoVazio($this->dados['som_codigo'],'Sistema');
			ValidarCampos::campoVazio($this->dados['apm_descricao'],'Descricao');

			$this->dados['usu_codigo'] = $_SESSION['usu_codigo'];

			try
			{

				$tbApontamentoMelhoria = new TbApontamentoMelhoria();
				$tbSolicitacaoMelhoria = new TbSolicitacaoMelhoria();

				#Obtem os dados da melhoria
				$Melhoria = $tbSolicitacaoMelhoria->getForm($this->dados['som_codigo']);

				$tbSistema = new TbSistemas();
				#Obtem os dados do Sistema
				$Sistema = $tbSistema->getForm($Melhoria['sis_codigo']);

				#Obtem o atendente do sistema
				$Atendente = $tbSolicitacaoMelhoria->getUsuarioAtendente($this->dados['som_codigo']);

				//empty($Atendente) = $Sistema['usu_codigo_usuario_chave'] != $_SESSION['usu_codigo'];

				#Verifica se o usuario e o atendente e se existe atendente
				if(($Sistema['usu_codigo_usuario_chave'] != $_SESSION['usu_codigo']) and (empty($Atendente))){
					throw new Exception('N�o existe um atendente, voc� n�o pode inserir um apontamento.');
				}

				#Inicia a transacao
				$this->conexao->beginTransaction();

				if($Sistema['usu_codigo_usuario_chave'] == $_SESSION['usu_codigo']){
					$tbSolicitacaoMelhoria->updateStatusMelhoria($this->dados);
				}

				#Obtem o Status atual da melhorias
				$this->dados['stm_codigo'] = $tbSolicitacaoMelhoria->getStatusMelhoria($this->dados['som_codigo']);

				#Inseri um apontamento da melhoria
				$tbApontamentoMelhoria->insert($this->dados);

				#Finaliza com commit
				$this->conexao->commit();

				#Envio de email
				$email = new Email();
				$email->apontamentoMelhoria($this->dados);

			}catch (PDOException $e)
			{
				#Se erro, faz rollback
				$this->conexao->rollBack();

				throw new PDOException($e->getMessage(), $e->getCode());
			}


		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}


	}



	public function cadastrarSistema()
	{

		try {

			ValidarCampos::campoVazio($this->dados['sis_descricao'],'Sistema');
			ValidarCampos::campoVazio($this->dados['usu_codigo_usuario_chave'],'Usu�rio chave');

			$this->dados['sis_status'] = 1;

			try {

				$tbSistema = new TbSistemas();

				$tbSistema->insert($this->dados);

			} catch (PDOException $e) {
				throw new PDOException($e->getMessage(), $e->getCode());
			}

		} catch (Exception $e) {
			throw new Exception($e->getMessage(), $e->getCode());
		}

	}

	public function cadastrarTerceiro()
	{

		try {

			ValidarCampos::campoVazio($this->dados['ter_descricao'],'Descric�o');
			ValidarCampos::campoVazio($this->dados['dep_codigo'],'Deparamento');

			$this->dados['ter_status'] = ($this->dados['ter_status'] == '') ? 0 : 1;

			try {

				$tbTerceiro = new TbTerceiro();

				$tbTerceiro->insert($this->dados);

			} catch (PDOException $e) {
				throw new PDOException($e->getMessage(), $e->getCode());
			}

		} catch (Exception $e) {
			throw new Exception($e->getMessage(), $e->getCode());
		}

	}


	public function cadastrarEnvioTerceiro()
	{

		try {

			//Valida se existe o codigo do chamado e o codigo do terceiro
			ValidarCampos::campoVazio($this->dados['sol_codigo'],'Codigo');
			ValidarCampos::campoVazio($this->dados['ter_codigo'],'Terceiro');


			ValidarCampos::campoVazio($this->dados['ter_codigo']);
			$this->dados['usu_codigo_inclusao'] = $_SESSION['usu_codigo'];

			$data = ValidarDatas::dataBanco($this->dados['dataenvio']);
			$hora = $this->dados['horaenvio'];

			$this->dados['sot_data_inclusao'] = $data .' '. $hora;

			/*			$this->dados['sot_descriacao_inclusao'] = 'Teste de Criacao';*/

			ValidarCampos::campoVazio($this->dados['sot_descricao_inclusao'],'Descri��o');

			$this->dados['sot_data_criacao_inclusao'] = date('Y-m-d H:i:s');

			$tbSolicitacaoTerceiro = new TbSolicitacaoTerceiro();
			$SolicitacaoTerceiro = $tbSolicitacaoTerceiro->getChamadoInTerceiro($this->dados['sol_codigo']);

			if($SolicitacaoTerceiro['sot_status'] == 'S'){
				throw new Exception('Esse chamado esta em poder de terceiro!',300);
			}

			try {

				$tbSolicitacaoTerceiro->insert($this->dados);

			} catch (PDOException $e) {
				throw new PDOException($e->getMessage(), $e->getCode());
			}

		} catch (Exception $e) {
			throw new Exception($e->getMessage(), $e->getCode());
		}

	}


	public function cadastrarSolicitacaoAcesso()
	{
		$dados['pro_codigo'] = 513; //Codigo do problema usado na abertuda de chamado (Manutencao de usuarios
		$dados['dep_codigo'] = $_SESSION['dep_codigo']; //Departamento solicitante
		$dados['sol_descricao_solicitacao'] = 'Solicita��o de Acesso '.$this->dados['observacao']; //Descricao da solicitacao
		$dados['usu_codigo_solicitante'] = $_SESSION['usu_codigo']; //Codigo do usuarios que esta criando a solicitacao
		$dados['dep_codigo_solicitado'] = 5; //Departamento que recebera a solicitacao, no caso TI
		$dados['sta_codigo'] = 1; //Status Inicial do chamado.

		try {

			$this->conexao->beginTransaction();

			$tbSolicitacao = new TbSolicitacao();
			$dados['sol_codigo'] = $tbSolicitacao->insert($dados);

			#Grava a data de abertura da solicita??o
			$tbcalculoatendimento = new TbCalculoAtendimento();
			$tbcalculoatendimento->insertCalculoAtendimento($dados);

			$tbSolicitacaoAcesso = new TbSolicitacaoAcesso();


			$dados['sac_formulario'] = serialize($this->dados);

			$sac_codigo = $tbSolicitacaoAcesso->insert($dados);

			$this->conexao->commit();


			$email = new Email();
			$dados['Solicitante'] = true;
			$dados['Departamento'] = true;
			$email->aberturaChamado($dados);

			return $sac_codigo;

		}catch (\PDOException $e){
			$this->conexao->rollBack();
			throw new \PDOException($e->getMessage(), $e->getCode());
		}

	}

	public function cadastrarFaseProjeto()
	{

		try{

			ValidarCampos::campoVazio($this->dados['fas_descricao']);

			try{

				$tbFaseProjeto = new TbFaseProjeto();

				$tbFaseProjeto->insert($this->dados);

			}catch (\PDOException $e){
				throw new \PDOException($e->getMessage(), $e->getCode());
			}


		}catch (\Exception $e){
			throw new \Exception($e->getMessage(), $e->getCode());
		}

	}

	public function cadastrarUsuarioProjeto()
	{

		try{

			ValidarCampos::campoVazio($this->dados['usu_codigo_integrante']);
			ValidarCampos::campoVazio($this->dados['pro_codigo']);

			$this->dados['usu_codigo_criador'] = $_SESSION['usu_codigo'];

			try{

				$tbUsuarioProjeto = new TbUsuarioProjeto();

				if($tbUsuarioProjeto->getUserProjetoValidade($this->dados) >= 1){
					throw new \Exception('J� existe este usu�rio adcionado ao projeto.');
				}

				$tbUsuarioProjeto->insert($this->dados);

			}catch (\PDOException $e){
				throw new \PDOException($e->getMessage(), $e->getCode());
			}


		}catch (\Exception $e){
			throw new \Exception($e->getMessage(), $e->getCode());
		}

	}


	public function cadastrarApontamentoProjeto()
	{

		try{

			ValidarCampos::campoVazio($this->dados['ap_descricao'],'Descricao do apontamento');
			ValidarCampos::campoVazio($this->dados['pro_codigo']);

			$this->dados['usu_codigo'] = $_SESSION['usu_codigo'];

			$tbAtividade = new TbAtividade();

			$quantidade = $tbAtividade->validateQtdAtividadeEmAndamento($this->dados['pro_codigo']);

			if(($this->dados['stp_codigo'] != 2) and ($quantidade != 0)){
				throw new Exception('Existem atividades em andamento, o projeto n�o pode ser concluido.');
			}

			try{

				$tbApontamentoProjeto = new TbApontamentoProjeto();
				$tbProjeto = new TbProjeto();

				$this->conexao->beginTransaction();

				#Inseri apontamento.
				$tbApontamentoProjeto->insert($this->dados);
				#atualiza o status do projeto.
				$tbProjeto->updateStatusProjeto($this->dados);


				$DataProjeto = $tbProjeto->getInicioFimProjeto($this->dados['pro_codigo']);


				if(($DataProjeto['pro_data_inicio'] == '') and ($this->dados['stp_codigo'] == 2)){

					$this->dados['pro_data_inicio'] = date('Y-m-d');
					$tbProjeto->updateDataInicio($this->dados);
				}


				if(($DataProjeto['pro_data_final'] == '') and ($this->dados['stp_codigo'] == 4)){

					$this->dados['pro_data_final'] = date('Y-11-d');
					$tbProjeto->updateDataFinal($this->dados);
				}


				$this->conexao->commit();

			}catch (\PDOException $e){
				$this->conexao->rollBack();
				throw new \PDOException($e->getMessage(), $e->getCode());
			}


		}catch (\Exception $e){
			throw new \Exception($e->getMessage(), $e->getCode());
		}

	}


	public function cadastrarAtaReuniao()
	{

		//$this->dados['ata_codigo'];
		$this->dados['pro_codigo_projeto'] = $this->dados['pro_codigo'];
		$this->dados['usu_codigo_criador'] = $_SESSION['usu_codigo'];
		//$this->dados['ata_data_criacao'];
		$this->dados['form_ata_reuniao'] = serialize($this->dados);

		$tbAtaReuniao = new TbAtaReuniao();

		try {

			$tbAtaReuniao->insert($this->dados);
		}catch (\PDOException $e){
			throw new \PDOException($e->getMessage(), $e->getCode());
		}

	}

	public function cadastrarAnexoProjeto($file)
	{

		$upload = new FileUpload();

		$pro_codigo = base64_decode($this->dados['pro_codigo']);

		$Dir = new DirectoryCreate();
		$Dir->createDirProjetos($pro_codigo);

		$erro = $upload->setFile($file['arquivo']['tmp_name'])
			->setDestination(FileUpload::PATH.FileUpload::PROJETOS.$pro_codigo.'/'.$file['arquivo']['name'])
			->moveUploaded()
			->getErro();



		$dados['usuario'] = $_SESSION['usu_nome'].' '.$_SESSION['usu_sobrenome'];
		$dados['arquivo'] = $file['arquivo']['name'];
		$dados['acao'] = 'Envio';
		$dados['tipo'] = 'Projetos';
		$dados['codigo'] = $pro_codigo;


		$log = new LogUpload();

		try {

			$log->insert($dados);

		}catch (\PDOException $e){
			throw new \PDOException($e->getMessage(), $e->getCode());
		}

	}


	public function cadastrarAnexoRNC($file)
	{

		$upload = new FileUpload();

		$nc_codigo = base64_decode($this->dados['nc_codigo']);

		$Dir = new DirectoryCreate();
		$Dir->createDirRnc($nc_codigo);

		$erro = $upload->setFile($file['arquivo']['tmp_name'])
			->setDestination(FileUpload::PATH.FileUpload::RNC.$nc_codigo.'/'.$file['arquivo']['name'])
			->moveUploaded()
			->getErro();



		$dados['usuario'] = $_SESSION['usu_nome'].' '.$_SESSION['usu_sobrenome'];
		$dados['arquivo'] = $file['arquivo']['name'];
		$dados['acao'] = 'Envio';
		$dados['tipo'] = 'RNC';
		$dados['codigo'] = $nc_codigo;


		$log = new LogUpload();

		try {

			$log->insert($dados);

		}catch (\PDOException $e){
			throw new \PDOException($e->getMessage(), $e->getCode());
		}

	}


	public function cadastrarVerificacaoRnc()
	{

		try{


			ValidarCampos::campoVazio($this->dados['nc_codigo'],'Codigo Obrigatorio');
			ValidarCampos::campoVazio($this->dados['efi_codigo'],'Eficaz');
			ValidarCampos::campoVazio($this->dados['ver_encerrado'],'Encerrar NC');
			ValidarCampos::campoVazio($this->dados['ver_parecer_qualidade'],'Parecer qualidade');

			$this->dados['efi_codigo_eficaz'] = $this->dados['efi_codigo'];
			$this->dados['ver_data_resposta'] = date('Y-m-d H:i:s');
			$this->dados['usu_codigo_criador'] = $_SESSION['usu_codigo'];
			//$this->dados['ver_encerrado'] = 1;

			$this->dados['nc_previsao_encerramento'] =
				($this->dados['nc_previsao_encerramento'] == '') ? date('Y-m-d') :
					date('Y-m-d',strtotime(str_replace('/','-',$this->dados['nc_previsao_encerramento'])));


			if($this->dados['ver_encerrado'] == 1){
				$this->dados['snc_codigo'] = 4;
			}else{
				$this->dados['snc_codigo'] = 3;
			}


			try{

				$this->conexao->beginTransaction();

				$tbRncVerificacao = new TbRncVerificacao();
				$tbRncVerificacao->insert($this->dados);

				$tbRnc = new TbCadastroRnc();
				$tbRnc->updateVerificacao($this->dados);

				$this->conexao->commit();

			}catch (\PDOException $e){

				$this->conexao->rollBack();

				throw new \PDOException($e->getMessage(), $e->getCode());
			}


		}catch (\Exception $e){
			throw new \Exception($e->getMessage(), $e->getCode());
		}
	}


	public function cadastrarAssociacaoRnc()
	{

		try{

			ValidarCampos::campoVazio($this->dados['nc_codigo'],'RNC');
			ValidarCampos::campoVazio($this->dados['sol_codigo'],'N�mero do chamado');

			try {

				$tbOcorrenciaRnc = new TbOcorrenciaRnc();

				if($tbOcorrenciaRnc->validarOcorrencia($this->dados['sol_codigo']) >= 1){
					throw new \Exception('Este chamado j� est� associado a uma RNC.');
				}

				$tbOcorrenciaRnc->insert($this->dados);


				$tbsolicitacao = new TbSolicitacao();

				if($tbsolicitacao->getStatus($this->dados['sol_codigo']) == 2){

					$tbrnc = new TbCadastroRnc();

					$tbassentamento = new TbAssentamento();

					//Inicia a transacao
					$this->conexao->beginTransaction();

					//Recupera o codigo da NC gerado
					$dadosRnc= $tbrnc->getFormRnc($this->dados['nc_codigo']);
					$this->dados['sol_codigo'];


					//Coloca o problema indicado na RNC como problema Tecnico
					$this->dados['pro_codigo_tecnico'] = $dadosRnc['pro_codigo_tecnico_rnc'];


					$this->dados['usu_codigo'] = $_SESSION['usu_codigo'];
					$this->dados['ass_descricao'] = 'Este chamado esta sendo encerrado devido a associa��o � RNC '
						. $tbrnc->getNumberRncFormatado($this->dados['nc_codigo']) .'.';

					$tbassentamento->insert($this->dados);


					//Altera o status do chamado para FECHADO (3)
					$this->dados['sta_codigo'] = 3;
					$tbsolicitacao->alterarStatus($this->dados);

					#Instancia da Classe CalculoAtendimento
					$tbcalculoatendimento = new TbCalculoAtendimento();

					$tbcalculoatendimento->insertCalculoAtendimento($this->dados);

					$this->conexao->commit();

					//Pega todos os arquivos que houver no chamado e coloca na RNC
					$fileCopy = new FileCopy();
					$fileCopy->setChamado($this->dados['sol_codigo'])
						->setRnc($this->dados['nc_codigo'])
						->copyChamadoToRnc();

					$email = new Email();
					$this->dados['Solicitante'] = true;
					$this->dados['Departamento'] = true;
					$email->interacaoAssentamento($this->dados);

				}


			}catch (\PDOException $e){
				throw new \PDOException($e->getMessage(), $e->getCode());
			}

		}catch (\Exception $e) {
			throw new \Exception($e->getMessage(), $e->getCode());
		}
	}


	public function cadastrarAnexoMelhoria($file)
	{

		$upload = new FileUpload();

		$som_codigo = base64_decode($this->dados['som_codigo']);

		$Dir = new DirectoryCreate();
		$Dir->createDirMelhoria($som_codigo);

		$erro = $upload->setFile($file['arquivo']['tmp_name'])
			->setDestination(FileUpload::PATH.FileUpload::MELHORIA.$som_codigo.'/'.$file['arquivo']['name'])
			->moveUploaded()
			->getErro();



		$dados['usuario'] = $_SESSION['usu_nome'].' '.$_SESSION['usu_sobrenome'];
		$dados['arquivo'] = $file['arquivo']['name'];
		$dados['acao'] = 'Envio';
		$dados['tipo'] = 'MELHORIA';
		$dados['codigo'] = $som_codigo;


		$log = new LogUpload();

		try {

			$log->insert($dados);

		}catch (\PDOException $e){
			throw new \PDOException($e->getMessage(), $e->getCode());
		}

	}


	public function cadastrarAnexoChamado($file)
	{

		$upload = new FileUpload();

		$sol_codigo = base64_decode($this->dados['sol_codigo']);

		$Dir = new DirectoryCreate();
		$Dir->createDirChamados($sol_codigo);

		$erro = $upload->setFile($file['arquivo']['tmp_name'])
			->setDestination(FileUpload::PATH.FileUpload::CHAMADOS.$sol_codigo.'/'.$file['arquivo']['name'])
			->moveUploaded()
			->getErro();

		$dados['usuario'] = $_SESSION['usu_nome'].' '.$_SESSION['usu_sobrenome'];
		$dados['arquivo'] = $file['arquivo']['name'];
		$dados['acao'] = 'Envio';
		$dados['tipo'] = 'CHAMADO';
		$dados['codigo'] = $sol_codigo;

		$log = new LogUpload();

		try {

			$log->insert($dados);

		}catch (\PDOException $e){
			throw new \PDOException($e->getMessage(), $e->getCode());
		}

	}


	#Cadastrar Vers�o
	public function cadastrarVersao()
	{

		try {
			ValidarCampos::campoVazio($this->dados['sis_codigo'], 'Sistema');
			ValidarCampos::campoVazio($this->dados['vso_versao'], 'Versao');
			ValidarCampos::campoVazio($this->dados['vso_data'], 'Data');
			ValidarCampos::campoVazio($this->dados['vso_aprovador'], 'Aprovado Por');
			ValidarCampos::campoVazio($this->dados['vso_novas_instalacoes'], 'Novas Instala��es');
			//ValidarCampos::campoVazio($this->dados['vso_obs'], 'Observa��es');
			$this->dados['usu_codigo'] = $_SESSION['usu_codigo'];
			$this->dados['vso_data'] = ValidarDatas::dataBanco($this->dados['vso_data']);

			$tbControleVersao = new TbControleVersao();
			$tbControleVersao->insert($this->dados);

			$email = new Email();
			/* $this->dados['UsuarioChave'] = true;
			$this->dados['Departamento'] = true; */
			$email->emailControleVersao($this->dados);

		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}


	#Cadastrar Avalicao de chamado
	public function cadastrarAvaliacao()
	{

		try {

			ValidarCampos::campoVazio($this->dados['sol_codigo'], 'Chamado');
			ValidarCampos::campoVazio($this->dados['avaliacao_id'], 'Avalia��o');

			if($this->dados['avaliacao_id'] == 3) {
				ValidarCampos::campoVazio($this->dados['avaliacao_descricao'], 'Justificativa');
			}

			$solicitacao = new TbSolicitacao();
			$solicitacao->createAvaliacao($this->dados);

		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}


}

?>