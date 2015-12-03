<?php

class TbProjeto extends Banco
{

	private $tabela = 'tb_projeto';
	private $pro_codigo = 'pro_codigo';
	private $pro_cod_projeto = 'pro_cod_projeto';
	private $pro_titulo = 'pro_titulo';
	private $usu_codigo_solicitante = 'usu_codigo_solicitante';
	private $usu_codigo_responsavel = 'usu_codigo_responsavel';
	private $pro_previsao_inicio = 'pro_previsao_inicio';
	private $pro_previsao_fim = 'pro_previsao_fim';
	private $stp_codigo = 'stp_codigo';
	private $pro_descricao = 'pro_descricao';
	private $usu_codigo_criador = 'usu_codigo_criador';
	private $pro_data_cadastro = 'pro_data_cadastro';
	private $dep_codigo = 'dep_codigo';
	private $pro_data_inicio = 'pro_data_inicio';
	private $pro_data_final = 'pro_data_final';
	private $pro_observacao = 'pro_observacao';
	private $pro_local_armazenado = 'pro_local_armazenado';


	public function insert($dados)
	{

		$query = ("INSERT INTO $this->tabela
					($this->pro_cod_projeto, $this->pro_titulo, $this->usu_codigo_solicitante,
					$this->pro_previsao_inicio, $this->pro_previsao_fim, $this->stp_codigo,
					$this->pro_descricao, $this->usu_codigo_criador, $this->dep_codigo,
					$this->usu_codigo_responsavel, $this->pro_observacao, $this->pro_local_armazenado)
					VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
						
					$this->usu_codigo_criador = $_SESSION['usu_codigo'];


					try
					{
						$stmt = $this->conexao->prepare($query);

						$stmt->bindParam(1,$dados[$this->pro_cod_projeto],PDO::PARAM_STR);
						$stmt->bindParam(2,$dados[$this->pro_titulo],PDO::PARAM_STR);
						$stmt->bindParam(3,$dados[$this->usu_codigo_solicitante],PDO::PARAM_INT);
						$stmt->bindParam(4,$dados[$this->pro_previsao_inicio],PDO::PARAM_STR);
						$stmt->bindParam(5,$dados[$this->pro_previsao_fim],PDO::PARAM_STR);
						$stmt->bindParam(6,$dados[$this->stp_codigo],PDO::PARAM_INT);
						$stmt->bindParam(7,$dados[$this->pro_descricao],PDO::PARAM_STR);
						$stmt->bindParam(8,$this->usu_codigo_criador,PDO::PARAM_INT);
						$stmt->bindParam(9,$dados[$this->dep_codigo],PDO::PARAM_INT);
						$stmt->bindParam(10,$dados[$this->usu_codigo_responsavel],PDO::PARAM_INT);
						$stmt->bindParam(11,$dados[$this->pro_observacao],PDO::PARAM_STR);
						$stmt->bindParam(12,$dados[$this->pro_local_armazenado],PDO::PARAM_STR);

						$stmt->execute();

						$this->pro_codigo = $this->conexao->lastInsertId();

						return($this->pro_codigo);

					}
					catch (PDOException $e)
					{
						throw new PDOException("Erro na tabela". get_class($this)."-". $e->getMessage(),$e->getCode());
					}

	}

	public function codigoProjeto()
	{
		$query = ("SELECT max($this->pro_codigo) 
					FROM $this->tabela");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->execute();
			$valor = $stmt->fetch();
			
			$ano = date("Y");
			$mes = date("m");
			$dia = date("d");

			$codigo_projeto = $ano.$mes."00".$valor[0];

			return($codigo_projeto);
		}
		catch (PDOException $e)
		{
			throw new PDOException("Erro na tabela". get_class($this)."-". $e->getMessage(),$e->getCode());
		}

	}

	public function selectMeusProjetosAndamento($dep_codigo)
	{
		$query = ("SELECT
		           P.PRO_CODIGO,
                   P.PRO_COD_PROJETO AS C�digo, 
                   P.PRO_TITULO AS Titulo,
                   P.PRO_DESCRICAO AS Descri��o,
                   P.PRO_PREVISAO_INICIO,
                   P.PRO_PREVISAO_FIM,
                   concat(U.USU_NOME, ' ', U.USU_SOBRENOME) AS Usu�rio,
                   S.STP_DESCRICAO AS Status
                   FROM tb_projeto AS P
                   JOIN tb_usuario AS U
                   ON U.USU_CODIGO = P.USU_CODIGO
                   JOIN tb_status_projeto AS S
                   ON S.STP_CODIGO = P.STP_CODIGO
                   WHERE P.DEP_CODIGO = ? AND P.STP_CODIGO = 2");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dep_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}

	public function selectMeusProjetosCancelados($dep_codigo)
	{
		$query = ("SELECT
		           P.PRO_CODIGO,
                   P.PRO_COD_PROJETO AS C�digo, 
                   P.PRO_TITULO AS Titulo,
                   P.PRO_DESCRICAO AS Descri��o,
                   P.PRO_PREVISAO_INICIO,
                   P.PRO_PREVISAO_FIM,
                   concat(U.USU_NOME, ' ', U.USU_SOBRENOME) AS Usu�rio,
                   S.STP_DESCRICAO AS Status
                   FROM tb_projeto AS P
                   JOIN tb_usuario AS U
                   ON U.USU_CODIGO = P.USU_CODIGO
                   JOIN tb_status_projeto AS S
                   ON S.STP_CODIGO = P.STP_CODIGO
                   WHERE P.DEP_CODIGO = ? AND P.STP_CODIGO = 3");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dep_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}

	public function selectMeusProjetosConcluidos($dep_codigo)
	{
		$query = ("SELECT
		           P.PRO_CODIGO,
                   P.PRO_COD_PROJETO AS C�digo, 
                   P.PRO_TITULO AS Titulo,
                   P.PRO_DESCRICAO AS Descri��o,
                   P.PRO_PREVISAO_INICIO,
                   P.PRO_PREVISAO_FIM,
                   concat(U.USU_NOME, ' ', U.USU_SOBRENOME) AS Usu�rio,
                   S.STP_DESCRICAO AS Status
                   FROM tb_projeto AS P
                   JOIN tb_usuario AS U
                   ON U.USU_CODIGO = P.USU_CODIGO
                   JOIN tb_status_projeto AS S
                   ON S.STP_CODIGO = P.STP_CODIGO
                   WHERE P.DEP_CODIGO = ? AND P.STP_CODIGO = 4");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dep_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}

	public function selectMeusProjetosAprovacao($dep_codigo)
	{
		$query = ("SELECT
		           P.PRO_CODIGO,
                   P.PRO_COD_PROJETO AS C�digo, 
                   P.PRO_TITULO AS Titulo,
                   P.PRO_DESCRICAO AS Descri��o,
                   P.PRO_PREVISAO_INICIO,
                   P.PRO_PREVISAO_FIM,
                   concat(U.USU_NOME, ' ', U.USU_SOBRENOME) AS Usu�rio,
                   S.STP_DESCRICAO AS Status
                   FROM tb_projeto AS P
                   JOIN tb_usuario AS U
                   ON U.USU_CODIGO = P.USU_CODIGO
                   JOIN tb_status_projeto AS S
                   ON S.STP_CODIGO = P.STP_CODIGO
                   WHERE P.DEP_CODIGO = ? AND P.STP_CODIGO = 1");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dep_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}

	public function aprovarProjeto($dados)
	{
		$query = ("UPDATE $this->tabela
						SET $this->stp_codigo = ? 
						WHERE $this->pro_codigo = ? ");
		$dados['stp_codigo'] = 2;

		try{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1, $dados['stp_codigo'], PDO::PARAM_INT);
			$stmt->bindParam(2, $dados['pro_codigo'], PDO::PARAM_INT);

			$stmt->execute();
		}
		catch (PDOException $e)
		{
			throw new PDOException("Erro na tabela". get_class($this)."-". $e->getMessage(),$e->getCode());
		}

	}

	public function listarProjeto($dados)
	{
		$query = ("SELECT pro_codigo, pro_cod_projeto, pro_titulo,
			        	(SELECT usu_nome FROM tb_usuario WHERE usu_codigo = usu_codigo_solicitante) AS Usuario,
			        	date_format(pro_previsao_inicio,'%d/%m/%Y') AS pro_previsao_inicio, 
			        	date_format(pro_previsao_fim,'%d/%m/%Y') AS pro_previsao_fim,
			        	(SELECT stp_descricao FROm tb_status_projeto WHERE stp_codigo = PRO.stp_codigo) AS stp_descricao
					FROM tb_projeto AS PRO
					WHERE stp_codigo LIKE ?
					AND pro_titulo LIKE ?
					AND pro_descricao LIKE ?
					AND dep_codigo = ?
					ORDER BY 1 DESC"
					);

					try
					{
						$stmt = $this->conexao->prepare($query);

						$stmt->execute(array("{$dados[$this->stp_codigo]}",
								 			"%{$dados[$this->pro_titulo]}%",
								 			"%{$dados[$this->pro_descricao]}%",
								  			 "{$dados[$this->dep_codigo]}"
											 )
									   );

						return($stmt);

					} catch (PDOException $e)
					{
						throw new PDOException($e->getMessage(),$e->getCode());
					}
	}

	public function update($dados)
	{
		$query = ("UPDATE $this->tabela
					SET $this->pro_titulo = ?,
					$this->usu_codigo_solicitante = ?,
					$this->pro_previsao_inicio = ?,
					$this->pro_previsao_fim = ?,
					$this->stp_codigo = ?,
					$this->pro_descricao = ?
					
					WHERE $this->pro_codigo = ? ");
						
					try
					{
						$stmt = $this->conexao->prepare($query);

						$stmt->bindParam(1,$dados[$this->pro_titulo],PDO::PARAM_STR);
						$stmt->bindParam(2,$dados[$this->usu_codigo_solicitante],PDO::PARAM_INT);
						$stmt->bindParam(3,$dados[$this->pro_previsao_inicio],PDO::PARAM_STR);
						$stmt->bindParam(4,$dados[$this->pro_previsao_fim],PDO::PARAM_STR);
						$stmt->bindParam(5,$dados[$this->stp_codigo],PDO::PARAM_INT);
						$stmt->bindParam(6,$dados[$this->pro_descricao],PDO::PARAM_STR);
						$stmt->bindParam(7,$dados[$this->pro_codigo],PDO::PARAM_INT);
							
						$stmt->execute();

						return($stmt);

					} catch (PDOException $e)
					{
						throw new PDOException($e->getMessage(),$e->getCode());
					}

	}

	public function getFormAlteracao($pro_codigo)
	{
		$query = ("SELECT * FROM $this->tabela
					WHERE $this->pro_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$pro_codigo,PDO::PARAM_INT);

			$stmt->execute();

			$dados = $stmt->fetch();

			return($dados);

		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function getStatusProjeto($pro_codigo)
	{
		$query = ("SELECT $this->stp_codigo 
					FROM $this->tabela
					WHERE $this->pro_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$pro_codigo,PDO::PARAM_INT);

			$stmt->execute();

			$dados = $stmt->fetch();

			return($dados[0]);


		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function listarProjetoAtivo($dep_codigo)
	{
		$query = ("SELECT pro_codigo, pro_titulo
					FROM tb_projeto 
					WHERE stp_codigo IN(1,2)
					AND dep_codigo = ?
					ORDER BY pro_titulo");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dep_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	#Utilizado na tela de pesquisar Atividade
	public function listarProjetoTodos($dep_codigo)
	{
		$query = ("SELECT pro_codigo, pro_titulo
					FROM tb_projeto 
					WHERE dep_codigo = ?
					ORDER BY pro_titulo
				 ");

		try
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$dep_codigo,PDO::PARAM_INT);
			
			$stmt->execute();

			return($stmt);

		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function listarProjetoAlteracaoAtividade($dep_codigo)
	{
		$query = ("SELECT pro_codigo, pro_titulo
					FROM tb_projeto 
					WHERE stp_codigo != 1
					AND dep_codigo = ?
					ORDER BY 1 DESC
				 ");

		try
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$dep_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	#Usado no Painel de Projetos
	public function listarProjetosPainel($dados)
	{
		
		$query = ("SELECT PRO.pro_codigo, substr(PRO.pro_titulo,1,30) AS Titulo , 
					(SELECT substr(at_descricao,1,35) 
						FROM tb_atividade 
							WHERE at_codigo = max(ATV.at_codigo)) AS 'Descricao Atividae', 
								max(APO.ap_data_criacao) AS 'Data Apontamento', DATEDIFF(now(),PRO.pro_previsao_inicio) AS 'Dias'
					FROM tb_projeto AS PRO
					LEFT JOIN tb_atividade AS ATV
					ON PRO.pro_codigo = ATV.pro_codigo
					LEFT JOIN tb_apontamento AS APO
					ON ATV.at_codigo = APO.at_codigo
					WHERE PRO.dep_codigo = ?
					AND PRO.stp_codigo LIKE ?
					GROUP BY PRO.pro_codigo
					ORDER BY 4 DESC;");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->execute(array("{$dados[$this->dep_codigo]}",
					 			 "{$dados[$this->stp_codigo]}"
								 )
						   );

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}

	#Usado no Painel de Projetos
	public function totalProjetosStatusPainel($dados)
	{
		
		$query = ("SELECT count(pro_codigo) 
					FROM tb_projeto
					WHERE dep_codigo = ?
					AND stp_codigo LIKE ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->execute(array("{$dados[$this->dep_codigo]}",
								 "{$dados[$this->stp_codigo]}")
						   );

			return($stmt->fetch());

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}

	public function getProjetoToCadastroApontamento($pro_codigo)
	{
		$query = ("SELECT pro_codigo, pro_titulo, stp_codigo
					FROM $this->tabela
					WHERE $this->pro_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$pro_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetch());

		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function updateStatusProjeto($dados)
	{
		$query = ("UPDATE $this->tabela
					SET $this->stp_codigo = ?
					WHERE $this->pro_codigo = ? ");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->stp_codigo],PDO::PARAM_INT);
			$stmt->bindParam(2,$dados[$this->pro_codigo],PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function getDescricaoProjeto($pro_codigo)
	{
		$query = ("SELECT pro_codigo, pro_titulo
					FROM $this->tabela
					WHERE $this->pro_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$pro_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetch());

		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	/**
	 * @param $pro_codigo
	 * @return mixed
	 * Usado no cadastro e alteracao de atividade, para validar a data de criacao
	 */
	public function getDataIncioFimProjeto($pro_codigo)
	{
		$query = ("SELECT pro_previsao_inicio, pro_previsao_fim
					FROM $this->tabela
					WHERE $this->pro_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$pro_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetch(\PDO::FETCH_ASSOC));

		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	/**
	 * @param $pro_codigo
	 * @return mixed
	 * Usado no cadastro de apontamento, para validar a data de inicio real do projeto
	 */
	public function getInicioFimProjeto($pro_codigo)
	{
		$query = ("SELECT pro_data_inicio, pro_data_final
					FROM tb_projeto
					WHERE pro_codigo =  ?;");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$pro_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetch(\PDO::FETCH_ASSOC));

		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	//Atualiza a data inicial real do projeto
	public function updateDataInicio($dados)
	{
		$query = ("UPDATE $this->tabela
					SET $this->pro_data_inicio = ?
					WHERE $this->pro_codigo = ? ");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->pro_data_inicio],PDO::PARAM_INT);
			$stmt->bindParam(2,$dados[$this->pro_codigo],PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}


	//Atualiza a data final do projeto
	public function updateDataFinal($dados)
	{
		$query = ("UPDATE $this->tabela
					SET pro_data_final = ?
					WHERE pro_codigo = ? ");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados['pro_data_final'],PDO::PARAM_INT);
			$stmt->bindParam(2,$dados['pro_codigo'],PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	//Lista email dos usuarios participantes do projeto
	public function getEmailUsuarioByProjeto($pro_codigo)
	{
		$query = ("SELECT
						(SELECT usu_email
							FROM tb_usuario
							WHERE usu_codigo = usu_codigo_integrante ) AS usu_email
					FROM tb_usuario_projeto
					WHERE pro_codigo = ?;");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$pro_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetchAll(\PDO::FETCH_ASSOC));

		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	//Usado no painel de projeto
	public function getInfoPainelProjeto($pro_codigo)
	{
		$query = ("SELECT pro_titulo,
							(SELECT concat(usu_nome,' ',usu_sobrenome)
								FROM tb_usuario
								WHERE usu_codigo = usu_codigo_solicitante) AS solicitante,
							(SELECT concat(usu_nome,' ',usu_sobrenome)
								FROM tb_usuario
								WHERE usu_codigo = usu_codigo_responsavel) AS responsavel,
						(SELECT stp_descricao FROM tb_status_projeto WHERE PRO.stp_codigo = stp_codigo) 'status',
						pro_previsao_inicio, pro_previsao_fim
					FROM tb_projeto AS PRO
					INNER JOIN tb_usuario AS USU
					ON usu_codigo_solicitante = usu_codigo
					WHERE PRO.pro_codigo = ?
					AND PRO.stp_codigo = 2;");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$pro_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetch(\PDO::FETCH_ASSOC));

		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	//Usado no painel de projeto detalhado
	public function getInfoDetalhePainelProjeto($pro_codigo)
	{
		$query = ("SELECT pro_codigo, pro_titulo,
							(SELECT concat(usu_nome,' ',usu_sobrenome)
								FROM tb_usuario
								WHERE usu_codigo = usu_codigo_solicitante) AS solicitante,
							(SELECT concat(usu_nome,' ',usu_sobrenome)
								FROM tb_usuario
								WHERE usu_codigo = usu_codigo_responsavel) AS responsavel,
							pro_previsao_inicio, pro_previsao_fim,
						(SELECT stp_descricao FROM tb_status_projeto WHERE PRO.stp_codigo = stp_codigo) pro_status,
						pro_descricao,
						(SELECT dep_descricao FROM tb_departamento WHERE PRO.dep_codigo = dep_codigo) AS departamento
					FROM tb_projeto AS PRO
					INNER JOIN tb_usuario AS USU
					ON usu_codigo_solicitante = usu_codigo
					WHERE PRO.pro_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$pro_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetch(\PDO::FETCH_ASSOC));

		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	//Usado no painel de usuarios
	public function getQuantidadeProjetoByUsuarioResponsavel($usu_codigo)
	{
		$query = ("SELECT count(pro_codigo) AS qtd
					FROM tb_projeto
					WHERE usu_codigo_responsavel = ?
					AND stp_codigo IN(1,2);");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$usu_codigo,PDO::PARAM_INT);

			$stmt->execute();

			$dados = $stmt->fetch(\PDO::FETCH_ASSOC);

			return $dados['qtd'];

		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}


}
?>