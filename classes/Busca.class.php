<?php
class Busca extends Dados
{

	public function getLayoutUsuario($usu_codigo)
	{
		$tblayout = new TbLayout();

		try
		{
			$usu_codigo = ($usu_codigo == '') ? 1 : $usu_codigo;
			$dados = $tblayout->selecLayoutUsuario($usu_codigo);
			return($dados);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}

	public function listarChamadoParaAvaliacao()
	{
		$tbSolicitacao = new TbSolicitacao();

		$dados['sta_codigo'] = 3;
		$dados['usu_codigo_solicitante'] =  $_SESSION['usu_codigo'];
		$dados['sol_data_fim'] = '2015-01-01';

		return $tbSolicitacao->avaliacaoSolicitacao($dados);
	}

	public function listarChamado()
	{

		#Dados da busca usado para diferenciar, pois caso contrario h� um
		#conflito de nomes com abertura de chamados e listava ou DEPTO.
		$this->dados['pro_codigo_busca_tecnico'];

		$this->dados['verpor'] = 2;
					
		if(($this->dados['sta_codigo'] == 6) AND ($this->dados['usu_codigo_atendente'] == 0))
		{
			$this->dados['verpor'] = 2;
				
		}elseif($this->dados['sta_codigo']){
			$this->dados['verpor'] = ($this->dados['sta_codigo'] != 1) ? 3 : 2;
		}
		
		switch ($this->dados['verpor'])
		{

			case 0 : #Todos

				$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? 1 : '';
				$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == 6) ? '%' : $this->dados['sta_codigo'];
				$this->dados['pro_codigo'] = ($this->dados['pro_codigo_busca_tecnico'] == '') ? '%' : $this->dados['pro_codigo_busca_tecnico'];
				$this->dados['usu_nome'] = ($this->dados['usu_nome'] == '') ? '%' : $this->dados['usu_nome'];
				$this->dados['sol_descricao_solicitacao'] = ($this->dados['sol_descricao_solicitacao'] == '') ? '%' : $this->dados['sol_descricao_solicitacao'];

				$tbsolicitacao = new TbSolicitacao();

				$dados = $tbsolicitacao->selectTodasSolicitacoes($this->dados);

				return($dados);

				break;
					
			case 1 : #Chamados que abri, ou seja fiz a solicita��o

				$tbsolicitacao = new TbSolicitacao();

				$this->dados['usu_codigo_solicitante'] = $_SESSION['usu_codigo'];
				$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? '%' : $this->dados['sta_codigo'];
				$this->dados['pro_codigo'] = ($this->dados['pro_codigo_busca_tecnico'] == '') ? '%' : $this->dados['pro_codigo_busca_tecnico'];
				$this->dados['usu_nome'] = ($this->dados['usu_nome'] == '') ? '%' : $this->dados['usu_nome'];
				$this->dados['sol_descricao_solicitacao'] = ($this->dados['sol_descricao_solicitacao'] == '') ? '%' : $this->dados['sol_descricao_solicitacao'];


				$dados = $tbsolicitacao->selectMinhasSolicitacoes($this->dados);

				return($dados);

				break;
					
			case 2 : #Chamados abertos

				$this->dados['dep_codigo_solicitado'] = $_SESSION['dep_codigo'];
				
				$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? 1 : $this->dados['sta_codigo'];
				$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == 6) ? '%' : $this->dados['sta_codigo'];
				
				$this->dados['pro_codigo'] = ($this->dados['pro_codigo_busca_tecnico'] == '') ? '%' : $this->dados['pro_codigo_busca_tecnico'];
				$this->dados['usu_nome'] = ($this->dados['usu_nome'] == '') ? '%' : $this->dados['usu_nome'];
				$this->dados['sol_descricao_solicitacao'] = ($this->dados['sol_descricao_solicitacao'] == '') ? '%' : $this->dados['sol_descricao_solicitacao'];

				$this->dados['usu_codigo_atendente'] = ($this->dados['usu_codigo_atendente'] == '') ? '%' : $this->dados['usu_codigo_atendente'];
				
				$tbsolicitacao = new TbSolicitacao();

				$dados = $tbsolicitacao->selectSolicitacoesDepartmento($this->dados);

				return($dados);

				break;
					
			case 3 : #Chamados Em Atendimento, por todos os ou separado por usu�rio

				$tbsolicitacao = new TbSolicitacao();

				$this->dados['dep_codigo_solicitado'] = $_SESSION['dep_codigo'];
				
				$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == 5) ? '%' : $this->dados['sta_codigo'];
				
				$this->dados['pro_codigo'] = ($this->dados['pro_codigo_busca_tecnico'] == '') ? '%' : $this->dados['pro_codigo_busca_tecnico'];
				$this->dados['usu_nome'] = ($this->dados['usu_nome'] == '') ? '%' : $this->dados['usu_nome'];
				$this->dados['sol_descricao_solicitacao'] = ($this->dados['sol_descricao_solicitacao'] == '') ? '%' : $this->dados['sol_descricao_solicitacao'];

				$this->dados['usu_codigo_atendente'] = ($this->dados['usu_codigo_atendente'] == 0) ? '%' : $this->dados['usu_codigo_atendente'];
				
				$dados = $tbsolicitacao->selectMinhasTarefas($this->dados);

				return($dados);

				break;
					
			default:

				break;
					
		}
	}

	#lista chamados na tela do Solicitante
	public function listarChamadoSolicitante()
	{
		$tbsolicitacao = new TbSolicitacao();

		$this->dados['dep_codigo_solicitado'] = ($this->dados['dep_codigo_busca'] == '') ? '%' : $this->dados['dep_codigo_busca'];
		$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? '%' : $this->dados['sta_codigo'];
		$this->dados['pro_codigo'] = ($this->dados['pro_codigo_busca'] == '') ? '%' : $this->dados['pro_codigo_busca'];
		$this->dados['usu_nome'] = ($this->dados['usu_nome'] == '') ? '%' : $this->dados['usu_nome'];
		$this->dados['sol_descricao_solicitacao'] = ($this->dados['sol_descricao_solicitacao'] == '') ? '%' : $this->dados['sol_descricao_solicitacao'];
		$this->dados['dep_codigo'] = $_SESSION['dep_codigo'];
			
		$dados = $tbsolicitacao->selectSolicitacoesSolicitante($this->dados);

		return($dados);
	}

	#Exporta lista de chamado do solicitante sem quebra de linha
	public function exportarlistaChamadoSolicitante()
	{
		$tbsolicitacao = new TbSolicitacao();
	
		$this->dados['dep_codigo_solicitado'] = ($this->dados['dep_codigo_busca'] == '') ? '%' : $this->dados['dep_codigo_busca'];
		$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? '%' : $this->dados['sta_codigo'];
		$this->dados['pro_codigo'] = ($this->dados['pro_codigo_busca'] == '') ? '%' : $this->dados['pro_codigo_busca'];
		$this->dados['usu_nome'] = ($this->dados['usu_nome'] == '') ? '%' : $this->dados['usu_nome'];
		$this->dados['sol_descricao_solicitacao'] = ($this->dados['sol_descricao_solicitacao'] == '') ? '%' : $this->dados['sol_descricao_solicitacao'];
		$this->dados['dep_codigo'] = $_SESSION['dep_codigo'];
			
		$dados = $tbsolicitacao->exportSolicitacoesSolicitante($this->dados);
	
		return($dados);
	}
	
	
	public function listarProblema()
	{
		$this->dados['dep_codigo'] = ($this->dados['dep_codigo'] == '') ? '%' : $this->dados['dep_codigo'];

		$tbproblema = new TbProblema();

		$dados = $tbproblema->listarProblemaDepartamento($this->dados['dep_codigo']);

		return($dados);

	}

	public function listarChecklist()
	{

		$tbchecklist = new TbChecklist();

		$dados = $tbchecklist->listarChecklist();

		return($dados);

	}
	
	public function listarTempo()
	{

		$this->dados['dep_codigo'] = ($this->dados['dep_codigo'] == '') ? '%' : $this->dados['dep_codigo'];

		$tbtempoatendimento = new TbTempoAtendimento();
		$dados = $tbtempoatendimento->listarTempoAtendimento($this->dados['dep_codigo']);

		return($dados);

	}
	
	public function listarUsuario()
	{

		$this->dados['dep_codigo'] = ($this->dados['dep_codigo'] == '') ? '%' : $this->dados['dep_codigo'];
		$this->dados['usu_nome'] = ($this->dados['usu_nome'] == '') ? '%' : $this->dados['usu_nome'];

		$tbUsuario = new TbUsuario();
		$dados = $tbUsuario->listarUsuarios($this->dados);
		
		return($dados);

	}

	public function listarPrioridade()
	{

		$this->dados['dep_codigo'] = ($this->dados['dep_codigo'] == '') ? '%' : $this->dados['dep_codigo'];

		$tbprioridade = new TbPrioridade();
		$dados = $tbprioridade->listarPrioridades($this->dados['dep_codigo']);

		return($dados);

	}

	public function listarItemCheckList()
	{
		$tbitemcklist = new TbItemChecklist();

		$dados = $tbitemcklist->listarChecklist(self::getValueGet('che_codigo'));

		return($dados);
	}

	#Lista o CheckList para ser selecionando baseado no dia da semana
	public function listarExecutarCheckList()
	{
		/* dse_segunda, dse_terca, dse_quarta, dse_quinta, dse_sexta, dse_sabado, dse_domingo */
		
		$tbchecklist = new TbChecklist();
		
		//$dados = $tbitemcklist->listarItemChecklist(self::getDados('che_codigo'));

		#Verifica o dia da semana
		switch(date('w'))
		{
			#Domingo
			case 0 :
			$dados = $tbchecklist->listarExecucaoChecklist($_SESSION['dep_codigo'],'dse_domingo');	
			return($dados);
			break;

			#Segunda
			case 1 :
			$dados = $tbchecklist->listarExecucaoChecklist($_SESSION['dep_codigo'],'dse_segunda');	
			return($dados);
			break;

			#Ter�a
			case 2 :
			$dados = $tbchecklist->listarExecucaoChecklist($_SESSION['dep_codigo'],'dse_terca');	
			return($dados);				
			break;
			
			#Quarta
			case 3 :
			$dados = $tbchecklist->listarExecucaoChecklist($_SESSION['dep_codigo'],'dse_quarta');	
			return($dados);				
			break;
			
			#Quinta
			case 4 :
			$dados = $tbchecklist->listarExecucaoChecklist($_SESSION['dep_codigo'],'dse_quinta');	
			return($dados);				
			break;

			#Sexta
			case 5 :
			$dados = $tbchecklist->listarExecucaoChecklist($_SESSION['dep_codigo'],'dse_sexta');	
			return($dados);							
			break;

			#Sabado
			case 6 :
			$dados = $tbchecklist->listarExecucaoChecklist($_SESSION['dep_codigo'],'dse_sabado');	
			return($dados);				
			break;
			
			#Caso n�o tenho uma escolha
			default:
				
			break;
		}

	}
	
	#Lista a lista de execu��o do item do checklist baseado no dia da semana
	public function listarExecutarItemCheckList()
	{
		/* dse_segunda, dse_terca, dse_quarta, dse_quinta, dse_sexta, dse_sabado, dse_domingo */
		
		$tbitemcklist = new TbItemChecklist();

		//$dados = $tbitemcklist->listarItemChecklist(self::getDados('che_codigo'));

		#Verifica o dia da semana
		switch(date('w'))
		{
			#Domingo
			case 0 :
			$dados = $tbitemcklist->listarItemChecklistDiaSemana(self::getDados('che_codigo'),'dse_domingo');	
			return($dados);
			break;

			#Segunda
			case 1 :
			$dados = $tbitemcklist->listarItemChecklistDiaSemana(self::getDados('che_codigo'),'dse_segunda');	
			return($dados);
			break;

			#Ter�a
			case 2 :
			$dados = $tbitemcklist->listarItemChecklistDiaSemana(self::getDados('che_codigo'),'dse_terca');	
			return($dados);				
			break;
			
			#Quarta
			case 3 :
			$dados = $tbitemcklist->listarItemChecklistDiaSemana(self::getDados('che_codigo'),'dse_quarta');	
			return($dados);				
			break;
			
			#Quinta
			case 4 :
			$dados = $tbitemcklist->listarItemChecklistDiaSemana(self::getDados('che_codigo'),'dse_quinta');	
			return($dados);				
			break;

			#Sexta
			case 5 :
			$dados = $tbitemcklist->listarItemChecklistDiaSemana(self::getDados('che_codigo'),'dse_sexta');	
			return($dados);							
			break;

			#Sabado
			case 6 :
			$dados = $tbitemcklist->listarItemChecklistDiaSemana(self::getDados('che_codigo'),'dse_sabado');	
			return($dados);				
			break;
			
			#Caso n�o tenho uma escolha
			default:
				
			break;
		}

	}

	public function buscaRapidaChamado()
	{

		try
		{
			if($this->dados['sol_codigo'] == '')
			{
				throw new Exception('',300);

			}else{

				#Remove os espa�os
				$this->dados['sol_codigo'] = trim($this->dados['sol_codigo']);
				
				ValidarNumeros::validaNumero($this->dados['sol_codigo'],'N�mero do Chamado');
					
					
				#Instacia da classe Solicitacao
				$tbsolicitacao = new TbSolicitacao();

				#Pega o Resultado
				$solicitacao = $tbsolicitacao->getFormReceptor($this->dados['sol_codigo']);
					
				#Verifica se o chamado existe
				if(!$solicitacao['sol_codigo'])
				{
					throw new Exception('Chamado n�o encontrado');
				}
				
				#Verifica se o departamento solicitante ou departamento solicitado
				#para este chamado
				$tbUsuario = new TbUsuario();
				$DepSolicitante = $tbUsuario->getDepCodigo($solicitacao['usu_codigo_solicitante']);
				
				if(($solicitacao['dep_codigo'] != $_SESSION['dep_codigo']) && ($DepSolicitante != $_SESSION['dep_codigo'])){
					throw new Exception('Voc� n�o possui permiss�o para este chamado.');
				}
								
				
			}
				
			try
			{


				$tbatendimentosolicitante = new TbAtendenteSolicitacao();
				$solicitacao['usu_codigo'] = $tbatendimentosolicitante->confirmarAtendente($this->dados['sol_codigo']);
								
				return($solicitacao);
				


			} catch (PDOException $e)
			{
				throw new PDOException($e->getMessage(),$e->getCode());
			}
				
				
		} catch (Exception $e)
		{
			throw new Exception($e->getMessage(),$e->getCode());
		}


	}

	public function getRelatorioPDF()
	{

		try
		{
				
			#Instacia da classe Solicitacao
			$tbsolicitacao = new TbSolicitacao();

			#Pega o Resultado
			$solicitacao = $tbsolicitacao->getFormReceptor($this->getValueGet('sol_codigo'));
				
			#Verifica se o chamado existe
			if(!$solicitacao['sol_codigo'])
			{
				throw new Exception('Chamado n�o encontrado');
			}
				
				
			try
			{


				$tbatendimentosolicitante = new TbAtendenteSolicitacao();
				$solicitacao['usu_codigo'] = $tbatendimentosolicitante->confirmarAtendente($this->getValueGet('sol_codigo'));

				return($solicitacao);

			} catch (PDOException $e)
			{
				throw new PDOException($e->getMessage(),$e->getCode());
			}
				
				
		} catch (Exception $e)
		{
			throw new Exception($e->getMessage(),$e->getCode());
		}


	}

	public function listarProjeto()
	{
		
		$this->dados['stp_codigo'] = ($this->dados['stp_codigo'] == '') ? '%' : $this->dados['stp_codigo'];
		$this->dados['pro_titulo'] = ($this->dados['pro_titulo'] == '') ? '%' : $this->dados['pro_titulo'];
		$this->dados['pro_descricao'] = ($this->dados['pro_descricao'] == '') ? '%' : $this->dados['pro_descricao'];	

		$this->dados['dep_codigo'] = $_SESSION['dep_codigo'];
		
		$tbProjeto = new TbProjeto();
		$dados = $tbProjeto->listarProjeto($this->dados);

		return($dados);

	}
	
	public function listarAtividade()
	{

		$this->dados['dep_codigo'] = $_SESSION['dep_codigo'];
		$this->dados['pro_codigo'] = ($this->dados['pro_codigo'] == '') ? '%' : $this->dados['pro_codigo'];
		
		$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? 1 : $this->dados['sta_codigo'];
		$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == 5) ? '%' : $this->dados['sta_codigo'];		
		
		$this->dados['usu_codigo_responsavel'] = ($this->dados['usu_codigo_responsavel'] == '') ? $_SESSION['usu_codigo'] : $this->dados['usu_codigo_responsavel'];
		$this->dados['usu_codigo_responsavel'] = ($this->dados['usu_codigo_responsavel'] == 5) ? '%' : $this->dados['usu_codigo_responsavel'];
		
		
		$this->dados['at_descricao'] = ($this->dados['at_descricao'] == '') ? '%' : $this->dados['at_descricao'];	

		$tbAtividade = new TbAtividade();
		$dados = $tbAtividade->listarAtividade($this->dados);

		return($dados);

	}
	
	public function listarAtividadeSemQuebrarLinha()
	{
	
		$this->dados['dep_codigo'] = $_SESSION['dep_codigo'];
		$this->dados['pro_codigo'] = ($this->dados['pro_codigo'] == '') ? '%' : $this->dados['pro_codigo'];
	
		$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? 1 : $this->dados['sta_codigo'];
		$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == 5) ? '%' : $this->dados['sta_codigo'];
	
		$this->dados['usu_codigo_responsavel'] = ($this->dados['usu_codigo_responsavel'] == '') ? $_SESSION['usu_codigo'] : $this->dados['usu_codigo_responsavel'];
		$this->dados['usu_codigo_responsavel'] = ($this->dados['usu_codigo_responsavel'] == 5) ? '%' : $this->dados['usu_codigo_responsavel'];
	
	
		$this->dados['at_descricao'] = ($this->dados['at_descricao'] == '') ? '%' : $this->dados['at_descricao'];
	
		$tbAtividade = new TbAtividade();
		$dados = $tbAtividade->listarAtividadeSemQuebrarLinha($this->dados);
	
		return($dados);
	
	}

	#Relatorio
	public function listarChamadoPorUsuario()
	{
		
		$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? '%' : $this->dados['sta_codigo'];
		$this->dados['usu_nome'] = ($this->dados['usu_nome'] == '') ? '%' : $this->dados['usu_nome'];	

		$tbSolicitacao = new TbSolicitacao();
		$dados = $tbSolicitacao->chamadoPorUsuario($this->dados);

		return($dados);
		
	}
	
	#Relatorio
	public function listarChamadoPorArea()
	{
		
		$this->dados['dep_descricao'] = ($this->dados['dep_descricao'] == '') ? '%' : $this->dados['dep_descricao'];

		$tbSolicitacao = new TbSolicitacao();
		$dados = $tbSolicitacao->chamadoPorArea($this->dados);

		return($dados);
		
	}
	
	#Relatorio
	public function listarChamadoPorPeriodo()
	{
		
		$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? '%' : $this->dados['sta_codigo'];
		
		$this->dados['data1'] = ($this->dados['data1'] == '') ? date('d-m-Y') : $this->dados['data1'];
		$this->dados['data2'] = ($this->dados['data2'] == '') ? date('d-m-Y') : $this->dados['data2'];

		$this->dados['data1'] = ValidarDatas::dataBanco($this->dados['data1']);
		$this->dados['data2'] = ValidarDatas::dataBanco($this->dados['data2']);		

		$tbSolicitacao = new TbSolicitacao();
		$dados = $tbSolicitacao->chamadoPorPeriodo($this->dados);

		return($dados);
		
	}
	
	public function listarChamadoPorPeriodoTempo()
	{
		
		$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? '%' : $this->dados['sta_codigo'];
		
		$this->dados['data1'] = ($this->dados['data1'] == '') ? date('d-m-Y') : $this->dados['data1'];
		$this->dados['data2'] = ($this->dados['data2'] == '') ? date('d-m-Y') : $this->dados['data2'];

		$this->dados['data1'] = ValidarDatas::dataBanco($this->dados['data1']);
		$this->dados['data2'] = ValidarDatas::dataBanco($this->dados['data2']);		

		$tbSolicitacao = new TbSolicitacao();
		$dados = $tbSolicitacao->chamadoPorPeriodoTempo($this->dados);

		return($dados);
		
	}
	
	#Listar chamado por tempo de solu��o de problema
	public function listarChamadoPorTempoDeSolucao()
	{
		
		try {
			
			ValidarCampos::campoVazio($this->dados['data1'],'Data Inicial'); 
			
			ValidarCampos::campoVazio($this->dados['data2'],'Data final');
			
 			ValidarCampos::campoVazio($this->dados['hora_ini'],'Hora Inicial');
			
			ValidarCampos::campoVazio($this->dados['hora_fim'],'Hora final');
			
			ValidarCampos::campoVazio($this->dados['meio_dia'],'Meio dia');
			
			ValidarCampos::campoVazio($this->dados['sabado'],'Sabado');
			
		} catch (Exception $e) {
			
			throw new Exception('Por favor informe todos os campos: '.$e->getMessage());
		}
		
	
		$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? '%' : $this->dados['sta_codigo'];
	
		$this->dados['pri_codigo'] = ($this->dados['pri_codigo'] == '') ? '%' : $this->dados['pri_codigo'];
		
		$this->dados['usu_codigo_atendente'] = ($this->dados['usu_codigo_atendente'] == '') ? '%' : $this->dados['usu_codigo_atendente'];

        $this->dados['pro_codigo'] = ($this->dados['pro_codigo'] == '') ? '%' : $this->dados['pro_codigo'];

		$this->dados['data1'] = ($this->dados['data1'] == '') ? date('d-m-Y') : $this->dados['data1'];
		$this->dados['data2'] = ($this->dados['data2'] == '') ? date('d-m-Y') : $this->dados['data2'];
	
		/*$this->dados['data1'] = ValidarDatas::dataBanco($this->dados['data1']);
		$this->dados['data2'] = ValidarDatas::dataBanco($this->dados['data2']);*/
	
		$tbSolicitacao = new TbSolicitacao();
		$dados = $tbSolicitacao->chamadoPorTempoDeSolucao($this->dados);
	
		return($dados);
	
	}

	#Listar chamado para avaliacao de chamado
	public function listarChamadoRelatorioAvaliacao()
	{

		try {

			ValidarCampos::campoVazio($this->dados['data1'],'Data Inicial');

			ValidarCampos::campoVazio($this->dados['data2'],'Data final');


		} catch (Exception $e) {

			throw new Exception('Por favor informe todos os campos: '.$e->getMessage());
		}



		$this->dados['pro_codigo_tecnico'] = ($this->dados['pro_codigo_tecnico'] == '') ? '%' : $this->dados['pro_codigo_tecnico'];

		$this->dados['dep_codigo'] = ($this->dados['dep_codigo'] == '') ? '%' : $this->dados['dep_codigo'];

		$this->dados['usu_codigo'] = ($this->dados['usu_codigo'] == '') ? '%' : $this->dados['usu_codigo'];

		$this->dados['data1'] = ($this->dados['data1'] == '') ? date('d-m-Y') : $this->dados['data1'];
		$this->dados['data2'] = ($this->dados['data2'] == '') ? date('d-m-Y') : $this->dados['data2'];

		$this->dados['dep_codigo_solicitado'] = $_SESSION['dep_codigo'];
		$this->dados['sta_codigo'] = 3;

		$tbSolicitacao = new TbSolicitacao();
		$dados = $tbSolicitacao->listarChamadoParaAvaliacao($this->dados);

		return($dados);

	}

	#Listar chamado grafico para avaliacao de chamados
	public function graficoChamadoRelatorioAvaliacao()
	{

		try {

			ValidarCampos::campoVazio($this->dados['data1'],'Data Inicial');

			ValidarCampos::campoVazio($this->dados['data2'],'Data final');


		} catch (Exception $e) {

			throw new Exception('Por favor informe todos os campos: '.$e->getMessage());
		}



		$this->dados['pro_codigo_tecnico'] = ($this->dados['pro_codigo_tecnico'] == '') ? '%' : $this->dados['pro_codigo_tecnico'];

		$this->dados['dep_codigo'] = ($this->dados['dep_codigo'] == '') ? '%' : $this->dados['dep_codigo'];

		$this->dados['usu_codigo'] = ($this->dados['usu_codigo'] == '') ? '%' : $this->dados['usu_codigo'];

		$this->dados['data1'] = ($this->dados['data1'] == '') ? date('d-m-Y') : $this->dados['data1'];
		$this->dados['data2'] = ($this->dados['data2'] == '') ? date('d-m-Y') : $this->dados['data2'];

		$this->dados['dep_codigo_solicitado'] = $_SESSION['dep_codigo'];
		$this->dados['sta_codigo'] = 3;

		$tbSolicitacao = new TbSolicitacao();

		$tbSolicitacao->getGraficoChamadoParaAvaliacao($this->dados);

	}



	#Listar chamado por tempo de solu��o de problema com envio de terceiro
    public function listarChamadoPorTempoDeSolucaoEnvioTerceiro()
    {

        try {

            ValidarCampos::campoVazio($this->dados['data1'],'Data Inicial');

            ValidarCampos::campoVazio($this->dados['data2'],'Data final');

            ValidarCampos::campoVazio($this->dados['hora_ini'],'Hora Inicial');

            ValidarCampos::campoVazio($this->dados['hora_fim'],'Hora final');

            ValidarCampos::campoVazio($this->dados['meio_dia'],'Meio dia');

            ValidarCampos::campoVazio($this->dados['sabado'],'Sabado');

        } catch (Exception $e) {

            throw new Exception('Por favor informe todos os campos: '.$e->getMessage());
        }


        $this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? '%' : $this->dados['sta_codigo'];

        $this->dados['pri_codigo'] = ($this->dados['pri_codigo'] == '') ? '%' : $this->dados['pri_codigo'];

        $this->dados['usu_codigo_atendente'] = ($this->dados['usu_codigo_atendente'] == '') ? '%' : $this->dados['usu_codigo_atendente'];

        $this->dados['pro_codigo'] = ($this->dados['pro_codigo'] == '') ? '%' : $this->dados['pro_codigo'];

        $this->dados['data1'] = ($this->dados['data1'] == '') ? date('d-m-Y') : $this->dados['data1'];
        $this->dados['data2'] = ($this->dados['data2'] == '') ? date('d-m-Y') : $this->dados['data2'];

        /*$this->dados['data1'] = ValidarDatas::dataBanco($this->dados['data1']);
        $this->dados['data2'] = ValidarDatas::dataBanco($this->dados['data2']);*/

        $tbSolicitacao = new TbSolicitacao();
        $dados = $tbSolicitacao->chamadoPorTempoDeSolucaoEnvioTerceiro($this->dados);

        return($dados);

    }


    #Relatorio
	public function listarChamadoPorPrioridade()
	{
		
		$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? '%' : $this->dados['sta_codigo'];
		$this->dados['pri_codigo'] = ($this->dados['pri_codigo'] == '') ? '%' : $this->dados['pri_codigo'];		
		
		$this->dados['data1'] = ($this->dados['data1'] == '') ? date('d-m-Y') : $this->dados['data1'];
		$this->dados['data2'] = ($this->dados['data2'] == '') ? date('d-m-Y') : $this->dados['data2'];

		$this->dados['data1'] = ValidarDatas::dataBanco($this->dados['data1']);
		$this->dados['data2'] = ValidarDatas::dataBanco($this->dados['data2']);		

		$tbSolicitacao = new TbSolicitacao();
		$dados = $tbSolicitacao->chamadoPorPrioridade($this->dados);

		return($dados);
		
	}
	
	public function listarAniversariante()
	{
		
		try
		{
			
		$this->dados['ani_dia'] = ($this->dados['ani_dia'] == '') ? '%' : $this->dados['ani_dia'];
		$this->dados['ani_mes'] = ($this->dados['ani_mes'] == '') ? '%' : $this->dados['ani_mes'];
		$this->dados['ani_unidade'] = ($this->dados['ani_unidade'] == '') ? '%' : $this->dados['ani_unidade'];
		$this->dados['ani_nome'] = ($this->dados['ani_nome'] == '') ? '%' : $this->dados['ani_nome'];
			
		
		$tbAniversariante = new TbAniversariante();
		
		
		$dados = $tbAniversariante->listarAniversariante($this->dados);
		
		return($dados);
	
		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(),$e->getCode() );
		}
	}
	
	public function listarAniversariantePDF()
	{
		
		try
		{
			
		$this->dados['ani_mes'] = ($this->getDados('ani_mes') == '') ? date('m') : $this->getDados('ani_mes');

		$this->dados['ani_unidade'] = ($this->getDados('ani_unidade') == '') ? 1 : $this->getDados('ani_unidade');
		
		$tbAniversariante = new TbAniversariante();
		
		$dados = $tbAniversariante->listarAniversariantePDF($this->dados);
		
		return($dados);
	
		}catch (Exception $e)
		{
			throw new Exception($e->getMessage(),$e->getCode() );
		}
	}
	
	
	public function getRelatorioProjetoPDF()
	{
		$tbProjeto = new TbProjeto();
		
		$dados = $tbProjeto->getFormAlteracao($this->getValueGet('pro_codigo'));
		
		return $dados;
		
	}
	
	public function getRelatorioAtividadePDF()
	{
		$tbAtividade = new TbAtividade();
		
		$dados = $tbAtividade->listarAtividadePDF($this->getValueGet('at_codigo'));
		
		return $dados->fetch();
		
	}
	
	public function getRelatorioMensalMovimentacao()
	{
		
		$this->dados['data1'] = ($this->dados['data1'] == '') ? date('') : $this->dados['data1'];
		
		$this->dados['data2'] = ($this->dados['data2'] == '') ? date('') : $this->dados['data2'];
		
		$this->dados['data1'] = ValidarDatas::dataBanco($this->dados['data1']);
		$this->dados['data2'] = ValidarDatas::dataBanco($this->dados['data2']);
		
		$tbRelatorioMovimentacao = new TbRelatorioPortalMovimentacao();
		
		$dados = $tbRelatorioMovimentacao->getRelatorioMovimentacao($this->dados);
		
		return($dados);
		
	}
	
	public function listarMelhoria()
	{
	
		$this->dados['sis_codigo'] = ($this->dados['sis_codigo'] == '') ? '%' : $this->dados['sis_codigo'];
		$this->dados['stm_codigo'] = ($this->dados['stm_codigo'] == '') ? '%' : $this->dados['stm_codigo'];	
		
		$tbSolicitacaoMelhoria = new TbSolicitacaoMelhoria();
	
		$dados = $tbSolicitacaoMelhoria->listarMelhoria($this->dados);
	
		return($dados);
	
	}

	public function listarRelatorioMelhoria()
	{

		$this->dados['sis_codigo'] = ($this->dados['sis_codigo'] == '') ? '%' : $this->dados['sis_codigo'];
		$this->dados['stm_codigo'] = ($this->dados['stm_codigo'] == '') ? '%' : $this->dados['stm_codigo'];

		$tbSolicitacaoMelhoria = new TbSolicitacaoMelhoria();

		$dados = $tbSolicitacaoMelhoria->listarRelatorioMelhoria($this->dados);

		return($dados);

	}
	
	#Usado na tela de cadastro de sistema
	public function listarSistemaUsuarioChave()
	{
	
		$usu_codigo_usuario_chave = ($this->dados['usu_codigo_usuario_chave'] == '') ? '%' : $this->dados['usu_codigo_usuario_chave'];
	
		$tbSistema = new TbSistemas();
	
		$dados = $tbSistema->listarSistemasPesquisa($usu_codigo_usuario_chave);
	
		return($dados);
	
	}
	
	#Usado na tela de cadastro de Terceiro
	public function listarTerceiro()
	{
	
		$dep_codigo = ($this->dados['dep_codigo'] == '') ? '%' : $this->dados['dep_codigo'];
	
		$tbTerceiro = new TbTerceiro();
	
		$dados = $tbTerceiro->listarCadastro($dep_codigo);
	
		return($dados);
	
	}

    public function getRelatorioTarefa()
    {
        $this->dados['data_inicial'] = $this->dados['data_inicial'] .' 00:00:01';
        $this->dados['data_final'] = $this->dados['data_final'] . ' 23:59:59';
        $this->dados['usu_codigo'] = ($this->dados['usu_codigo'] == '') ? '%' : $this->dados['usu_codigo'];
        $this->dados['dep_codigo'] = $_SESSION['dep_codigo'];

        $tbTarefa = new TbTarefas();

        return $tbTarefa->listTaskByGroup($this->dados);

    }

    public function listarRelatoriSolicitacaoAcesso()
    {
        $this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? '%' : $this->dados['sta_codigo'];
        $this->dados['sol_codigo'] = ($this->dados['sol_codigo'] == '') ? '%' : $this->dados['sol_codigo'];
        $this->dados['dep_codigo'] = $_SESSION['dep_codigo'];

        $tbSolicitacaoAcesso = new TbSolicitacaoAcesso();

        return $tbSolicitacaoAcesso->listControlAcess($this->dados);

    }

	public function listarRncGestor()
	{

		$this->dados['dep_responsavel_codigo'] = $_SESSION['dep_codigo'];
		$this->dados['data1'] = ($this->dados['data1'] == '') ? date('Y-m-d') : ValidarDatas::dataBanco($this->dados['data1']);
		$this->dados['data2'] = ($this->dados['data2'] == '') ? date('Y-m-d') : ValidarDatas::dataBanco($this->dados['data2']);
		$this->dados['sta_codigo_rnc'] = ($this->dados['sta_codigo_rnc'] == '') ? '%' : $this->dados['sta_codigo_rnc'];
		$this->dados['nc_descricaocompleta'] = ($this->dados['nc_descricaocompleta'] == '') ? '%' : $this->dados['nc_descricaocompleta'];

		$tbRnc = new TbCadastroRnc();
		return $tbRnc->listarRncGestor($this->dados);

	}

	public function listarRncQualidade()
	{

		$this->dados['dep_responsavel_codigo'] = ($this->dados['dep_responsavel_codigo'] == '') ? '%' : $this->dados['dep_responsavel_codigo'];

		$this->dados['data1'] = ($this->dados['data1'] == '') ? date('Y-m-d') : ValidarDatas::dataBanco($this->dados['data1']);
		$this->dados['data2'] = ($this->dados['data2'] == '') ? date('Y-m-d') : ValidarDatas::dataBanco($this->dados['data2']);

		$this->dados['sta_codigo_rnc'] = ($this->dados['snc_codigo'] == '') ? '%' : $this->dados['snc_codigo'];
		$this->dados['nc_descricaocompleta'] = ($this->dados['nc_descricaocompleta'] == '') ? '%' : $this->dados['nc_descricaocompleta'];

		$tbRnc = new TbCadastroRnc();

		/*
		 * 1 = Data de Verificacao
		 * 2 = Date de Abertura
		 */
		if($this->dados['tipo_data'] == 1){
			return $tbRnc->listarRncQualidadeVerificacao($this->dados);
		}else{
			return $tbRnc->listarRncQualidadeAbertura($this->dados);
		}



	}

	public function graficoTopTenChamadoAbertoPorArea()
	{

		$tbSolicitacao = new TbSolicitacao();

		$this->dados['data1'] = ($this->dados['data1'] == '') ? ValidarDatas::dataAnterior(date('d-m-Y'),-30) : $this->dados['data1'];
		$this->dados['data2'] = ($this->dados['data2'] == '') ? date('d-m-Y') : $this->dados['data2'];

		$this->dados['data1'] = ValidarDatas::dataBanco($this->dados['data1']);
		$this->dados['data2'] = ValidarDatas::dataBanco($this->dados['data2']);


		$tbSolicitacao->graficoTopTenChamadoAbertoPorArea($this->dados);

	}


	public function listarAtividadeProjetoByUserFinal()
	{

		$tbAtividade = new TbAtividade();

		$dataAtividade = $tbAtividade->getMaxAndMinDataAtividades($this->dados['usu_codigo_responsavel']);

		$this->dados['data1'] = ($this->dados['data1'] == '') ? $dataAtividade['menor_data'] : $this->dados['data1'];
		$this->dados['data2'] = ($this->dados['data2'] == '') ? $dataAtividade['maior_data'] : $this->dados['data2'];

		$this->dados['data1'] = date('Y-m-d',strtotime(str_replace('/','-',$this->dados['data1'])));
		$this->dados['data2'] = date('Y-m-d',strtotime(str_replace('/','-',$this->dados['data2'])));

		$this->dados['usu_codigo_responsavel'];


		return $tbAtividade->listarAtividadeProjetoByUser($this->dados)->fetchAll(\PDO::FETCH_NUM);

	}

	public function getTotalAtividadeUsuario()
	{

		$tbAtividade = new TbAtividade();

		$dataAtividade = $tbAtividade->getMaxAndMinDataAtividades($this->dados['usu_codigo_responsavel']);

		$this->dados['data1'] = ($this->dados['data1'] == '') ? $dataAtividade['menor_data'] : $this->dados['data1'];
		$this->dados['data2'] = ($this->dados['data2'] == '') ? $dataAtividade['maior_data'] : $this->dados['data2'];

		$this->dados['data1'] = date('Y-m-d',strtotime(str_replace('/','-',$this->dados['data1'])));
		$this->dados['data2'] = date('Y-m-d',strtotime(str_replace('/','-',$this->dados['data2'])));

		$this->dados['usu_codigo_responsavel'];


		return $tbAtividade->getQuantidadeAtividadeByUser($this->dados);

	}


	public function listarVersoes()
	{
		$this->dados['sis_codigo'] = ($this->dados['sis_codigo'] == '') ? '%' : $this->dados['sis_codigo'];

		$this->dados['data1'] = ($this->dados['data1'] == '') ? ValidarDatas::dataBanco(ValidarDatas::dataAnterior(date('d-m-Y'),-30)) : ValidarDatas::dataBanco($this->dados['data1']);
		$this->dados['data2'] = ($this->dados['data2'] == '') ? date('Y-m-d') : ValidarDatas::dataBanco($this->dados['data2']);

		$tbControleVersao = new TbControleVersao();
		return $tbControleVersao->listarVersoes($this->dados);
	}


}
?>