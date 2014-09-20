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

	public function listarChamado()
	{

		#Dados da busca usado para diferenciar, pois caso contrario hб um
		#conflito de nomes com abertura de chamados e listava ou DEPTO.
		$this->dados['pro_codigo_busca'];

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
				$this->dados['pro_codigo'] = ($this->dados['pro_codigo_busca'] == '') ? '%' : $this->dados['pro_codigo_busca'];
				$this->dados['usu_nome'] = ($this->dados['usu_nome'] == '') ? '%' : $this->dados['usu_nome'];
				$this->dados['sol_descricao_solicitacao'] = ($this->dados['sol_descricao_solicitacao'] == '') ? '%' : $this->dados['sol_descricao_solicitacao'];

				$tbsolicitacao = new TbSolicitacao();

				$dados = $tbsolicitacao->selectTodasSolicitacoes($this->dados);

				return($dados);

				break;
					
			case 1 : #Chamados que abri, ou seja fiz a solicitaзгo

				$tbsolicitacao = new TbSolicitacao();

				$this->dados['usu_codigo_solicitante'] = $_SESSION['usu_codigo'];
				$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? '%' : $this->dados['sta_codigo'];
				$this->dados['pro_codigo'] = ($this->dados['pro_codigo_busca'] == '') ? '%' : $this->dados['pro_codigo_busca'];
				$this->dados['usu_nome'] = ($this->dados['usu_nome'] == '') ? '%' : $this->dados['usu_nome'];
				$this->dados['sol_descricao_solicitacao'] = ($this->dados['sol_descricao_solicitacao'] == '') ? '%' : $this->dados['sol_descricao_solicitacao'];


				$dados = $tbsolicitacao->selectMinhasSolicitacoes($this->dados);

				return($dados);

				break;
					
			case 2 : #Chamados abertos

				$this->dados['dep_codigo_solicitado'] = $_SESSION['dep_codigo'];
				
				$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? 1 : $this->dados['sta_codigo'];
				$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == 5) ? '%' : $this->dados['sta_codigo'];
				
				$this->dados['pro_codigo'] = ($this->dados['pro_codigo_busca'] == '') ? '%' : $this->dados['pro_codigo_busca'];
				$this->dados['usu_nome'] = ($this->dados['usu_nome'] == '') ? '%' : $this->dados['usu_nome'];
				$this->dados['sol_descricao_solicitacao'] = ($this->dados['sol_descricao_solicitacao'] == '') ? '%' : $this->dados['sol_descricao_solicitacao'];

				$this->dados['usu_codigo_atendente'] = ($this->dados['usu_codigo_atendente'] == '') ? '%' : $this->dados['usu_codigo_atendente'];
				
				$tbsolicitacao = new TbSolicitacao();

				$dados = $tbsolicitacao->selectSolicitacoesDepartmento($this->dados);

				return($dados);

				break;
					
			case 3 : #Chamados Em Atendimento, por todos os ou separado por usuбrio

				$tbsolicitacao = new TbSolicitacao();

				$this->dados['dep_codigo_solicitado'] = $_SESSION['dep_codigo'];
				
				$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == 5) ? '%' : $this->dados['sta_codigo'];
				
				$this->dados['pro_codigo'] = ($this->dados['pro_codigo_busca'] == '') ? '%' : $this->dados['pro_codigo_busca'];
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

			#Terзa
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
			
			#Caso nгo tenho uma escolha
			default:
				
			break;
		}

	}
	
	#Lista a lista de execuзгo do item do checklist baseado no dia da semana
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

			#Terзa
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
			
			#Caso nгo tenho uma escolha
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
					
				ValidarNumeros::validaNumero($this->dados['sol_codigo'],'Nъmero do Chamado');
					
					
				#Instacia da classe Solicitacao
				$tbsolicitacao = new TbSolicitacao();

				#Pega o Resultado
				$solicitacao = $tbsolicitacao->getFormReceptor($this->dados['sol_codigo']);
					
				#Verifica se o chamado existe
				if(!$solicitacao['sol_codigo'])
				{
					throw new Exception('Chamado nгo encontrado');
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
				throw new Exception('Chamado nгo encontrado');
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
	
}
?>