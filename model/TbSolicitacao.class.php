<?php

class TbSolicitacao extends Banco
{

	private $tabela = 'tb_solicitacao';

	private $sol_codigo = 'sol_codigo';
	private $pro_codigo = 'pro_codigo';
	private $sta_codigo = 'sta_codigo';
	private $usu_codigo_solicitante = 'usu_codigo_solicitante';
	private $dep_codigo_solicitado = 'dep_codigo_solicitado';
	private $sol_descricao_solicitacao = 'sol_descricao_solicitacao';
	private $sol_data_inicio = 'sol_data_inicio';
	private $sol_data_fim = 'sol_data_fim';
	private $pro_codigo_tecnico = 'pro_codigo_tecnico';

	public function insert($dados)
	{

		$query = ("INSERT INTO $this->tabela
						($this->pro_codigo, $this->sta_codigo, $this->usu_codigo_solicitante,
						$this->dep_codigo_solicitado, $this->sol_descricao_solicitacao,
						$this->sol_data_inicio, $this->pro_codigo_tecnico)
					VALUES(?,?,?,?,?,?,?)
				  ");

						try
						{
							$stmt = $this->conexao->prepare($query);

							$stmt->bindParam(1,$dados[$this->pro_codigo],PDO::PARAM_INT);
							$stmt->bindParam(2,$dados[$this->sta_codigo],PDO::PARAM_INT);
							$stmt->bindParam(3,$dados[$this->usu_codigo_solicitante],PDO::PARAM_INT);
							$stmt->bindParam(4,$dados[$this->dep_codigo_solicitado],PDO::PARAM_INT);
							$stmt->bindParam(5,$dados[$this->sol_descricao_solicitacao],PDO::PARAM_STR);
							$stmt->bindParam(6,date('Y-m-d H:i:s'),PDO::PARAM_STR);
							$stmt->bindParam(7,$dados[$this->pro_codigo],PDO::PARAM_INT);

							$stmt->execute();

							$this->sol_codigo =  $this->conexao->lastInsertId();

							return($this->sol_codigo);

						}catch (PDOException $e)
						{
							throw new PDOException("Erro na tabela ". get_class($this)."-". $e->getMessage(),$e->getCode());
						}

	}

	public function update($dados)
	{
		$query = ("UPDATE $this->tabela
					SET	$this->dep_codigo_solicitado = ?,
						$this->pro_codigo = ?,
						$this->sol_descricao_solicitacao = ?,
						$this->pro_codigo_tecnico = ?
					WHERE $this->sol_codigo = ? ");
					try
					{
						$stmt = $this->conexao->prepare($query);

						$stmt->bindParam(1,$dados[$this->dep_codigo_solicitado],PDO::PARAM_INT);
						$stmt->bindParam(2,$dados[$this->pro_codigo],PDO::PARAM_INT);
						$stmt->bindParam(3,$dados[$this->sol_descricao_solicitacao],PDO::PARAM_STR);
						$stmt->bindParam(4,$dados[$this->pro_codigo],PDO::PARAM_INT);						
						$stmt->bindParam(5,$dados[$this->sol_codigo],PDO::PARAM_INT);
							
						$stmt->execute();

						return($stmt);

					} catch (PDOException $e)
					{
						throw new PDOException("Erro em TbSolicitacao".$e->getMessage(),$e->getCode());
					}

	}

	public function updateSolicitacaoSolicitante($dados)
	{
		$query = ("UPDATE $this->tabela
					SET	$this->dep_codigo_solicitado = ?,
						$this->pro_codigo = ?,
						$this->sol_descricao_solicitacao = ?,
						$this->pro_codigo_tecnico = ?
					WHERE $this->sol_codigo = ? ");
		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados['dep_codigo'],PDO::PARAM_INT);
			$stmt->bindParam(2,$dados['pro_codigo'],PDO::PARAM_INT);
			$stmt->bindParam(3,$dados['sol_descricao_solicitacao'],PDO::PARAM_STR);
			$stmt->bindParam(4,$dados['pro_codigo'],PDO::PARAM_INT);
			$stmt->bindParam(5,$dados['sol_codigo'],PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException("Erro em TbSolicitacao".$e->getMessage(),$e->getCode());
		}

	}

	#Usado para mostrar informa��oes na tela da SolicitacaoTecnico
	public function getFormReceptor($sol_codigo)
	{

		$query = ("SELECT sol_codigo,
						pro_codigo,
						sta_codigo,
						usu_codigo_solicitante,
						dep_codigo_solicitado as dep_codigo,
						sol_descricao_solicitacao 
					FROM  $this->tabela
				   		WHERE $this->sol_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$sol_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetch(PDO::FETCH_ASSOC));

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	#Metodo usado para mostrar o chamado no assentamento
	public function getFormAssentamento($sol_codigo)
	{

		$query = ("SELECT $this->sol_codigo, $this->sol_descricao_solicitacao, 
						  $this->sta_codigo, $this->usu_codigo_solicitante, $this->pro_codigo_tecnico
					FROM  $this->tabela
				   	WHERE $this->sol_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$sol_codigo,PDO::PARAM_INT);

			$stmt->execute();

			$dados = $stmt->fetch();
			return($dados);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	#Chamado que estou Atendendo; Chamados que estou atendendo
	public function selectMinhasTarefas($dados)
	{
		$query = ("SELECT SOL.sol_codigo, USU.usu_nome, 
							(SELECT date_format(tea_data_acao,'%d-%m-%Y %H:%i:%s') 
								        	FROM tb_calculo_atendimento 
								        	WHERE sol_codigo = SOL.sol_codigo AND sta_codigo = 1) AS Abertura,
						  PRO.pro_descricao,  STA.sta_descricao,  
					(SELECT dep_descricao FROM tb_departamento WHERE dep_codigo = 
				        (SELECT dep_codigo FROM tb_usuario WHERE usu_codigo = usu_codigo_solicitante)
				    	) AS Departamento_Solicitante,
						   substr(SOL.sol_descricao_solicitacao,1,60) AS 'descricao', 
						    (SELECT usu_email FROM tb_usuario WHERE usu_codigo = ATE.usu_codigo_atendente) AS Atendente
					FROM tb_solicitacao AS SOL
					INNER JOIN tb_problema AS PRO
					ON PRO.pro_codigo = SOL.pro_codigo 
					INNER JOIN tb_status AS STA
					ON STA.sta_codigo = SOL.sta_codigo 
					INNER JOIN tb_usuario AS USU
					ON USU.usu_codigo = SOL.usu_codigo_solicitante
					INNER JOIN tb_departamento AS DEP
					ON DEP.dep_codigo = SOL.dep_codigo_solicitado
					LEFT JOIN tb_atendente_solicitacao AS ATE
					ON ATE.sol_codigo = SOL.sol_codigo
					WHERE SOL.dep_codigo_solicitado = ?
					AND SOL.sta_codigo LIKE ?
					AND SOL.pro_codigo LIKE ?
					AND USU.usu_nome LIKE ?
					AND SOL.sol_descricao_solicitacao LIKE ?
					AND ATE.usu_codigo_atendente LIKE ?
					ORDER BY SOL.sol_codigo DESC
					LIMIT 500
		");
		
		try
		{
			$stmt = $this->conexao->prepare($query);

			$array = array("{$dados[$this->dep_codigo_solicitado]}",
							"{$dados[$this->sta_codigo]}",
							"{$dados[$this->pro_codigo]}",
							"%{$dados['usu_nome']}%",
							"%{$dados[$this->sol_descricao_solicitacao]}%",
							"{$dados['usu_codigo_atendente']}");


			$stmt->execute($array);

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}

	#Usado na op��o, Chamados que abri
	public function selectMinhasSolicitacoes($dados)
	{
		$query = ("SELECT SOL.sol_codigo, substr(PRO.pro_descricao,1,60), STA.sta_descricao,
				     USU.usu_nome AS Usuario_Solicitante,
				    (SELECT dep_descricao FROM tb_departamento WHERE dep_codigo = 
				        (SELECT dep_codigo FROM tb_usuario WHERE usu_codigo = usu_codigo_solicitante)
				    ) AS Departamento_Solicitante,
				    substr(sol_descricao_solicitacao,1,60), (SELECT usu_email FROM tb_usuario WHERE usu_codigo = ATS.usu_codigo_atendente) as Atendente,
   	                (SELECT date_format(tea_data_acao,'%d-%m-%Y %H:%i:%s') FROM tb_calculo_atendimento WHERE sol_codigo = SOL.sol_codigo AND sta_codigo = 1) AS Abertura
				    FROM tb_solicitacao as SOL
				    #Traz o nome do usuario solicitante
				    INNER JOIN tb_usuario as USU
            		ON usu_codigo_solicitante = USU.usu_codigo
				    #Tabela de Problema, traz a descri��o do problema
				    inner join tb_problema AS PRO
				    ON PRO.pro_codigo = SOL.pro_codigo
				    inner join tb_status STA
				    ON STA.sta_codigo = SOL.sta_codigo
				    #Tabela de Atendente Solicitacao, traz quem esta atendendo a solicitacao
				    LEFT JOIN tb_atendente_solicitacao as ATS
				    ON SOL.sol_codigo = ATS.sol_codigo
				    WHERE usu_codigo_solicitante = ?
                    AND SOL.sta_codigo LIKE ? AND SOL.pro_codigo LIKE ?
                    AND usu_nome LIKE ? AND sol_descricao_solicitacao LIKE ?
				    ORDER BY SOL.sol_codigo DESC");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$array = array($dados[$this->usu_codigo_solicitante],
							"%{$dados[$this->sta_codigo]}%",
							"%{$dados[$this->pro_codigo]}%",
							"%{$dados['usu_nome']}%",
							"%{$dados[$this->sol_descricao_solicitacao]}%");

			$stmt->execute($array);

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}

	#Mostra os Chamados da area, por Status e Problema, TODOS CHAMADO PRA EQUIPE.
	public function selectSolicitacoesDepartmento($dados)
	{

		$query = ("SELECT SOL.sol_codigo, USU.usu_nome AS Usuario_Solicitante,
			        (SELECT date_format(tea_data_acao,'%d-%m-%Y %H:%i:%s') 
			        	FROM tb_calculo_atendimento 
			        	WHERE sol_codigo = SOL.sol_codigo AND sta_codigo = 1) AS Abertura,
			        	substr(PRO.pro_descricao,1,60), 
			        	STA.sta_descricao,
				    (SELECT dep_descricao FROM tb_departamento WHERE dep_codigo = 
				        (SELECT dep_codigo FROM tb_usuario WHERE usu_codigo = usu_codigo_solicitante)
				    ) AS Departamento_Solicitante,
					    substr(sol_descricao_solicitacao,1,60), 
				    (SELECT usu_email FROM tb_usuario WHERE usu_codigo = ATS.usu_codigo_atendente) AS Atendente

				    FROM tb_solicitacao AS SOL
				    #Traz o nome do usuario solicitante
				    INNER JOIN tb_usuario as USU
           			ON usu_codigo_solicitante = USU.usu_codigo
				    #Tabela de Problema, traz a descri��o do problema
				    INNER JOIN tb_problema AS PRO
				    ON PRO.pro_codigo = SOL.pro_codigo
				    INNER JOIN tb_status STA
				    ON STA.sta_codigo = SOL.sta_codigo
				    #Tabela de Atendente Solicitacao, traz quem esta atendendo a solicitacao
				    LEFT JOIN tb_atendente_solicitacao AS ATS
				    ON SOL.sol_codigo = ATS.sol_codigo
				    WHERE SOL.sta_codigo LIKE ? 
				    AND SOL.pro_codigo LIKE ?
                    AND usu_nome LIKE ? 
                    AND sol_descricao_solicitacao LIKE ?
                    AND dep_codigo_solicitado = ?
				    ORDER BY SOL.sol_codigo DESC
					LIMIT 500
				");
		try
		{
				
			$stmt = $this->conexao->prepare($query);

			$array = array("{$dados[$this->sta_codigo]}",
							"{$dados[$this->pro_codigo]}",
							"%{$dados['usu_nome']}%",
							"%{$dados[$this->sol_descricao_solicitacao]}%",
							"{$dados[$this->dep_codigo_solicitado]}");

			$stmt->execute($array);
			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}

	#Mostra todos os Chamados De todas as areas, por Status, Problema , usuario e descricao.
	public function selectTodasSolicitacoes($dados)
	{

		$query = ("SELECT SOL.sol_codigo, substr(PRO.pro_descricao,1,60), STA.sta_descricao,
				     USU.usu_nome AS Usuario_Solicitante,
				    (SELECT dep_descricao FROM tb_departamento WHERE dep_codigo = 
				        (SELECT dep_codigo FROM tb_usuario WHERE usu_codigo = usu_codigo_solicitante)
				    ) AS Departamento_Solicitante,
				    substr(sol_descricao_solicitacao,1,60), 
				    (SELECT usu_email FROM tb_usuario WHERE usu_codigo = ATS.usu_codigo_atendente) AS Atendente,
	                (SELECT date_format(tea_data_acao,'%d-%m-%Y %H:%i:%s') 
                    FROM tb_calculo_atendimento 
                    WHERE sol_codigo = SOL.sol_codigo AND sta_codigo = 1) AS Abertura
				    FROM tb_solicitacao AS SOL
				    #Traz o nome do usuario solicitante
				    INNER JOIN tb_usuario as USU
           			ON usu_codigo_solicitante = USU.usu_codigo
				    #Tabela de Problema, traz a descri��o do problema
				    INNER JOIN tb_problema AS PRO
				    ON PRO.pro_codigo = SOL.pro_codigo
				    INNER JOIN tb_status STA
				    ON STA.sta_codigo = SOL.sta_codigo
				    #Tabela de Atendente Solicitacao, traz quem esta atendendo a solicitacao
				    LEFT JOIN tb_atendente_solicitacao AS ATS
				    ON SOL.sol_codigo = ATS.sol_codigo
				    WHERE SOL.sta_codigo LIKE ? 
                    AND SOL.pro_codigo LIKE ?
                    AND usu_nome LIKE ?
                    AND sol_descricao_solicitacao LIKE ?
				    ORDER BY SOL.sol_codigo DESC
				    ");
		try
		{
			$stmt = $this->conexao->prepare($query);

			$array = array("{$dados[$this->sta_codigo]}",
							"{$dados[$this->pro_codigo]}",
							"%{$dados['usu_nome']}%",
							"%{$dados[$this->sol_descricao_solicitacao]}%");

			$stmt->execute($array);
			
			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}

	public function updateEncaminharExecutor($dados)
	{
		$query = ("UPDATE $this->tabela
					SET $this->usu_codigo_atendente = ?,
					$this->sta_codigo = ?,
					$this->sol_aprovacaogerencia = ?
					WHERE $this->sol_codigo = ?");
					try
					{
						$stmt = $this->conexao->prepare($query);
						$stmt->bindParam(1,$dados[$this->usu_codigo_atendente],PDO::PARAM_INT);
						$stmt->bindParam(2,$dados[$this->sta_codigo],PDO::PARAM_INT);
						$stmt->bindParam(3,$dados[$this->sol_aprovacaogerencia],PDO::PARAM_INT);
						$stmt->bindParam(4,$dados[$this->sol_codigo],PDO::PARAM_INT);
							
						$stmt->execute();
							
						return($stmt);
							
					} catch (PDOException $e)
					{
						throw new PDOException($e->getMessage(), $e->getCode());
					}
	}

	public function updateAtendimento($dados)
	{
		$query = ("UPDATE $this->tabela
					SET $this->sol_descricao_solucao = ?,
					$this->sta_codigo = ?,
					$this->sol_datafechamento = ?
					WHERE $this->sol_codigo = ?");
					try
					{
						$stmt = $this->conexao->prepare($query);
						$stmt->bindParam(1,$dados[$this->sol_descricao_solucao],PDO::PARAM_STR);
						$stmt->bindParam(2,$dados[$this->sta_codigo],PDO::PARAM_INT);
						$stmt->bindParam(3,$dados[$this->sol_datafechamento],PDO::PARAM_STR);
						$stmt->bindParam(4,$dados[$this->sol_codigo],PDO::PARAM_INT);
							
						$stmt->execute();
							
						return($stmt);
							
					} catch (PDOException $e)
					{
						throw new PDOException($e->getMessage(), $e->getCode());
					}
	}

	#Apenas solicita��es para o Departamento
	public function selectSolicitacaoDepartamento($dep_codigo)
	{
		$query = ("SELECT SOL.sol_codigo, PRO.pro_descricao, STA.sta_descricao,
				    (SELECT usu_nome FROM tb_usuario WHERE usu_codigo = usu_codigo_solicitante) AS Usuario_Solicitante,
				    (SELECT dep_descricao FROM tb_departamento WHERE dep_codigo = 
				        (SELECT dep_codigo FROM tb_usuario WHERE usu_codigo = usu_codigo_solicitante)
				    ) AS Departamento_Solicitante,
				    sol_descricao_solicitacao, (SELECT usu_email FROM tb_usuario WHERE usu_codigo = ATS.usu_codigo_atendente) as Atendente
				    from tb_solicitacao as SOL
				    #Tabela de Problema, traz a descri��o do problema
				    inner join tb_problema AS PRO
				    ON PRO.pro_codigo = SOL.pro_codigo
				    inner join tb_status STA
				    ON STA.sta_codigo = SOL.sta_codigo
				    #Tabela de Atendente Solicitacao, traz quem esta atendendo a solicitacao
				    left join tb_atendente_solicitacao as ATS
				    on SOL.sol_codigo = ATS.sol_codigo
				    WHERE dep_codigo_solicitado = ?
            ORDER BY sol_codigo DESC
            ");
		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dep_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}

	public function updateAprovarSolicitacao($dados)
	{
		$query = ("UPDATE $this->tabela
					SET $this->usu_codigo_gerencia = ?
					WHERE $this->sol_codigo = ?");
		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->usu_codigo_gerencia],PDO::PARAM_INT);
			$stmt->bindParam(2,$dados[$this->sol_codigo],PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}

	#Verifica qual o problema da solicitacao, e retorna
	public function getProblema($sol_codigo)
	{
		$query = ("SELECT $this->pro_codigo FROM $this->tabela
					WHERE $this->sol_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$sol_codigo,PDO::PARAM_INT);

			$stmt->execute();

			$dados = $stmt->fetch();

			return($dados[0]);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}

	#Verifica qual o Departamento da solicitacao, e retorna
	public function getCodigoDepartamentoSolicitado($sol_codigo)
	{
		$query = ("SELECT $this->dep_codigo_solicitado
                    FROM $this->tabela
					WHERE $this->sol_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$sol_codigo,PDO::PARAM_INT);

			$stmt->execute();

			$dados = $stmt->fetch();

			return($dados['0']);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}

	#Usado para alterar o DataFim da solicita��o
	public function alterarDataFim($dados)
	{
		$query = ("UPDATE $this->tabela
				SET $this->sol_data_fim = ?
				WHERE $this->sol_codigo = ?");
	
		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1, date('Y-m-d H:i:s'),PDO::PARAM_STR);
			$stmt->bindParam(2, $dados[$this->sol_codigo],PDO::PARAM_STR);
	
			$stmt->execute();
	
			return($stmt);
	
		} catch (PDOException $e)
		{
			throw new PDOException(get_class($this) . $e->getMessage(), $e->getCode());
		}
	
	}
	
	
	#Usado para alterar o status da solicita��o e o problema tecnico do atendente técnico.
	public function alterarStatus($dados)
	{
		$query = ("UPDATE $this->tabela
					SET $this->sta_codigo = ?,
						$this->sol_data_fim = ?,
						$this->pro_codigo_tecnico = ?
					WHERE $this->sol_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1, $dados[$this->sta_codigo],PDO::PARAM_INT);
			$stmt->bindParam(2, date('Y-m-d H:i:s'),PDO::PARAM_STR);
			$stmt->bindParam(3, $dados['pro_codigo_tecnico'],PDO::PARAM_INT);
			$stmt->bindParam(4, $dados[$this->sol_codigo],PDO::PARAM_STR);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException('Tabela de Solicitacao: ' . $e->getMessage(), $e->getCode());
		}

	}

    #Usado para alterar o status da solicita��o e o problema tecnico do solicitante.
    public function alterarStatusSolicitante($dados)
    {
        $query = ("UPDATE $this->tabela
					SET $this->sta_codigo = ?,
						$this->sol_data_fim = ?
					WHERE $this->sol_codigo = ?");

        try
        {
            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1, $dados[$this->sta_codigo],PDO::PARAM_INT);
            $stmt->bindParam(2, date('Y-m-d H:i:s'),PDO::PARAM_STR);
            $stmt->bindParam(3, $dados[$this->sol_codigo],PDO::PARAM_STR);

            $stmt->execute();

            return($stmt);

        } catch (PDOException $e)
        {
            throw new PDOException($e->getMessage(), $e->getCode());
        }

    }

	#Lista a solicita��es do Solicitante
	public function selectSolicitacoesSolicitante($dados)
	{

		$query = ("SELECT SOL.sol_codigo, PRO.pro_descricao, STA.sta_descricao,
				     USU.usu_nome AS Usuario_Solicitante,
				      (SELECT date_format(tea_data_acao,'%d-%m-%Y %H:%i:%s') 
			        	FROM tb_calculo_atendimento 
			        	WHERE sol_codigo = SOL.sol_codigo AND sta_codigo = 1) AS Abertura,
                    (SELECT dep_descricao FROM tb_departamento WHERE dep_codigo = dep_codigo_solicitado) AS DEPTO_Solicitado,
				    substr(sol_descricao_solicitacao,1,60), 
				    (SELECT usu_email FROM tb_usuario WHERE usu_codigo = ATS.usu_codigo_atendente) AS Atendente

				    FROM tb_solicitacao AS SOL
				    #Traz o nome do usuario solicitante
				    INNER JOIN tb_usuario as USU
           			ON usu_codigo_solicitante = USU.usu_codigo
				    #Tabela de Problema, traz a descrição do problema
				    INNER JOIN tb_problema AS PRO
				    ON PRO.pro_codigo = SOL.pro_codigo
				    INNER JOIN tb_status STA
				    ON STA.sta_codigo = SOL.sta_codigo
				    #Tabela de Atendente Solicitacao, traz quem esta atendendo a solicitacao
				    LEFT JOIN tb_atendente_solicitacao AS ATS
				    ON SOL.sol_codigo = ATS.sol_codigo
				    WHERE dep_codigo_solicitado LIKE ?
	                AND SOL.sta_codigo LIKE ?
	                AND SOL.pro_codigo LIKE ?
                    AND usu_nome LIKE ?
                    AND sol_descricao_solicitacao LIKE ?
                    AND USU.dep_codigo = ?
				    ORDER BY SOL.sol_codigo
				    DESC, SOL.sta_codigo DESC
				    LIMIT 500
                    
				");
		try
		{
			$stmt = $this->conexao->prepare($query);

			$array = array("%{$dados[$this->dep_codigo_solicitado]}%",
							"%{$dados[$this->sta_codigo]}%",
							"%{$dados[$this->pro_codigo]}%",
							"%{$dados['usu_nome']}%",
							"%{$dados[$this->sol_descricao_solicitacao]}%",
							   $dados['dep_codigo']);

			$stmt->execute($array);
			
			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}
	
	#Exportar excel sem cortes na tela do Solicitante
	public function exportSolicitacoesSolicitante($dados)
	{
	
		$query = ("SELECT SOL.sol_codigo, PRO.pro_descricao, STA.sta_descricao,
				     USU.usu_nome AS Usuario_Solicitante,
				      (SELECT date_format(tea_data_acao,'%d-%m-%Y %H:%i:%s')
			        	FROM tb_calculo_atendimento
			        	WHERE sol_codigo = SOL.sol_codigo AND sta_codigo = 1) AS Abertura,
                    (SELECT dep_descricao FROM tb_departamento WHERE dep_codigo = dep_codigo_solicitado) AS DEPTO_Solicitado,
				    sol_descricao_solicitacao,
				    (SELECT usu_email FROM tb_usuario WHERE usu_codigo = ATS.usu_codigo_atendente) AS Atendente
				    FROM tb_solicitacao AS SOL
				    #Traz o nome do usuario solicitante
				    INNER JOIN tb_usuario as USU
           			ON usu_codigo_solicitante = USU.usu_codigo
				    #Tabela de Problema, traz a descri��o do problema
				    INNER JOIN tb_problema AS PRO
				    ON PRO.pro_codigo = SOL.pro_codigo
				    INNER JOIN tb_status STA
				    ON STA.sta_codigo = SOL.sta_codigo
				    #Tabela de Atendente Solicitacao, traz quem esta atendendo a solicitacao
				    LEFT JOIN tb_atendente_solicitacao AS ATS
				    ON SOL.sol_codigo = ATS.sol_codigo
				    WHERE dep_codigo_solicitado LIKE ?
	                AND SOL.sta_codigo LIKE ? AND SOL.pro_codigo LIKE ?
                    AND usu_nome LIKE ? AND sol_descricao_solicitacao LIKE ?
                    AND USU.dep_codigo = ?
				    ORDER BY SOL.sol_codigo DESC, SOL.sta_codigo DESC
				    LIMIT 500
	
				");
		try
		{
			$stmt = $this->conexao->prepare($query);
	
			$array = array("%{$dados[$this->dep_codigo_solicitado]}%",
			"%{$dados[$this->sta_codigo]}%",
			"%{$dados[$this->pro_codigo]}%",
			"%{$dados['usu_nome']}%",
			"%{$dados[$this->sol_descricao_solicitacao]}%",
			$dados['dep_codigo']);
	
			$stmt->execute($array);
				
			return($stmt);
	
		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}
	

	#Pega a Descri��o do problema, prioridade e tempo de atendimento
	#Pra cada solicitacao
	public function getPrioridadeTempoAtendimento($sol_codigo)
	{

		$query = ("SELECT SOL.sol_codigo, PRO.pro_descricao, pri_descricao, tat_descricao
					FROM tb_solicitacao AS SOL
					INNER JOIN tb_problema AS PRO
					ON SOL.pro_codigo = PRO.pro_codigo
					INNER JOIN tb_prioridade AS PRI
					ON PRI.pri_codigo = PRO.pri_codigo
					INNER JOIN tb_tempo_atendimento TAT
					ON TAT.tat_codigo = PRI.tat_codigo
					WHERE SOL.sol_codigo = ?
				");
		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$sol_codigo,PDO::PARAM_INT);
				
			$stmt->execute();
				
			return($stmt->fetch());

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}

	public function getStatus($sol_codigo)
	{
		$query = ("SELECT sta_codigo
					FROM tb_solicitacao 
					WHERE sol_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$sol_codigo,PDO::PARAM_INT);
				
			$stmt->execute();
				
			$dados = $stmt->fetch();
				
			return($dados[0]);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}

	}

	public function getDescricaoSolicitacao($sol_codigo)
	{
		$query = ("SELECT sol_descricao_solicitacao
					FROM tb_solicitacao
					WHERE sol_codigo = ?");
	
		try
		{
			$stmt = $this->conexao->prepare($query);
	
			$stmt->bindParam(1,$sol_codigo,PDO::PARAM_INT);
	
			$stmt->execute();
	
			$dados = $stmt->fetch();
	
			return($dados[0]);
	
		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	
	}
	
	public function getUsuarioSolicitante($sol_codigo)
	{
		$query = ("SELECT $this->usu_codigo_solicitante
					FROM tb_solicitacao 
					WHERE sol_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$sol_codigo,PDO::PARAM_INT);
				
			$stmt->execute();
				
			$dados = $stmt->fetch();
				
			return($dados[0]);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}

	}

	#Relat�rio: Chamado por Usuario [Utilizador] 
	public function chamadoPorUsuario($dados)
	{
		$query = ("SELECT SOL.sol_codigo, 
					    concat(USU.usu_nome,' ',USU.usu_sobrenome) AS usu_nome, 
					    min(CAL.tea_data_acao) AS tea_data_acao, SOL.sol_codigo, SOL.sol_descricao_solicitacao,
					    (SELECT sta_descricao FROM tb_status WHERE SOL.sta_codigo = sta_codigo) AS sta_status
					FROM tb_solicitacao AS SOL
					INNER JOIN tb_usuario AS USU
					ON SOL.usu_codigo_solicitante =  USU.usu_codigo
					INNER JOIN tb_calculo_atendimento AS CAL
					ON SOL.sol_codigo = CAL.sol_codigo 
					WHERE USU.usu_nome LIKE ?
					AND SOL.sta_codigo LIKE ?
					GROUP BY SOL.sol_codigo
					ORDER BY 2, 3
            	  ");
		try
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->execute(array("%{$dados['usu_nome']}%",
								"%{$dados['sta_codigo']}%"));

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException('Entre em contato com o Adminstrador. Erro na tabela: '.get_class($this).' '.$e->getMessage(), $e->getCode());
		}
	}
	
	#Relat�rio: Chamado por Area [Departamento] 
	public function chamadoPorArea($dados)
	{
		$query = ("SELECT SOL.sol_codigo, 
					    DEP.dep_descricao AS dep_descricao, 
					    min(CAL.tea_data_acao) AS tea_data_acao, SOL.sol_codigo, SOL.sol_descricao_solicitacao,
					    concat(USU.usu_nome,' ',USU.usu_sobrenome) AS usu_nome, 
					    (SELECT sta_descricao FROM tb_status WHERE SOL.sta_codigo = sta_codigo) AS sta_status
					FROM tb_solicitacao AS SOL
					INNER JOIN tb_departamento AS DEP
					ON SOL.dep_codigo_solicitado = DEP.dep_codigo
					INNER JOIN tb_usuario AS USU
					ON SOL.usu_codigo_solicitante =  USU.usu_codigo
					INNER JOIN tb_calculo_atendimento AS CAL
					ON SOL.sol_codigo = CAL.sol_codigo 
					WHERE DEP.dep_descricao LIKE ?
					GROUP BY SOL.sol_codigo
					ORDER BY 2, 3
            	  ");
		try
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->execute(array("%{$dados['dep_descricao']}%"));

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}
	
	#Relat�rio: Chamado por Periodo [Date de Abertura] 
	public function chamadoPorPeriodo($dados)
	{
		$query = ("SELECT SOL.sol_codigo, 
					    min(CAL.tea_data_acao) AS tea_data_acao, 
              			concat(USU.usu_nome,' ',USU.usu_sobrenome) AS usu_nome, 
                        SOL.sol_codigo, SOL.sol_descricao_solicitacao,
					    (SELECT sta_descricao FROM tb_status WHERE SOL.sta_codigo = sta_codigo) AS sta_status
					FROM tb_solicitacao AS SOL
					INNER JOIN tb_usuario AS USU
					ON SOL.usu_codigo_solicitante =  USU.usu_codigo
					INNER JOIN tb_calculo_atendimento AS CAL
					ON SOL.sol_codigo = CAL.sol_codigo 
					WHERE CAL.tea_data_acao BETWEEN ? AND ?
					AND SOL.sta_codigo LIKE ?
					GROUP BY SOL.sol_codigo
					ORDER BY 2
            	  ");
		try
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$dados['data1'],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados['data2'],PDO::PARAM_STR);
			$stmt->bindParam(3,$dados['sta_codigo'],PDO::PARAM_STR);			
						
			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}
	
	
	#Relat�rio: Chamado por Periodo com calculo de tempo [Date de Abertura] 
	public function chamadoPorPeriodoTempo($dados)
	{
		$query = ("SELECT SOL.sol_codigo, 
			SOL.sol_data_inicio AS DataInicio, SOL.sol_data_fim AS DataFim,
			TIMEDIFF(SOL.sol_data_fim,SOL.sol_data_inicio) AS Tempo,
						(SELECT dep_descricao FROM tb_departamento WHERE dep_codigo =  
							(SELECT dep_codigo FROM tb_usuario where usu_codigo_solicitante = usu_codigo)) AS Departamento,
              			concat(USU.usu_nome,' ',USU.usu_sobrenome) AS usu_nome, 
                        SOL.sol_codigo,  
						(SELECT pro_descricao FROM tb_problema as PRO WHERE SOL.pro_codigo = PRO.pro_codigo) as Problema
						,
					    (SELECT sta_descricao FROM tb_status WHERE SOL.sta_codigo = sta_codigo) AS sta_status,
						(SELECT pri_descricao FROM tb_prioridade
							WHERE pri_codigo = (SELECT pri_codigo FROM tb_problema as PRO WHERE SOL.pro_codigo = PRO.pro_codigo) ) as Prioridade,

					    (SELECT tat_descricao FROM tb_tempo_atendimento WHERE tat_codigo = (select tat_codigo from tb_prioridade
							WHERE pri_codigo = (SELECT pri_codigo FROM tb_problema as PRO WHERE SOL.pro_codigo = PRO.pro_codigo) ) ) as 'SLA',
						(SELECT concat(usu_nome,' ',usu_sobrenome) 
							FROM tb_usuario WHERE usu_codigo =  
									(SELECT usu_codigo_atendente 
										FROM tb_atendente_solicitacao WHERE SOL.sol_codigo = sol_codigo)) as Atendente
					FROM tb_solicitacao AS SOL
					INNER JOIN tb_usuario AS USU
					ON SOL.usu_codigo_solicitante =  USU.usu_codigo
					INNER JOIN tb_calculo_atendimento AS CAL
					ON SOL.sol_codigo = CAL.sol_codigo
					WHERE SOL.sol_data_inicio >= ? AND SOL.sol_data_inicio <= ?
					AND SOL.sta_codigo LIKE ?
					AND dep_codigo_solicitado = ?
					GROUP BY SOL.sol_codigo
					ORDER BY 1 DESC;
            	  ");
		try
		{
			
			$data1 = $dados['data1'].' 00:00:00';
			$data2 = $dados['data2'].' 23:59:59';
			
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$data1,PDO::PARAM_STR);
			$stmt->bindParam(2,$data2,PDO::PARAM_STR);
			$stmt->bindParam(3,$dados['sta_codigo'],PDO::PARAM_STR);			
			$stmt->bindParam(4,$_SESSION['dep_codigo'],PDO::PARAM_INT);						
						
			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}
	
	#Relatorio: chamado por tempo de solu��o de problema
	public function chamadoPorTempoDeSolucao($dados)
	{

		$query = ("SELECT SOL.sol_codigo AS Chamado, SOL.sol_data_inicio AS DataInicio, (CASE SOL.sta_codigo WHEN 2 THEN now() WHEN 3 THEN SOL.sol_data_fim ELSE SOL.sol_data_fim END) AS DataFim,
	   				TIMEDIFF((CASE SOL.sta_codigo WHEN 2 THEN now() WHEN 3 THEN SOL.sol_data_fim ELSE SOL.sol_data_fim END),SOL.sol_data_inicio) AS TempoTotal,
					(SELECT dep_descricao FROM tb_departamento WHERE dep_codigo =
						(SELECT dep_codigo FROM tb_usuario where usu_codigo_solicitante = usu_codigo)) AS Departamento,
							USU.usu_nome AS Usuario,
								/* (SELECT pro_descricao FROM tb_problema as PRO WHERE SOL.pro_codigo = PRO.pro_codigo) as 'Problema Usuario', */
								(SELECT pro_descricao FROM tb_problema as PRO WHERE SOL.pro_codigo_tecnico = PRO.pro_codigo) as ProblemaTecnico,
								/* (SELECT pro_tempo_solucao FROM tb_problema as PRO WHERE SOL.pro_codigo = PRO.pro_codigo) as 'Tempo Usuario',	*/
								(SELECT pro_tempo_solucao FROM tb_problema as PRO WHERE SOL.pro_codigo_tecnico = PRO.pro_codigo) as 'Tempo Tecnico',
								    (SELECT sta_descricao FROM tb_status WHERE SOL.sta_codigo = sta_codigo) AS 'Status',
										(SELECT pri_descricao FROM tb_prioridade
											WHERE pri_codigo = (SELECT pri_codigo FROM tb_problema as PRO WHERE SOL.pro_codigo_tecnico = PRO.pro_codigo) ) as Prioridade,
								(SELECT tat_descricao FROM tb_tempo_atendimento WHERE tat_codigo = (select tat_codigo from tb_prioridade
										WHERE pri_codigo = (SELECT pri_codigo FROM tb_problema as PRO WHERE SOL.pro_codigo_tecnico = PRO.pro_codigo) ) ) as 'SLA',

						(SELECT usu_nome FROM tb_usuario WHERE usu_codigo = ATS.usu_codigo_atendente) Atendente,
				
						#Calcula a diferenca entre a data de inicio e fim e o tempo do problema do usuario
						/* TIMEDIFF(TIMEDIFF(SOL.sol_data_fim,SOL.sol_data_inicio),
								(SELECT pro_tempo_solucao FROM tb_problema as PRO 
									WHERE SOL.pro_codigo = PRO.pro_codigo)) AS 'DIFF TIME - USUARIO', */
						#Calcula a diferenca entre a data de inicio e fim e o tempo do problema indicado pelo tecnico
						TIMEDIFF(TIMEDIFF((CASE SOL.sta_codigo WHEN 2 THEN now() WHEN 3 THEN SOL.sol_data_fim ELSE SOL.sol_data_fim END),SOL.sol_data_inicio),
								(SELECT pro_tempo_solucao FROM tb_problema as PRO 
									WHERE SOL.pro_codigo_tecnico = PRO.pro_codigo)) AS 'DIFF TIME - TECNICO',
							concat(SOL.sol_data_inicio , ' | ', (CASE SOL.sta_codigo WHEN 2 THEN now() WHEN 3 THEN SOL.sol_data_fim ELSE SOL.sol_data_fim END)) as 'TempoSolucao',
							concat(SOL.sol_data_inicio , ' | ', (CASE SOL.sta_codigo WHEN 2 THEN now() WHEN 3 THEN SOL.sol_data_fim ELSE SOL.sol_data_fim END),' | ',
									(SELECT pro_tempo_solucao 
										FROM tb_problema as PRO 
										WHERE SOL.pro_codigo_tecnico = PRO.pro_codigo)) as 'Dentro/Fora SLA'
					FROM tb_solicitacao AS SOL
					INNER JOIN tb_usuario AS USU
					ON SOL.usu_codigo_solicitante =  USU.usu_codigo
					INNER JOIN tb_calculo_atendimento AS CAL
					ON SOL.sol_codigo = CAL.sol_codigo
					INNER JOIN tb_problema as PRO
					ON SOL.pro_codigo_tecnico = PRO.pro_codigo
					INNER JOIN tb_atendente_solicitacao AS ATS
					ON SOL.sol_codigo = ATS.sol_codigo 
					WHERE SOL.sol_data_inicio >= ? AND SOL.sol_data_inicio <= ?
					AND SOL.sta_codigo LIKE ?
					AND dep_codigo_solicitado = ?
					AND PRO.pri_codigo LIKE ?
					AND ATS.usu_codigo_atendente LIKE ?
					AND SOL.pro_codigo_tecnico LIKE ?
					GROUP BY SOL.sol_codigo
					ORDER BY 1 DESC;");
		try
		{
				
			$data1 = $dados['data1'].' 00:00:01';
			$data2 = $dados['data2'].' 23:59:59';
				
			$stmt = $this->conexao->prepare($query);
				
			$stmt->bindParam(1,$data1,PDO::PARAM_STR);
			$stmt->bindParam(2,$data2,PDO::PARAM_STR);
			$stmt->bindParam(3,$dados['sta_codigo'],PDO::PARAM_STR);
			$stmt->bindParam(4,$_SESSION['dep_codigo'],PDO::PARAM_INT);
			$stmt->bindParam(5,$dados['pri_codigo'],PDO::PARAM_INT);
			$stmt->bindParam(6,$dados['usu_codigo_atendente'],PDO::PARAM_INT);
            $stmt->bindParam(7,$dados['pro_codigo'],PDO::PARAM_INT);

			$stmt->execute();
	
		return($stmt->fetchAll(\PDO::FETCH_ASSOC));
	
		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}

    #Relatorio: tempo de solucao com tempo envio de terceiro
    public function chamadoPorTempoDeSolucaoEnvioTerceiro($dados)
    {

        $query = ("SELECT SOL.sol_codigo AS Chamado, SOL.sol_data_inicio AS DataInicio,
	(CASE SOL.sta_codigo WHEN 2 THEN now() WHEN 3 THEN SOL.sol_data_fim ELSE SOL.sol_data_fim END) AS DataFim,
	   				TIMEDIFF((CASE SOL.sta_codigo WHEN 2 THEN now() WHEN 3 THEN SOL.sol_data_fim ELSE SOL.sol_data_fim END),SOL.sol_data_inicio) AS TempoTotal,
					/* (SELECT dep_descricao FROM tb_departamento WHERE dep_codigo =
 						(SELECT dep_codigo FROM tb_usuario where usu_codigo_solicitante = usu_codigo)) AS Departamento,
							USU.usu_nome AS Usuario, */
								(SELECT pro_descricao FROM tb_problema as PRO WHERE SOL.pro_codigo_tecnico = PRO.pro_codigo) as ProblemaTecnico,
								(SELECT pro_tempo_solucao FROM tb_problema as PRO WHERE SOL.pro_codigo_tecnico = PRO.pro_codigo) as 'Tempo Tecnico',
								    (SELECT sta_descricao FROM tb_status WHERE SOL.sta_codigo = sta_codigo) AS 'Status',
										(SELECT pri_descricao FROM tb_prioridade
											WHERE pri_codigo = (SELECT pri_codigo FROM tb_problema as PRO WHERE SOL.pro_codigo_tecnico = PRO.pro_codigo) ) as Prioridade,
								(SELECT tat_descricao FROM tb_tempo_atendimento WHERE tat_codigo = (select tat_codigo from tb_prioridade
										WHERE pri_codigo = (SELECT pri_codigo FROM tb_problema as PRO WHERE SOL.pro_codigo_tecnico = PRO.pro_codigo) ) ) as 'SLA',
						(SELECT usu_nome FROM tb_usuario WHERE usu_codigo = ATS.usu_codigo_atendente) Atendente,
						TIMEDIFF(TIMEDIFF((CASE SOL.sta_codigo WHEN 2 THEN now() WHEN 3 THEN SOL.sol_data_fim ELSE SOL.sol_data_fim END),SOL.sol_data_inicio),
								(SELECT pro_tempo_solucao FROM tb_problema as PRO
									WHERE SOL.pro_codigo_tecnico = PRO.pro_codigo)) AS 'DIFF TIME - TECNICO',
							concat(SOL.sol_data_inicio , ' | ',
									(CASE SOL.sta_codigo WHEN 2 THEN now() WHEN 3 THEN SOL.sol_data_fim ELSE SOL.sol_data_fim END)) as 'TempoSolucao',

                          ifnull((SELECT sec_to_time(SUM((time_to_sec(sot_tempo_util))))
							FROM tb_solicitacao_terceiro AS TER
							WHERE TER.sol_codigo = SOL.sol_codigo),'00:00:00') AS TempoUtilTerceiro,

							concat(SOL.sol_data_inicio , ' | ',
									(CASE SOL.sta_codigo WHEN 2 THEN now() WHEN 3 THEN SOL.sol_data_fim ELSE SOL.sol_data_fim END),' | ',
									(SELECT pro_tempo_solucao
										FROM tb_problema as PRO
										WHERE SOL.pro_codigo_tecnico = PRO.pro_codigo) ,' | ',
						ifnull((SELECT sec_to_time(SUM((time_to_sec(sot_tempo_util))))
									FROM tb_solicitacao_terceiro AS TER
									WHERE TER.sol_codigo = SOL.sol_codigo),'00:00:00')
						) as 'Dentro/Fora SLA'

					FROM tb_solicitacao AS SOL
					INNER JOIN tb_usuario AS USU
					ON SOL.usu_codigo_solicitante =  USU.usu_codigo
					INNER JOIN tb_calculo_atendimento AS CAL
					ON SOL.sol_codigo = CAL.sol_codigo
					INNER JOIN tb_problema as PRO
					ON SOL.pro_codigo_tecnico = PRO.pro_codigo
					INNER JOIN tb_atendente_solicitacao AS ATS
					ON SOL.sol_codigo = ATS.sol_codigo
					WHERE SOL.sol_data_inicio >= ? AND SOL.sol_data_inicio <= ?
					AND SOL.sta_codigo LIKE ?
					AND dep_codigo_solicitado = ?
					AND PRO.pri_codigo LIKE ?
					AND ATS.usu_codigo_atendente LIKE ?
					AND SOL.pro_codigo_tecnico LIKE ?
					GROUP BY SOL.sol_codigo
					ORDER BY 1 DESC;");
        try
        {

            $data1 = $dados['data1'].' 00:00:01';
            $data2 = $dados['data2'].' 23:59:59';

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$data1,PDO::PARAM_STR);
            $stmt->bindParam(2,$data2,PDO::PARAM_STR);
            $stmt->bindParam(3,$dados['sta_codigo'],PDO::PARAM_STR);
            $stmt->bindParam(4,$_SESSION['dep_codigo'],PDO::PARAM_INT);
            $stmt->bindParam(5,$dados['pri_codigo'],PDO::PARAM_INT);
            $stmt->bindParam(6,$dados['usu_codigo_atendente'],PDO::PARAM_INT);
            $stmt->bindParam(7,$dados['pro_codigo'],PDO::PARAM_INT);

            $stmt->execute();

            return($stmt->fetchAll(\PDO::FETCH_ASSOC));

        } catch (PDOException $e)
        {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }


    public function chamadoPorPrioridade($dados)
	{
			$query = ("SELECT 
						    (SELECT 
						        (SELECT PRI.pri_descricao  
						            FROM tb_prioridade PRI 
						            WHERE PRI.pri_codigo = PRO.pri_codigo
						        ) 
						        FROM tb_problema PRO 
						        WHERE PRO.pro_codigo = SOL.pro_codigo
						     ) Prioridade,
						    (SELECT min(CAL.tea_data_acao) 
						       FROM tb_calculo_atendimento CAL
						       WHERE CAL.sol_codigo = SOL.sol_codigo 
						    ) DataCriacao,
						    (SELECT concat(USU.usu_nome,' ',USU.usu_sobrenome) 
						        FROM tb_usuario USU 
						        WHERE SOL.usu_codigo_solicitante = USU.usu_codigo
						    ) Usuario,
						    (SELECT dep_descricao 
						        FROM tb_departamento DEP 
						        WHERE SOL.dep_codigo_solicitado = DEP.dep_codigo
						    ) Departamento,
						            SOL.sol_codigo, SOL.sol_descricao_solicitacao,  
						    (SELECT sta_descricao 
						        FROM tb_status 
						        WHERE SOL.sta_codigo = sta_codigo) sta_status
						
						FROM tb_solicitacao SOL
						WHERE SOL.sta_codigo LIKE ?
						ORDER BY 1,2
            	  ");
		try
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$dados['sta_codigo'],PDO::PARAM_STR);			

						
			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}
	
	
	#Utilizado no Painel de Chamado 
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $dados
	 * @throws PDOException
	 * @example Mostra a quantidade de chamados por status
	 */
	public function totalChamadoStatusAreaPainel($dados)
	{
		$query = ("SELECT count(*)
					FROM tb_solicitacao
					WHERE dep_codigo_solicitado = ?
					AND sta_codigo = ?
					ORDER BY sol_codigo
            	  ");
		try
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->execute(array("{$dados['dep_codigo']}",
								 "{$dados['sta_codigo']}"));

			return($stmt->fetch());

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}
	
	
	#Utilizado no Painel de Chamado
	/**
	 *
	 * Enter description here ...
	 * @param  $dados array
	 * @throws PDOException
	 * @example Mostra a quantidade de chamados por status do dia 
	 */
	public function totalChamadoFechadosDoDia($dados)
	{
		$query = ("SELECT count(sol_codigo) AS 'Total' FROM tb_solicitacao
					WHERE sta_codigo = ?
					AND dep_codigo_solicitado = ?
					AND sol_data_fim >= ? AND sol_data_fim <= ?;
            	  ");
		try
		{
			$stmt = $this->conexao->prepare($query);
				
			$stmt->execute(array("{$dados['sta_codigo']}",
								 "{$dados['dep_codigo']}",
								 "{$dados['data1']}",
								 "{$dados['data2']}"));
	

			$dados = $stmt->fetch();
			
			return($dados[0]);
	
		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}
	
	#Usado na validacao de data de abertura de Envio pra terceiro
	public function getDataAbertura($sol_codigo)
	{
		$query = ("SELECT $this->sol_data_inicio 
						FROM $this->tabela
					WHERE $this->sol_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1, $sol_codigo, PDO::PARAM_INT);
			
			$stmt->execute();		
		
			$dados = $stmt->fetch(PDO::FETCH_ASSOC);
						
			return($dados['sol_data_inicio']);
		
		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}


	#Grafico: Chamado por departamento no periodo
	public function graficoTopTenChamadoAbertoPorArea($dados)
	{
		$query = ("SELECT (SELECT dep_descricao FROM tb_departamento WHERE dep_codigo = (SELECT dep_codigo
								FROM tb_usuario
								WHERE usu_codigo =  usu_codigo_solicitante)) AS departamento, count(sol_codigo) AS QTD
					FROM tb_solicitacao
					WHERE dep_codigo_solicitado = ?
					AND sol_data_inicio >= ?
					AND sol_data_inicio <= ?
					GROUP BY 1
					ORDER BY 2 DESC
					LIMIT 10;");

		try
		{

			$data1 = $dados['data1'].' 00:00:01';
			$data2 = $dados['data2'].' 23:59:59';

			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$_SESSION['dep_codigo'],PDO::PARAM_INT);
			$stmt->bindParam(2,$data1,PDO::PARAM_STR);
			$stmt->bindParam(3,$data2,PDO::PARAM_STR);


			$stmt->execute();

			foreach ($stmt as $value){
				echo '[',"'",$value[0],"'",',',$value[1],'],';
			}

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}

	#Mostrar os chamados para avaliacao.
	public function avaliacaoSolicitacao($dados)
	{

		$query = ("SELECT SOL.sol_codigo, substr(PRO.pro_descricao,1,60), STA.sta_descricao,
							substr(sol_descricao_solicitacao,1,60),
				    (SELECT dep_descricao FROM tb_departamento WHERE dep_codigo = SOL.dep_codigo_solicitado) AS Departamento_Solicitante,
				    (SELECT usu_email FROM tb_usuario WHERE usu_codigo = ATS.usu_codigo_atendente) AS Atendente,
	                (SELECT date_format(tea_data_acao,'%d-%m-%Y %H:%i:%s')
                    FROM tb_calculo_atendimento
                    WHERE sol_codigo = SOL.sol_codigo AND sta_codigo = 1) AS Abertura
				    FROM tb_solicitacao AS SOL
				    #Traz o nome do usuario solicitante
				    INNER JOIN tb_usuario as USU
           			ON usu_codigo_solicitante = USU.usu_codigo
				    #Tabela de Problema, traz a descricao do problema
				    INNER JOIN tb_problema AS PRO
				    ON PRO.pro_codigo = SOL.pro_codigo
				    INNER JOIN tb_status STA
				    ON STA.sta_codigo = SOL.sta_codigo
				    #Tabela de Atendente Solicitacao, traz quem esta atendendo a solicitacao
				    LEFT JOIN tb_atendente_solicitacao AS ATS
				    ON SOL.sol_codigo = ATS.sol_codigo
				    WHERE SOL.sta_codigo = ?
                    AND usu_codigo_solicitante = ?
                    AND sol_data_fim > ?
                    AND avaliacao_id IS NULL
				    ORDER BY SOL.sol_codigo DESC
				    ");
		try
		{
			$stmt = $this->conexao->prepare($query);

			$array = array("{$dados['sta_codigo']}",
						   "{$dados['usu_codigo_solicitante']}",
						   "{$dados['sol_data_fim']}");

			$stmt->execute($array);

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}


	public function createAvaliacao($dados)
	{
		$query = ("UPDATE tb_solicitacao
					SET avaliacao_date = ?,
						avaliacao_id = ?,
					 	avaliacao_descricao = ?
					WHERE sol_codigo = ?");

		try{

			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,date('Y-m-d H:i:s'),\PDO::PARAM_STR);
			$stmt->bindParam(2,$dados['avaliacao_id'],\PDO::PARAM_INT);
			$stmt->bindParam(3,$dados['avaliacao_descricao'],\PDO::PARAM_STR);
			$stmt->bindParam(4,$dados['sol_codigo'],\PDO::PARAM_INT);

			$stmt->execute();

			return $stmt;

		}catch(\PDOException $e){
			throw new \PDOException($e->getMessage(),$e->getCode());
		}

	}

	#usado para listar o chamado no relatorio de avaliacao
	public function listarChamadoParaAvaliacao($dados)
	{
		$query = ("SELECT SOL.sol_codigo, sol_data_inicio, sol_data_fim, avaliacao_date, USU.usu_nome, DEP.dep_descricao, USU_ATE.usu_nome,
						   (SELECT pro_descricao FROM tb_problema WHERE pro_codigo = SOL.pro_codigo) AS 'problema',
						   (SELECT pro_descricao FROM tb_problema WHERE pro_codigo = SOL.pro_codigo_tecnico) AS 'problema_tecnico',
						avaliacao_id, AVA.descricao, SOL.avaliacao_descricao
					FROM tb_solicitacao AS SOL
					INNER JOIN tb_usuario as USU
						ON SOL.usu_codigo_solicitante = USU.usu_codigo
					INNER JOIN tb_departamento AS DEP
						ON USU.dep_codigo = DEP.dep_codigo
					INNER JOIN avaliacao AS AVA
						ON SOL.avaliacao_id = AVA.id
					LEFT JOIN tb_atendente_solicitacao AS ATE
						ON SOL.sol_codigo = ATE.sol_codigo
					LEFT JOIN tb_usuario AS USU_ATE
						ON ATE.usu_codigo_atendente = USU_ATE.usu_codigo
					WHERE avaliacao_id IS NOT NULL
						AND SOL.sta_codigo = ?
						AND SOL.dep_codigo_solicitado = ?
						AND avaliacao_date > ?
						AND avaliacao_date < ?
						AND DEP.dep_codigo LIKE ?
						AND SOL.pro_codigo_tecnico LIKE ?
						AND ATE.usu_codigo_atendente LIKE ?
					ORDER BY sol_codigo DESC;");

		try{

			$stmt = $this->conexao->prepare($query);

			$dados['data1'] = $dados['data1'].' 00:00:01';
			$dados['data2'] = $dados['data2'].' 23:59:59';

			$stmt->bindParam(1,$dados['sta_codigo'],\PDO::PARAM_INT);
			$stmt->bindParam(2,$dados['dep_codigo_solicitado'],\PDO::PARAM_INT);
			$stmt->bindParam(3,$dados['data1'],\PDO::PARAM_STR);
			$stmt->bindParam(4,$dados['data2'],\PDO::PARAM_STR);
			$stmt->bindParam(5,$dados['dep_codigo'],\PDO::PARAM_STR);
			$stmt->bindParam(6,$dados['pro_codigo_tecnico'],\PDO::PARAM_STR);
			$stmt->bindParam(7,$dados['usu_codigo'],\PDO::PARAM_STR);

			$stmt->execute();

			return $stmt;

		}catch(\PDOException $e){
			throw new \PDOException($e->getMessage(),$e->getCode());
		}

	}


	#usado para listar o chamado para marcalos como nao avaliado no script automatico
	public function marcarChamadoComoNaoAvaliado($dados)
	{
		$query = ("UPDATE tb_solicitacao
					SET avaliacao_id = 4,
						avaliacao_date = ?
					WHERE sta_codigo = 3
					AND avaliacao_id IS NULL
					AND sol_data_fim < ?");

		try{

			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,date('Y-m-d H:i:s'),\PDO::PARAM_STR);
			$stmt->bindParam(2,$dados['data'],\PDO::PARAM_STR);

			$stmt->execute();

			return $stmt;

		}catch(\PDOException $e){
			throw new \PDOException($e->getMessage(),$e->getCode());
		}

	}

	#usado para listar o chamado no grafico relatorio de avaliacao
	public function getGraficoChamadoParaAvaliacao($dados)
	{
		$query = ("SELECT AVA.descricao, count(avaliacao_id)
						FROM tb_solicitacao AS SOL
						INNER JOIN tb_usuario as USU
								ON SOL.usu_codigo_solicitante = USU.usu_codigo
						INNER JOIN tb_departamento AS DEP
								ON USU.dep_codigo = DEP.dep_codigo
						INNER JOIN avaliacao AS AVA
								ON SOL.avaliacao_id = AVA.id
						LEFT JOIN tb_atendente_solicitacao AS ATE
								ON SOL.sol_codigo = ATE.sol_codigo
						LEFT JOIN tb_usuario AS USU_ATE
								ON ATE.usu_codigo_atendente = USU_ATE.usu_codigo
						WHERE avaliacao_id IS NOT NULL
								AND SOL.sta_codigo = ?
								AND SOL.dep_codigo_solicitado = ?
								AND avaliacao_date > ?
								AND avaliacao_date < ?
								AND DEP.dep_codigo LIKE ?
								AND SOL.pro_codigo_tecnico LIKE ?
								AND ATE.usu_codigo_atendente LIKE ?
									GROUP BY AVA.descricao
						ORDER BY 2 DESC;");

		try{

			$stmt = $this->conexao->prepare($query);

			$dados['data1'] = $dados['data1'].' 00:00:01';
			$dados['data2'] = $dados['data2'].' 23:59:59';


			$stmt->bindParam(1,$dados['sta_codigo'],\PDO::PARAM_INT);
			$stmt->bindParam(2,$dados['dep_codigo_solicitado'],\PDO::PARAM_INT);
			$stmt->bindParam(3,$dados['data1'],\PDO::PARAM_STR);
			$stmt->bindParam(4,$dados['data2'],\PDO::PARAM_STR);
			$stmt->bindParam(5,$dados['dep_codigo'],\PDO::PARAM_STR);
			$stmt->bindParam(6,$dados['pro_codigo_tecnico'],\PDO::PARAM_STR);
			$stmt->bindParam(7,$dados['usu_codigo'],\PDO::PARAM_STR);

			$stmt->execute();

			foreach ($stmt as $value){
				echo '[',"'",$value[0],"'",',',$value[1],'],';
			}

		}catch(\PDOException $e){
			throw new \PDOException($e->getMessage(),$e->getCode());
		}

	}

}
?>