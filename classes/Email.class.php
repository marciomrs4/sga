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

		$this->mensagem = '<b>O Chamado de número: </b>'.$dados['sol_codigo'].'<br/>';
		$this->mensagem .= '<b>Foi aberto com sucesso por: </b>'.$email['usu_email'].' e logo um técnico irá atende-lo <br/>';
		$this->mensagem .= '<b>Contato:  </b>'.$email['usu_nome'].'<br/>';
		$this->mensagem .= '<b>Tel / '.$_SESSION['config']['ramal'].': </b> '.$email['usu_ramal'].'<br/>';
		$this->mensagem .= '<b>' . $_SESSION['config']['problema'].': </b>'.$problema['pro_descricao'].'<br/><br/>';
		$this->mensagem .= '<b>Descrição do '.$_SESSION['config']['problema'].': </b>'.$dados['sol_descricao_solicitacao'].'<br/>';
		
		
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

		#pega o código do solicitante do chamado
		$usuSolicitante = $tbsolcitacao->getUsuarioSolicitante($dados['sol_codigo']);
		
		#pega a descricao da solicitacao que foi feito na abertura do chamado
		$descricaoSolicitacao = $tbsolcitacao->getDescricaoSolicitacao($dados['sol_codigo']);
		
		#Pego e-mail de quem fez o assentamento informações do usuarios
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

		#Pego a descrição do problema
		$tbprobleama = new TbProblema();
		$problema = $tbprobleama->getForm($pro_codigo);

		$tbstatus = new TbStatus();
		$sta_descricao = $tbstatus->getDescricao($tbsolcitacao->getStatus($dados['sol_codigo']));

		$this->cabecalho = 'Assentamento do chamado: '.$dados['sol_codigo'];

		$this->mensagem = '<b>Houve uma interação no chamado: </b>'.$dados['sol_codigo'].'<br/>';
		$this->mensagem .= '<b>Assentamento criado por: </b>'.$email['usu_email'].'<br/>';
		$this->mensagem .= '<b>' . $_SESSION['config']['problema'].': </b>'.$problema['pro_descricao'].'<br/><br/>';
		$this->mensagem .= '<b>Descrição do Chamado: </b>'.$descricaoSolicitacao.'<br/><br/>';
		$this->mensagem .= '<b>Foi adicionado o seguinte assentamento: </b>'.$dados['ass_descricao'].'<br/><br/>';
		$this->mensagem .= '<b>Status do chamado: </b>'.$sta_descricao;
		
		
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
		
		$this->mensagem = '<b>A melhoria de número: </b>'.$dados['som_codigo'].'<br/>';
		$this->mensagem .= '<b>Foi aberto com sucesso por: </b>'.$usuarioSolicitante['usu_email'].' <b> e logo o usuário chave irá atende-lo.</b> <br/>';
		$this->mensagem .= '<b>Contato:  </b>'.$usuarioSolicitante['usu_nome'].'</b><br/>';
        $this->mensagem .= '<b>Tel / '.$_SESSION['config']['ramal'].':</b> '.$usuarioSolicitante['usu_ramal'].'<br/>';
		$this->mensagem .= '<b>Sistema: </b>'.$sistema['sis_descricao'].'<br/><br/>';
		$this->mensagem .= '<b>Descrição da melhoria: </b>' . $dados['som_descricao'].'<br/>';

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
		$this->mensagem .= '<b>Descrição do Chamado: </b>'.$Solicitacao['som_descricao'].'<br/><br/>';
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
	
	

}
