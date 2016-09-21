<?php
class Email extends PHPMailer
{

	public $mensagem;
	public $cabecalho;

	public $erro;

	public function enviarEmail()
	{
		date_default_timezone_set('America/Sao_Paulo');

		$this->IsSMTP();
		$this->IsHTML();

		$this->Host = '172.22.0.31';

/*
	
*/
		$this->From = 'sga@ceadis.org.br';

		$this->FromName = 'SISTEMA DE GEST�O DE ATIVIDADES';


		$this->Subject = $this->cabecalho;

		$this->Body = $this->mensagem;

		$this->Send();

		$this->erro = $this->ErrorInfo;

	}


	public function setMensagem($mensagem)
	{
		$this->mensagem = $mensagem;
        return $this;
	}

	public function setCabecalho($cabecalho)
	{
		$this->cabecalho = $cabecalho;
        return $this;
	}

	public function aberturaChamado($dados)
	{
		$tbusuario = new TbUsuario();
		$email = $tbusuario->getUsuario($dados['usu_codigo_solicitante']);

		$tbdepartamento = new TbDepartamento();
		$emaildepto = $tbdepartamento->getDepartamentoEmail($dados['dep_codigo_solicitado']);

		$tbprobleama = new TbProblema();
		$problema = $tbprobleama->getForm($dados['pro_codigo']);

				
		$this->cabecalho = 'Abertura de Chamado '.$dados['sol_codigo'];

		$this->mensagem = '<b>O Chamado de n�mero: </b>'.$dados['sol_codigo'].'<br/>';
		$this->mensagem .= '<b>Foi aberto com sucesso por: </b>'.$email['usu_email'].' e logo um t�cnico ir� atende-lo <br/>';
		$this->mensagem .= '<b>Contato:  </b>'.$email['usu_nome'].'<br/>';
		$this->mensagem .= '<b>Tel / '.$_SESSION['config']['ramal'].': </b> '.$email['usu_ramal'].'<br/>';
		$this->mensagem .= '<b>' . $_SESSION['config']['problema'].': </b>'.$problema['pro_descricao'].'<br/><br/>';
		$this->mensagem .= '<b>Descri��o do '.$_SESSION['config']['problema'].': </b>'.$dados['sol_descricao_solicitacao'].'<br/>';
		
		
		#E-mail de envido do usuario
		if($dados['Solicitante'])
		{
			$this->AddAddress($email['usu_email']);
		}
		#E-mail de envio do departamento
		if($dados['Departamento'])
		{
			$this->AddAddress($emaildepto);
		}

		$this->enviarEmail();

	}

	public function interacaoAssentamento($dados)
	{

		#Instancia da Classe TbSolicitacao
		$tbsolcitacao = new TbSolicitacao();

		#pega o c�digo do solicitante do chamado
		$usuSolicitante = $tbsolcitacao->getUsuarioSolicitante($dados['sol_codigo']);
		
		#pega a descricao da solicitacao que foi feito na abertura do chamado
		$descricaoSolicitacao = $tbsolcitacao->getDescricaoSolicitacao($dados['sol_codigo']);
		
		#Pego e-mail de quem fez o assentamento informa��es do usuarios
		$tbusuario = new TbUsuario();
		$email = $tbusuario->getUsuario($dados['usu_codigo']);
		
		#Pegao o e-mail do solicitante
		$emailSolicitante = $tbusuario->getUsuario($usuSolicitante);

		#Pego informacoes da solicitacao, Codigo do problema
		#Pego o codigo do problema
		$pro_codigo = $tbsolcitacao->getProblema($dados['sol_codigo']);
		#Pego o codigo do DEPTO solicitado
		$dep_codigo_solicitado = $tbsolcitacao->getCodigoDepartamentoSolicitado($dados['sol_codigo']);

		$tbdepartamento = new TbDepartamento();
		$emaildepto = $tbdepartamento->getDepartamentoEmail($dep_codigo_solicitado);

		#Pego a descri��o do problema
		$tbprobleama = new TbProblema();
		$problema = $tbprobleama->getForm($pro_codigo);

		$tbstatus = new TbStatus();
		$sta_descricao = $tbstatus->getDescricao($tbsolcitacao->getStatus($dados['sol_codigo']));

		$this->cabecalho = 'Assentamento do chamado: '.$dados['sol_codigo'];

		$this->mensagem = '<b>Houve uma intera��o no chamado: </b>'.$dados['sol_codigo'].'<br/>';
		$this->mensagem .= '<b>Assentamento criado por: </b>'.$email['usu_email'].'<br/>';
		$this->mensagem .= '<b>' . $_SESSION['config']['problema'].': </b>'.$problema['pro_descricao'].'<br/><br/>';
		$this->mensagem .= '<b>Descri��o do Chamado: </b>'.$descricaoSolicitacao.'<br/><br/>';
		$this->mensagem .= '<b>Foi adicionado o seguinte assentamento: </b>'.$dados['ass_descricao'].'<br/><br/>';
		$this->mensagem .= '<b>Status do chamado: </b>'.$sta_descricao;

		if($tbsolcitacao->getStatus($dados['sol_codigo']) == 3){
			$this->mensagem .= '<br/><br/><b>O chamado foi encerrado, agora voc� pode avalia-lo em:</b><br/>
								Acessando o SGA no menu superior Opera��o ou Chamado e em seguida menu lateral Avalia��o.';
		}
		
		
		#E-mail de envido do usuario
		if($dados['Solicitante'])
		{
			$this->AddAddress($emailSolicitante['usu_email']);
		}
		
		#E-mail de envio do departamento
		if($dados['Departamento'])
		{
			$this->AddAddress($emaildepto);
		}
		
		$this->enviarEmail();

	}

	
	/**
	 * Envio de e-mail para abertura de melhorias
	 */
	public function aberturaMelhoria($dados)
	{
		$tbusuario = new TbUsuario();
		$usuarioSolicitante = $tbusuario->getUsuario($dados['usu_codigo_solicitante']);
		
		
		$tbSistema = new TbSistemas();
		$sistema = $tbSistema->getForm($dados['sis_codigo']);
		
		$usuarioAtendente = $tbusuario->getUsuario($sistema['usu_codigo_usuario_chave']);
		
		
		$this->cabecalho = 'Abertura de melhoria: '.$dados['som_codigo'];
		
		$this->mensagem = '<b>A melhoria de n�mero: </b>'.$dados['som_codigo'].'<br/>';
		$this->mensagem .= '<b>Foi aberto com sucesso por: </b>'.$usuarioSolicitante['usu_email'].' <b> e logo o usu�rio chave ir� atende-lo.</b> <br/>';
		$this->mensagem .= '<b>Contato:  </b>'.$usuarioSolicitante['usu_nome'].'</b><br/>';
        $this->mensagem .= '<b>Tel / '.$_SESSION['config']['ramal'].':</b> '.$usuarioSolicitante['usu_ramal'].'<br/>';
		$this->mensagem .= '<b>Sistema: </b>'.$sistema['sis_descricao'].'<br/><br/>';
		$this->mensagem .= '<b>Descri��o da melhoria: </b>' . $dados['som_descricao'].'<br/>';

		#E-mail do atendente
		$this->AddAddress($usuarioAtendente['usu_email']);

		#E-mail do solicitante
		$this->AddAddress($usuarioSolicitante['usu_email']);
		
		$this->enviarEmail();
	}

	
	/**
	 * Envio de e-mail para apontemantos de melhorias
	 */
	public function apontamentoMelhoria($dados)
	{

		$tbSolicitacaoMelhoria = new TbSolicitacaoMelhoria();
		$Solicitacao = $tbSolicitacaoMelhoria->getForm($dados['som_codigo']);
		
		$tbusuario = new TbUsuario();
		$usuarioSolicitante = $tbusuario->getUsuario($Solicitacao['usu_codigo_solicitante']);
		
		$usuarioAtendente = $tbusuario->getUsuario($Solicitacao['usu_codigo_atendente']);
		
		$usuarioCriador = $tbusuario->getUsuario($dados['usu_codigo']);
		
		$tbSistema = new TbSistemas();
		$sistema = $tbSistema->getForm($Solicitacao['sis_codigo']);
	
		$tbStatusSolicitacao = new TbStatusMelhoria();
		$Status = $tbStatusSolicitacao->getDescricao($dados['stm_codigo']);
		
		$this->cabecalho = 'Apontamento da melhoria: '.$dados['som_codigo'];

		$this->mensagem = '<b>Houve um apontamento no melhoria: </b>'.$dados['som_codigo'].'<br/>';
		$this->mensagem .= '<b>Criado por: </b>'.$usuarioCriador['usu_email'].'<br/>';
		$this->mensagem .= '<b>Sistema: </b>'.$sistema['sis_descricao'].'<br/><br/>';
		$this->mensagem .= '<b>Descri��o do Chamado: </b>'.$Solicitacao['som_descricao'].'<br/><br/>';
		$this->mensagem .= '<b>Foi adicionado o seguinte Apontamento: </b>'.$dados['apm_descricao'].'<br/><br/>';
		$this->mensagem .= '<b>Status do chamado: </b>'.$Status['stm_descricao'];
		
		
		#E-mail de envido para o Atendente
		if($dados['Atendente'])
		{
			$this->AddAddress($usuarioAtendente['usu_email']);
		}
		
		#E-mail de envio para o Solicitante
		if($dados['Solicitante'])
		{
			$this->AddAddress($usuarioSolicitante['usu_email']);
		}
		
		$this->enviarEmail();
		
	}

	/**
	 * @param $dados
	 *
	 * Envio de email para apontamento de atividades
	 */
	public function apontamentoAtividade($dados)
	{

		$at_codigo = $dados['at_codigo'];
		$ap_descricao = $dados['ap_descricao'];
		$sta_codigo = $dados['sta_codigo'];

		$tbAtividade = new TbAtividade();
		$tbProjeto = new TbProjeto();
		$tbUsuario = new TbUsuario();
		$tbStatusAtividade = new TbStatusAtividade();

		$tbUsuarioAtividade = new TbUsuarioAtividade();

		$projeto = $tbAtividade->getProCodigo($at_codigo);

		$projeto = $tbProjeto->getDescricaoProjeto($projeto['pro_codigo']);

		$usuario = $tbUsuario->getUsuario($_SESSION['usu_codigo']);


		$this->cabecalho = "Andamento do projeto: {$projeto['pro_titulo']}";

		$this->mensagem .= '<b>Houve um novo apontamento.</b><br><br>';
		$this->mensagem .= "<b>Titulo do Projeto:</b> {$projeto['pro_titulo']} <br>";
		$this->mensagem .= "<b>N�mero da atividade: </b> {$at_codigo} <br><br>";
		$this->mensagem .= "<b>Criado por: </b>" . $usuario['usu_nome'] .' '. $usuario['usu_sobrenome'] .' | ' . $usuario['usu_email'] . "<br><br>";
		$this->mensagem .= '<b>Descri��o do apontamento:</b> <br>';
		$this->mensagem .= "{$ap_descricao}<br><br>";
		$this->mensagem .= "<b>Status da Atividade: </b> {$tbStatusAtividade->getDescricao($sta_codigo)}";



		if($dados['informados']) {

			foreach ($tbUsuarioAtividade->getEmailUsuarioByInformadoOrConsultado($at_codigo, 1) as $email) {
				$this->AddAddress($email['usu_email']);
			}
		}

		if($dados['consultados']) {
			foreach ($tbUsuarioAtividade->getEmailUsuarioByInformadoOrConsultado($at_codigo, 2) as $email) {
				$this->AddAddress($email['usu_email']);
			}
		}

		if($dados['participantes']) {
			foreach ($tbProjeto->getEmailUsuarioByProjeto($projeto['pro_codigo']) as $email) {
				$this->AddAddress($email['usu_email']);
			}
		}

		$this->enviarEmail();

	}


	/**
	 * @param $dados
	 *
	 * Envio de email para criacao de RNC para o usuario que abriu a ocorrencia
	 */
	public function notificarCriacaoRncReclamente($dados)
	{

		$this->cabecalho = "Cria��o da RNC: {$dados['numero_rnc']}";

		$this->mensagem .= "Informamos que a ocorr�ncia: <b>{$dados['sol_codigo']}</b>";
		$this->mensagem .= " gerou a RNC <b>{$dados['numero_rnc']}.</b> <br>";
		$this->mensagem .= "A mesma foi enviada a �rea respons�vel para tratamento.";

		$tbSolicitacao = new TbSolicitacao();
		$usuarioSolicitante = $tbSolicitacao->getUsuarioSolicitante($dados['sol_codigo']);
		$dep_codigo = $tbSolicitacao->getCodigoDepartamentoSolicitado($dados['sol_codigo']);
		$tbDepartamento = new TbDepartamento();
		$emailDepartamento = $tbDepartamento->getDepartamentoEmail($dep_codigo);

		$tbUsuario = new TbUsuario();
		$dadosUsuario = $tbUsuario->getUsuario($usuarioSolicitante);

		$this->AddAddress($dadosUsuario['usu_email']);
		$this->AddAddress($emailDepartamento);

		$this->enviarEmail();

	}

	/**
	 * @param $dados
	 *
	 * Envio de email para criacao de RNC para o Departamento que responder�
	 */
	public function notificarCriacaoRncDepartamento($dados)
	{

		$tbDepartamento = new TbDepartamento();

		$depDescricao = $tbDepartamento->getDepDescricao($dados['dep_responsavel_codigo']);

		$this->cabecalho = "Cria��o da RNC: {$dados['numero_rnc']}";

		$this->mensagem .= "Informamos que foi gerada a RNC <b>{$dados['numero_rnc']}</b>";
		$this->mensagem .= " para a �rea <b>{$depDescricao}</b> para analise. <br>";
		$this->mensagem .= "Solicitamos o preenchimento do registro em no m�ximo 48 horas da data da abertura.";


		$tbSolicitacao = new TbSolicitacao();
		$dep_codigo = $tbSolicitacao->getCodigoDepartamentoSolicitado($dados['sol_codigo']);
		$tbDepartamento = new TbDepartamento();
		$emailDepartamentoResponsavel = $tbDepartamento->getDepartamentoEmail($dep_codigo);


		$emailDepartamentoRespondedor = $tbDepartamento->getDepartamentoEmail($dados['dep_responsavel_codigo']);

		$this->AddAddress($emailDepartamentoResponsavel);
		$this->AddAddress($emailDepartamentoRespondedor);

		$this->enviarEmail();

	}

	/**
	 * @param $dados
	 *
	 * Envio de email para criacao de resposta da RNC da area para o Departamento qualidade
	 */
	public function notificarRespostaRncGestor($dados)
	{


		$tbUsuario = new TbUsuario();

		$dadosUsuario = $tbUsuario->getUsuario($dados['usu_codigo_repondedor']);

		$this->cabecalho = "Resposta da RNC: {$dados['numero_rnc']}";

		$this->mensagem .= "A RNC <b>{$dados['numero_rnc']}</b>";
		$this->mensagem .= " foi respondida pelo usu�rio(a) <b>{$dadosUsuario['usu_nome']} {$dadosUsuario['usu_sobrenome']}.</b> <br>";
		$this->mensagem .= "Aguardando valida��o da qualidade.";


		$this->AddAddress($dadosUsuario['usu_email']);
		$this->AddAddress('qualidade@ceadis.org.br');

		$this->enviarEmail();

	}


	public function emailControleVersaoEdicao($dados)
	{
		$tbSistema = new TbSistemas();
		$sistema = $tbSistema->getForm($dados['sis_codigo']);


		#Pego e-mail do usu�rio chave do sistema
		$tbusuario = new TbUsuario();
		$Usuario = $tbusuario->getUsuario($sistema['usu_codigo_usuario_chave']);

		$UsuarioCriador = $tbusuario->getUsuario($_SESSION['usu_codigo']);

		//Email do Departamento
		$tbdepartamento = new TbDepartamento();
		$emaildepto = $tbdepartamento->getDepartamentoEmail($_SESSION['dep_codigo']);

		$dados['vso_data'] = ValidarDatas::dataCliente($dados['vso_data']);
		$dados['form_versao']['vso_data'] = ValidarDatas::dataCliente($dados['form_versao']['vso_data']);

		$sistemaOld = $tbSistema->getForm($dados['form_versao']['sis_codigo']);

		$dados['form_versao']['sis_codigo'];
		$dados['form_versao']['vso_versao'];
		$dados['form_versao']['vso_data'];
		$dados['form_versao']['vso_novas_instalacoes'];
		$dados['form_versao']['vso_obs'];

		$this->cabecalho = 'Retificando a atualiza��o do sistema: '.$sistemaOld['sis_descricao'];
		#De
		$this->mensagem = '<b>Alterado de: </b><br/>';
		$this->mensagem .= '<b>Vers�o: </b>'.$dados['form_versao']['vso_versao'].'<br/>';
		$this->mensagem .= '<b>Sistema: </b>'.$sistemaOld['sis_descricao'].'<br/>';
		$this->mensagem .= '<b>Data: </b>'.$dados['form_versao']['vso_data'].'<br/><br/>';
		//$this->mensagem .= '<b>Vers�o criada por: </b>'. $UsuarioCriador['usu_nome'] .' | '.$UsuarioCriador['usu_email']. '<br/>';
		$this->mensagem .= '<b>Lista da publica��o: </b>'.$dados['form_versao']['vso_novas_instalacoes'].'<br/>';
		$this->mensagem .= '<b>Observa��es: </b>'.$dados['form_versao']['vso_obs'].'<br/><br/>';
		#Para
		$this->mensagem .= '<b>Para: </b><br/>';
		$this->mensagem .= '<b>Nova vers�o: </b>'.$dados['vso_versao'].'<br/>';
		$this->mensagem .= '<b>Sistema: </b>'.$sistema['sis_descricao'].'<br/>';
		$this->mensagem .= '<b>Data: </b>'.$dados['vso_data'].'<br/><br/>';
		//$this->mensagem .= '<b>Vers�o criada por: </b>'. $UsuarioCriador['usu_nome'] .' | '.$UsuarioCriador['usu_email']. '<br/>';
		$this->mensagem .= '<b>Lista da publica��o: </b>'.$dados['vso_novas_instalacoes'].'<br/>';
		$this->mensagem .= '<b>Observa��es: </b>'.$dados['vso_obs'].'<br/><br/>';

		#E-mail de envido do usuario
		if($dados['UsuarioChave'])
		{
			$this->AddAddress($Usuario['usu_email']);
		}

		#E-mail de envio do departamento
		if($dados['Departamento'])
		{
			$this->AddAddress($emaildepto);
		}

		$this->enviarEmail();
	}

	public function emailControleVersao($dados)
	{
		$tbSistema = new TbSistemas();
		$sistema = $tbSistema->getForm($dados['sis_codigo']);

		#Pego e-mail do usu�rio chave do sistema
		$tbusuario = new TbUsuario();
		$Usuario = $tbusuario->getUsuario($sistema['usu_codigo_usuario_chave']);
		$UsuarioCriador = $tbusuario->getUsuario($_SESSION['usu_codigo']);

		//Email do Departamento
		$tbdepartamento = new TbDepartamento();
		$emaildepto = $tbdepartamento->getDepartamentoEmail($_SESSION['dep_codigo']);
		$dados['vso_data'] = ValidarDatas::dataCliente($dados['vso_data']);

		$this->cabecalho = 'Atualiza��o do sistema: '.$sistema['sis_descricao'];

		$this->mensagem  = '<b>Vers�o: </b>'.$dados['vso_versao'].'<br/>';
		$this->mensagem .= '<b>Sistema: </b>'.$sistema['sis_descricao'].'<br/>';
		$this->mensagem .= '<b>Data: </b>'.$dados['vso_data'].'<br/><br/>';
		$this->mensagem .= '<b>Lista da publica��o: </b>'.$dados['vso_novas_instalacoes'].'<br/><br/>';

		#E-mail de envido do usuario
		if($dados['UsuarioChave'])
		{
			$this->AddAddress($Usuario['usu_email']);
		}

		#E-mail de envio do departamento
		if($dados['Departamento'])
		{
			$this->AddAddress($emaildepto);
		}

		$this->enviarEmail();

	}

}
