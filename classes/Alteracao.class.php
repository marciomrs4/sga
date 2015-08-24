<?php
class Alteracao extends Dados
{

	public function alterarUsuario()
	{
		try
		{
			ValidarCampos::campoVazio($this->dados['usu_nome'],'Nome');
			ValidarCampos::campoVazio($this->dados['usu_sobrenome'],'Sobrenome');

			ValidarString::validarEmail($this->dados['usu_email'],'E-mail');

			ValidarCampos::campoVazio($this->dados['usu_ramal'],$_SESSION['config']['ramal']);
			ValidarCampos::campoVazio($this->dados['dep_codigo'],'Departamento');
			ValidarCampos::campoVazio($this->dados['tac_codigo'],'Tipo de Acesso');


			$tbusuario = new TbUsuario();

			$tbusuario->update($this->dados);

		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}

	public function alterarUsuarioSenha()
	{
		try
		{
			ValidarCampos::campoVazio($this->dados['ace_usuario'],$_SESSION['config']['usuario']);
			ValidarCampos::campoVazio($this->dados['ace_senha'],$_SESSION['config']['senha']);
			ValidarCampos::campoVazio($this->dados['ace_senha2'],'Repetir '.$_SESSION['config']['senha']);

			ValidarCampos::compararCampos($this->dados['ace_senha'],$this->dados['ace_senha2'],$_SESSION['config']['senha'].' e Repetir '.$_SESSION['config']['senha']);

			ValidarCampos::validarQtdCaracter($this->dados['ace_senha'],6,$_SESSION['config']['senha']);
			
			$this->dados['ace_ativo'] = ($this->dados['ace_ativo'] == '') ? 'N' : 'S'; 

			$this->dados['ace_senha'] = Validacao::hashSenha($this->dados['ace_senha']);

			$tbacesso = new TbAcesso();
			$tbacesso->update($this->dados);

		} catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}

	public function alterarMinhaSenha()
	{
		try
		{

			ValidarCampos::campoVazio($this->dados['ace_senha'],$_SESSION['config']['senha']);
			ValidarCampos::campoVazio($this->dados['ace_senha2'],'Repetir '.$_SESSION['config']['senha']);

			ValidarCampos::compararCampos($this->dados['ace_senha'],$this->dados['ace_senha2'],$_SESSION['config']['senha'].' e Repetir '.$_SESSION['config']['senha']);

			ValidarCampos::validarQtdCaracter($this->dados['ace_senha'],6,$_SESSION['config']['senha']);

			$this->dados['ace_senha'] = Validacao::hashSenha($this->dados['ace_senha']);

			$tbacesso = new TbAcesso();
			$tbacesso->alterarMinhaSenha($this->dados);

		} catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}


	public function alterarDepartamento()
	{
		try
		{
			ValidarCampos::campoVazio($this->dados['dep_descricao'],'Departamento');
			ValidarCampos::campoVazio($this->dados['dep_email'],'E-mail');

			ValidarString::validarEmail($this->dados['dep_email'],'E-mail');

            ValidarCampos::campoVazio($this->dados['dep_hora_inicio'],'Hora Inicio');
            ValidarCampos::campoVazio($this->dados['dep_hora_fim'],'Hora Fim');
            ValidarCampos::campoVazio($this->dados['dep_hora_almoco'],'Hora de almoзo');
            ValidarCampos::campoVazio($this->dados['dep_carga_sabado'],'Carga Horбrio de Sбbado');

			$tbdepartamento = new TbDepartamento();

			$tbdepartamento->update($this->dados);

		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}


	public function aprovarProjeto($pro_codigo)
	{
		$this->dados['pro_codigo'] = $pro_codigo;

		try
		{
			$tbprojeto = new TbProjeto();

			$tbprojeto->aprovarProjeto($this->dados);

		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}

	public function alterarProjeto()
	{
		try
		{
			ValidarCampos::campoVazio($this->dados['pro_titulo'],'Titulo');
			ValidarCampos::campoVazio($this->dados['pro_descricao'],'Descriзгo');
			ValidarCampos::campoVazio($this->dados['pro_previsao_inicio'],'Previsгo Inicio');
			ValidarCampos::campoVazio($this->dados['pro_previsao_fim'],'Previsгo Fim');

			$this->dados['pro_previsao_inicio'] = ValidarDatas::dataBanco($this->dados['pro_previsao_inicio']);
			$this->dados['pro_previsao_fim'] = ValidarDatas::dataBanco($this->dados['pro_previsao_fim']);

			#Verifica se existe atividade em andamento
			$tbAtividade = new TbAtividade();
			$quantidade = $tbAtividade->validateQtdAtividadeEmAndamento($this->dados['pro_codigo']);

			if(($this->dados['stp_codigo'] != 2) and ($quantidade != 0)){
				throw new Exception('Existe atividade em andamento: Este projeto nгo pode ser alterado');
			}
			
			$tbprojeto = new TbProjeto();

			$tbprojeto->update($this->dados);

		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}


	public function alterarMeuTempo()
	{
		try
		{
			ValidarCampos::campoVazio($this->dados['tat_descricao'],'Tempo de Atendimento');

			$tbtempoatendimento = new TbTempoAtendimento();
			$tbtempoatendimento->update($this->dados);

		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}

	}

	public function alterarPrioridade()
	{
		try
		{
			ValidarCampos::campoVazio($this->dados['pri_descricao'],'Prioridade');
			ValidarCampos::campoVazio($this->dados['tat_codigo'],'Tempo de Atendimento');
				
			ValidarCampos::campoVazio($this->dados['dep_codigo_prioridade'],'Tempo de Atendimento');

			$this->dados['dep_codigo'] = $this->dados['dep_codigo_prioridade'];
				

			$tbprioridade = new TbPrioridade();
			$tbprioridade->update($this->dados);

		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}

	public function alterarProblema()
	{
		try
		{
			ValidarCampos::campoVazio($this->dados['pro_descricao'],'Descricao');
			ValidarCampos::campoVazio($this->dados['pri_codigo'],'Prioridade');
			ValidarCampos::campoVazio($this->dados['dep_codigo_problema'],'Departamento');
			
			$this->dados['pro_mostrar_usuario'] = ValidarCampos::campoEmptyTernario($this->dados['pro_mostrar_usuario'],1,'');
			$this->dados['pro_status_ativo'] = ValidarCampos::campoEmptyTernario($this->dados['pro_status_ativo'],1,'');
			
			
			ValidarCampos::campoVazio($this->dados['pro_tempo_solucao'],'Tempo de Soluзгo');

			$this->dados['dep_codigo'] = $this->dados['dep_codigo_problema'];

			$tbproblema = new TbProblema();
			$tbproblema->update($this->dados);

		} catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}

	public function alterarStatus()
	{
		try
		{
			ValidarCampos::campoVazio($this->dados['sta_descricao'],'Status');

			$tbstatus = new TbStatus();
			$tbstatus->update($this->dados);

		} catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}

	public function alterarEncaminharSolicitacao()
	{
		try
		{
			ValidarCampos::campoVazio($this->dados['usu_codigo_atendente'],'Encaminhar para');


			$tbsolicitacao = new TbSolicitacao();
			$tbsolicitacao->updateEncaminharExecutor($this->dados);

		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}

	}

	/**
	 *
	 * Usadao para alterar a solicita??o...
	 * @throws Exception
	 */
	public function alterarSolicitacao($file)
	{
		try
		{
			ValidarCampos::campoVazio($this->dados['dep_codigo'],'Departamento');
			ValidarCampos::campoVazio($this->dados['pro_codigo'],$_SESSION['config']['problema']);
			ValidarCampos::campoVazio($this->dados['sol_descricao_solicitacao'],'Descri??o do '.$_SESSION['config']['problema']);
			$this->dados['sol_descricao_solicitacao'] = strip_tags($this->dados['sol_descricao_solicitacao']);
			ValidarCampos::validarQtdCaracter($this->dados['sol_descricao_solicitacao'],10,'Descriзгo do '.$_SESSION['config']['problema']);

			#Capturando o c?digo do DEPTO solicitado
			$this->dados['dep_codigo_solicitado'] = $this->dados['dep_codigo'];

			try
			{
				$this->conexao->beginTransaction();

			if($file['tmp_name'] != '')
			{
					
				$tbanexo = new TbAnexo();
				$tbarquivo = new Arquivo();

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


				if($tbanexo->confirmarAnexo($this->dados['sol_codigo']))
				{
					$tbanexo->update($this->dados);

				}else
				{
					$tbanexo->insert($this->dados);
				}
			}


			$tbsolicitacao = new TbSolicitacao();
			$tbsolicitacao->update($this->dados);
			
			$this->conexao->commit();

			}catch (PDOException $e)
			{
				$this->conexao->rollBack();
				throw new PDOException($e->getMessage(), $e->getCode());
			}
			
		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}

	public function alterarAtendimentoSolicitacao()
	{

		try
		{

			ValidarCampos::campoVazio($this->dados['sol_descricao_solucao'],'Descriзгo da Soluзгo');
			ValidarCampos::validarQtdCaracter($this->dados['sol_descricao_solucao'],10,'Descriзгo da Soluзгo');

			ValidarCampos::campoVazio($this->dados['sta_codigo'],'Status');

			$this->dados['sol_datafechamento'] = date('Y-m-d');

			$tbsolicitacao = new TbSolicitacao();
			$tbsolicitacao->updateAtendimento($this->dados);

		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}

	}

	public function alterarAprovarSolicitacao($usu_codigo_gerencia)
	{

		$this->dados['usu_codigo_gerencia'] = $usu_codigo_gerencia;

		try
		{

			$tbsolicitacao = new TbSolicitacao();
			$tbsolicitacao->updateAprovarSolicitacao($this->dados);

		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}

	}

	public function alterarLayout($usu_codigo)
	{

		$layout = new TbLayout();
		$this->dados['usu_codigo'] = $usu_codigo;

		try
		{
			if($this->dados['cadastrar'] == '')
			{
				$layout->updateLayoutDefault($usu_codigo);

			}else
			{
				$layout->updateLayout($this->dados);
			}


		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}

	public function alterarAtenderChamado($sol_codigo)
	{
		try
		{

			$tbatendentesol = new TbAtendenteSolicitacao();

			$atendente = $tbatendentesol->confirmarAtendente($sol_codigo);

			try
			{

					
				if($atendente)
				{
					throw new Exception('Jб existe um atendente para a ocorrкncia','300');
				}else
				{

					try
					{
						$tbsolicitacao = new TbSolicitacao();
						$tbproblema = new TbProblema();

						#Inicia a transa??o
						$this->conexao->beginTransaction();

						#Pega o codigo do problema da solicitacao
						$pro_codigo = $tbsolicitacao->getProblema($sol_codigo);
						#Com o codigo do problema eu pego o codigo da prioridade para
						#Colocar na tabela de atendente
						$pri_codigo = $tbproblema->getPrioridade($pro_codigo);

						$this->dados['usu_codigo_atendente'] = $_SESSION['usu_codigo'];
						$this->dados['sol_codigo'] = $sol_codigo;
						$this->dados['pri_codigo'] = $pri_codigo;
						#Insere na tabela de atendente_solicitacao quem esta atedendendo
						$tbatendentesol->insert($this->dados);

						#Obtem o problema cadastrado do usuario para atender. 
						$this->dados['pro_codigo_tecnico'] = $tbsolicitacao->getProblema($this->dados['sol_codigo']);
						
						
						#Altera o status da solicitacao para "Em atendimento"
						$this->dados['sta_codigo'] = 2;
						$tbsolicitacao->alterarStatus($this->dados);

						#Grava a altera??o no Calculo de Atendimento
						$tbcalculoatendimento = new TbCalculoAtendimento();
						$tbcalculoatendimento->insertCalculoAtendimento($this->dados);
						
						$tbassentamento = new TbAssentamento();
						$this->dados['ass_descricao'] = 'Em atendimento';
						$this->dados['usu_codigo'] = $_SESSION['usu_codigo'];
						$tbassentamento->insert($this->dados);

						#Faz commit no banco caso sucesso
						$this->conexao->commit();
						
						#Enviando e-mail quando atender chamado
						$email = new Email();
						$email->interacaoAssentamento($this->dados);
						

					}catch (PDOException $e)
					{
						#Faz Rollback em caso de falha
						$this->conexao->rollBack();

						throw new PDOException($e->getMessage(), $e->getCode());
					}
				}

			}catch (Exception $e)
			{
				throw new Exception($e->getMessage(),$e->getCode());
			}


		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}

	}


	public function alterarChecklist()
	{
		try
		{
			ValidarCampos::campoVazio($this->dados['che_titulo'],'Titulo');
			ValidarCampos::campoVazio($this->dados['che_email_envio'],'E-mail de Envio');
			ValidarCampos::campoVazio($this->dados['che_descricao'],'Descri??o');
			ValidarCampos::campoVazio($this->dados['dep_codigo'],'Departamento');

			ValidarString::validarEmail($this->dados['che_email_envio'],'E-mail com sintaxe incorreta');

			$this->dados['usu_codigo'] = $_SESSION['usu_codigo'];

			try
			{

				#Instancia do obj
				$tbchecklist = new TbChecklist();

				if($this->dados['alterar'])
				{
					#Atualiza
					$tbchecklist->update($this->dados);
					#Atualiza o Dia da semana
					$tbDiaSemana = new TbDiaSemanaCheckList();
					$tbDiaSemana->update($this->dados);
						
				}else
				{
					#Delete caso contario
					$tbchecklist->delete($this->dados['che_codigo']);
				}

			} catch (PDOException $e)
			{
				throw new PDOException($e->getMessage(), $e->getCode());
			}

		} catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}

	public function alterarItemChecklist($file)
	{

		if($this->dados['alterar'])
		{

			try
			{

				ValidarCampos::campoVazio($this->dados['ich_titulo_tarefa'],'Tarefa');
				//ValidarCampos::campoVazio($this->dados['ich_link'],'');
				//$this->dados['ich_ativo']

				try
				{
					$this->conexao->beginTransaction();

					$tbitemcklist = new TbItemChecklist();
					$tbitemcklist->update($this->dados);
					
					$tbDiaSemana = new TbDiaSemana();
					$tbDiaSemana->update($this->dados);

					if($file['tmp_name'] != '')
					{
						#Instancia da classe Arquivo que manipula os aquivos
						$arquivo = new Arquivo();
						#Metodo setDados que serve para setar o $file que contm todo o arquivo
						$arquivo->setDados($file);
						/*
						 * Capturando os dados do arquivo
						 */
						$this->dados['ane_anexo'] = $arquivo->arquivoBinario();
						$this->dados['ane_nome'] = $arquivo->arquivoNome();
						$this->dados['ane_tamanho'] = $arquivo->arquivoTamanho();
						$this->dados['ane_tipo'] = $arquivo->arquivoTipo();

						#Instancia a classe de Anexo do CheckList
						$tbanexocklist = new TbAnexoCheckList();
							
						#Verifica se existe um anexo pra esste item
						if($this->dados['ane_codigo'])
						{
							#Se j? existe, altera o anexo do checklist
							$tbanexocklist->update($this->dados);
						}else
						{
							#Se n?o existe, grava o anexo do checklist
							$tbanexocklist->insert($this->dados);
						}
							
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

		}else
		{
			try
			{
			$tbitemcklist = new TbItemChecklist();
			$tbitemcklist->delete($this->dados['ich_codigo']);
			}catch (PDOException $e)
			{
				throw new PDOException($e->getMessage(), $e->getCode());
			}
		}

	}
	
	public function alterarAtividade()
	{
		try
		{

			ValidarCampos::campoVazio($this->dados['pro_codigo'],'Projeto');
			ValidarCampos::campoVazio($this->dados['usu_codigo_responsavel'],$_SESSION['config']['usuario'].' Executor');
			ValidarCampos::campoVazio($this->dados['at_previsao_inicio'],'Previsгo Inicio');
			ValidarCampos::campoVazio($this->dados['at_previsao_fim'],'Previsгo Fim');
			ValidarCampos::campoVazio($this->dados['at_descricao'],'Descriзгo');
			

			$this->dados['at_previsao_inicio'] = ValidarDatas::dataBanco($this->dados['at_previsao_inicio']);
			$this->dados['at_previsao_fim'] = ValidarDatas::dataBanco($this->dados['at_previsao_fim']);
			
			$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? 1 : $this->dados['sta_codigo'];

			try
			{
					
				$this->conexao->beginTransaction();
				
				$tbProjeto = new TbProjeto();
				
				$status = $tbProjeto->getStatusProjeto($this->dados['pro_codigo']);
				
				if($status != 2)
				{
					throw new Exception('Nгo й possнvel alterar essa atividade: Este projeto nгo esta em andamento');
				}else
				{
	
					$tbAtividade = new TbAtividade();
					$tbAtividade->update($this->dados);
					
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

	public function alterarUsuarioAtividade()
	{

		try
		{


			ValidarCampos::campoVazio($this->dados['usu_codigo'],$_SESSION['config']['usuario']);
			ValidarCampos::campoVazio($this->dados['tua_codigo'],'Tipo de '.$_SESSION['config']['usuario']);
			
			try 
			{
				$this->conexao->beginTransaction();
				
				$tbUsuarioAtividade = new TbUsuarioAtividade();
				
				
				if($this->dados['alterar'])
				{
					$tbUsuarioAtividade->update($this->dados);
				}else
				{
					$tbUsuarioAtividade->delete($this->dados);
				}
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
	
	
	public function alterarAniversario()
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

			$tbAniversariante = new TbAniversariante();

			try
			{
				if($this->dados['alterar'])
				{

					$tbAniversariante->update($this->dados);
										
				}else
				{
					$tbAniversariante->delete($this->dados['ani_codigo']);

				}
				
			}catch (PDOException $e)
			{
				throw new PDOException($e->getMessage(), $e->getCode());
			}
			
			
		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}
		
		
	}
	
	
	public function alterarSolicitacaoMelhoria()
	{
	
		$tbMelhoria = new TbSolicitacaoMelhoria();
		
		if($tbMelhoria->getUsuarioAtendente($this->dados['som_codigo'])){
			throw new Exception('Impossivel alterar! J? existe um atendente');
		}
		
		if($tbMelhoria->getUsuarioSolicitante($this->dados['som_codigo']) != $_SESSION['usu_codigo']){
			throw new Exception('Impossivel alterarar Vocк nгo й o criador da solicitaзгo');
		}
		
		
		
		try
		{
	
			ValidarCampos::campoVazio($this->dados['sis_codigo'],'Sistema');
			ValidarCampos::campoVazio($this->dados['som_descricao'],'Descricao');
	
	
			try
			{
					
				$tbMelhoria->update($this->dados);
	
			}catch (PDOException $e)
			{
				throw new PDOException($e->getMessage(), $e->getCode());
			}
	
	
		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}
	
	
	}
	
	public function alterarAtenderSolicitacaoMelhoria($som_codigo)
	{
		
		try
		{
					
			$tbMelhoria = new TbSolicitacaoMelhoria();	
			$tbApontamentoMelhoria = new TbApontamentoMelhoria();
			
			/**
			 *Atender melhoria
			 */
			$this->dados['usu_codigo_atendente'] = $_SESSION['usu_codigo'];
			$this->dados['som_codigo'] = $som_codigo;
			$this->dados['stm_codigo'] = 2;
			
			$tbMelhoria->updateAtenderMelhoria($this->dados);
			
			$this->dados['usu_codigo'] = $_SESSION['usu_codigo'];
			$this->dados['apm_descricao'] = 'Em Atendimento';
			/**
			 * Criar o apontamento da melhoria
			 */
			$tbApontamentoMelhoria->insert($this->dados);
	
		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}	
	
	}
	
	
	public function alterarSistema()
	{
	
		try {
				
			ValidarCampos::campoVazio($this->dados['sis_descricao'],'Sistema');
			ValidarCampos::campoVazio($this->dados['usu_codigo_usuario_chave'],'Usuбrio chave');
				
			$this->dados['sis_status'] = 1;
				
			try {
	
				$tbSistema = new TbSistemas();
					
				$tbSistema->update($this->dados);
	
			} catch (PDOException $e) {
				throw new PDOException($e->getMessage(), $e->getCode());
			}
				
		} catch (Exception $e) {
			throw new Exception($e->getMessage(), $e->getCode());
		}
	
	}

	public function alterarTerceiro()
	{
	
	
		try {
				
			ValidarCampos::campoVazio($this->dados['ter_descricao'],'Descricгo');
			ValidarCampos::campoVazio($this->dados['dep_codigo'],'Deparamento');
				
			$this->dados['ter_status'] = ($this->dados['ter_status'] == '') ? 0 : 1;
				
			try {
	
				$tbTerceiro = new TbTerceiro();
					
				$tbTerceiro->update($this->dados);
	
			} catch (PDOException $e) {
				throw new PDOException($e->getMessage(), $e->getCode());
			}
				
		} catch (Exception $e) {
			throw new Exception($e->getMessage(), $e->getCode());
		}
	
	}

    public function alterarEnvioTerceiro()
    {

        try {

            //Valida se existe o codigo do chamado e o codigo do terceiro
            ValidarCampos::campoVazio($this->dados['sol_codigo'],'Codigo');
            ValidarCampos::campoVazio($this->dados['ter_codigo'],'Terceiro');

            //Verifica se a descricao estб completa
            ValidarCampos::campoVazio($this->dados['sot_descricao_remocao'],'Descricao');

            //Obtem o codigo do usuario da sessao
            $this->dados['usu_codigo_remocao'] = $_SESSION['usu_codigo'];

            //Pega a data do formulario e converte para o formato do banco
            $data = ValidarDatas::dataBanco($this->dados['dataenvio']);
            //pega a hora do formulario
            $hora = $this->dados['horaenvio'];

            //Junta da data e hora para gravar no banco
            $this->dados['sot_data_remocao'] = $data .' '. $hora;

            //Pega a data atual para saber quando foi registrado no banco
            $this->dados['sot_data_criacao_remocao'] = date('Y-m-d H:i:s');

            //Objeto que representa a tabela Solicitacao de terceiro
            $tbSolicitacaoTerceiro = new TbSolicitacaoTerceiro();
            //Pega o chamado para verificar qual o status com terceiro
            $SolicitacaoTerceiro = $tbSolicitacaoTerceiro->getChamadoInTerceiro($this->dados['sol_codigo']);

            if($SolicitacaoTerceiro['sot_status'] == 'N'){
                throw new Exception('Esse chamado esta em poder de terceiro!',300);
            }

            //Pega da data inicial enviado para terceiro e converte em DateTime
            $DataInicial = new DateTime($tbSolicitacaoTerceiro->getDataEnvioTerceiro($this->dados['sot_codigo']));
            //Pega a data final que veio do formulario e converte para DateTime
            $DataFinal = new DateTime($this->dados['sot_data_remocao']);
            //Calcula a diferena entre as Datas
            $diferenca = $DataInicial->diff($DataFinal);
            //Formata a data e armazenada no tempo total para enviar ao Banco de dados
            $this->dados['sot_tempo_total'] = $diferenca->format('%Y-%M-%D %H:%I:%S');


            //Obtem o codigo do departamento do chamado
            $TbSolicitacao = new TbSolicitacao();
            $CodigoDepartamento = $TbSolicitacao->getCodigoDepartamentoSolicitado($this->dados['sol_codigo']);

            //Obtem o tempo de entrada, saida, almoco e sabado do Departamento
            $TbDepartamento = new TbDepartamento();
            $TempoDepartamento = $TbDepartamento->getAllHours($CodigoDepartamento);


            $TempoUtil = new dateOpers();
            $data1 = $tbSolicitacaoTerceiro->getDataEnvioTerceiro($this->dados['sot_codigo']);
            $data2 = $this->dados['sot_data_remocao'];
            //Hora de Inicio do departamento
            $hora_ini = ($TempoDepartamento['dep_hora_inicio'] == '') ? '08' : $TempoDepartamento['dep_hora_inicio'];
            //Hora Fim do departamento
            $hora_fim = ($TempoDepartamento['dep_hora_fim'] == '') ? '18' : $TempoDepartamento['dep_hora_fim'];
            //Hora de almoco departamento
            $meio_dia = ($TempoDepartamento['dep_hora_almoco'] == '') ? '13' : $TempoDepartamento['dep_hora_almoco'];
            //Carga horaria de sabado departamento
            $sabado = ($TempoDepartamento['dep_carga_sabado'] == '') ? '00' : $TempoDepartamento['dep_carga_sabado'];
            //Formato de saida H (em horas)
            $saida = 'H';

            $this->dados['sot_tempo_util'] = $TempoUtil->tempo_valido($data1, $data2, $hora_ini, $hora_fim, $meio_dia, $sabado, $saida);

            //Altera o status da solciitacao para N
            $this->dados['sot_status'] = 'N';


            /*usu_codigo_remocao = ok
            sot_data_remocao = ok
            sot_descricao_remocao = ok
            sot_data_criacao_remocao = ok
            sot_tempo_util
            sot_tempo_total = ok
            sot_status = OK*/



            //$this->listarDados();

            try {

                $tbSolicitacaoTerceiro->updateRemocaoTerceiro($this->dados);

            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), $e->getCode());
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }

    }

}
?>