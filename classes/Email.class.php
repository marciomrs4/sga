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

		$this->FromName = 'SISTEMA DE GESTÃO DE ATIVIDADES';


		$this->Subject = $this->cabecalho;

		$this->Body = $this->mensagem;

		$this->Send();

		$this->erro = $this->ErrorInfo;

	}


	public function setMensagem($mensagem)
	{
		$this->mensagem = $mensagem;
	}

	public function setCabecalho($cabecalho)
	{
		$this->cabecalho = $cabecalho;
	}

	public function aberturaChamado($dados)
	{
		$tbusuario = new TbUsuario();
		$email = $tbusuario->getUsuario($dados['usu_codigo_solicitante']);

		$tbdepartamento = new TbDepartamento();
		$emaildepto = $tbdepartamento->getDepartamentoEmail($dados['dep_codigo_solicitado']);

		$tbprobleama = new TbProblema();
		$problema = $tbprobleama->getForm($dados['pro_codigo']);

				
		$this->cabecalho = 'Abertura de Chamado: '.$dados['sol_codigo'];

		$this->mensagem = 'O Chamado de nÃºmero: '.$dados['sol_codigo'].'<br/>';
		$this->mensagem .= 'Foi aberto com sucesso por: '.$email['usu_email'].' e logo um tÃ©cnico irÃ¡ atende-lo <br/>';
		$this->mensagem .= 'Contato:  '.$email['usu_nome'].' - Tel / '.$_SESSION['config']['ramal'].': '.$email['usu_ramal'].'<br/>';
		$this->mensagem .= $_SESSION['config']['problema'].': '.$problema['pro_descricao'].'<br/><br/>';
		$this->mensagem .= 'DescriÃ§Ã£o do '.$_SESSION['config']['problema'].': '.$dados['sol_descricao_solicitacao'].'<br/>';
		
		
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

		#pega o cÃ³digo do solicitante do chamado
		$usuSolicitante = $tbsolcitacao->getUsuarioSolicitante($dados['sol_codigo']);
		
		#pega a descricao da solicitacao que foi feito na abertura do chamado
		$descricaoSolicitacao = $tbsolcitacao->getDescricaoSolicitacao($dados['sol_codigo']);
		
		#Pego e-mail de quem fez o assentamento informaÃ§Ãµes do usuarios
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

		#Pego a descriÃ§Ã£o do problema
		$tbprobleama = new TbProblema();
		$problema = $tbprobleama->getForm($pro_codigo);

		$tbstatus = new TbStatus();
		$sta_descricao = $tbstatus->getDescricao($tbsolcitacao->getStatus($dados['sol_codigo']));

		$this->cabecalho = 'Assentamento do chamado: '.$dados['sol_codigo'];

		$this->mensagem = 'Houve uma interaÃ§Ã£o no chamado: '.$dados['sol_codigo'].'<br/>';
		$this->mensagem .= 'Assentamento criado por: '.$email['usu_email'].'<br/>';
		$this->mensagem .= $_SESSION['config']['problema'].': '.$problema['pro_descricao'].'<br/><br/>';
		$this->mensagem .= 'Descrição do Chamado: '.$descricaoSolicitacao.'<br/><br/>';
		$this->mensagem .= 'Foi adicionado o seguinte assentamento: '.$dados['ass_descricao'].'<br/><br/>';
		$this->mensagem .= 'Status do chamado: '.$sta_descricao;
		
		
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
		
		$this->mensagem = 'A melhoria de número: '.$dados['som_codigo'].'<br/>';
		$this->mensagem .= 'Foi aberto com sucesso por: '.$usuarioSolicitante['usu_email'].' e logo o usuário chave irá atende-lo. <br/>';
		$this->mensagem .= 'Contato:  '.$usuarioSolicitante['usu_nome'].' - Tel / '.$_SESSION['config']['ramal'].': '.$usuarioSolicitante['usu_ramal'].'<br/>';
		$this->mensagem .= 'Sistema: '.$sistema['sis_descricao'].'<br/><br/>';
		$this->mensagem .= 'Descrição da melhoria: ' . $dados['som_descricao'].'<br/>';

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

		$this->mensagem = 'Houve um apontamento no melhoria: '.$dados['som_codigo'].'<br/>';
		$this->mensagem .= 'Criado por: '.$usuarioCriador['usu_email'].'<br/>';
		$this->mensagem .= 'Sistema: '.$sistema['sis_descricao'].'<br/><br/>';
		$this->mensagem .= 'Descrição do Chamado: '.$Solicitacao['som_descricao'].'<br/><br/>';
		$this->mensagem .= 'Foi adicionado o seguinte Apontamento: '.$dados['apm_descricao'].'<br/><br/>';
		$this->mensagem .= 'Status do chamado: '.$Status['stm_descricao'];
		
		
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
	
	

}
