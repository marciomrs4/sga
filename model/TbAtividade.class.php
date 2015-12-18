<?php

class TbAtividade extends Banco
{

	private $tabela = 'tb_atividade';

	private $at_codigo = 'at_codigo';
	private $pro_codigo = 'pro_codigo';
	private $usu_codigo_responsavel = 'usu_codigo_responsavel';
	private $at_previsao_inicio = 'at_previsao_inicio';
	private $at_previsao_fim = 'at_previsao_fim';
	private $sta_codigo = 'sta_codigo';
	private $at_descricao = 'at_descricao';
	private $at_observacao = 'at_observacao';
	private $usu_codigo_criador = 'usu_codigo_criador';
	private $at_notificacao = 'at_notificacao';
	private $fas_codigo = 'fas_codigo';
	private $at_codigo_dependente = 'at_codigo_dependente';
	private $at_inicio = 'at_inicio';
	private $at_fim = 'at_fim';
	private $at_tipo_atividade = 'at_tipo_atividade';
	private $at_titulo = 'at_titulo';


	public function insert($dados)
	{

		$query = ("INSERT INTO $this->tabela
					($this->pro_codigo, $this->usu_codigo_responsavel, $this->at_previsao_inicio, 
					$this->at_previsao_fim, $this->sta_codigo, $this->at_descricao,
					$this->at_observacao, $this->usu_codigo_criador, $this->fas_codigo, $this->at_codigo_dependente,
					$this->at_notificacao, $this->at_titulo)
					VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");


					try
					{
						$stmt = $this->conexao->prepare($query);

						$stmt->bindParam(1,$dados[$this->pro_codigo],PDO::PARAM_STR);
						$stmt->bindParam(2,$dados[$this->usu_codigo_responsavel],PDO::PARAM_STR);
						$stmt->bindParam(3,$dados[$this->at_previsao_inicio],PDO::PARAM_INT);
						$stmt->bindParam(4,$dados[$this->at_previsao_fim],PDO::PARAM_STR);
						$stmt->bindParam(5,$dados[$this->sta_codigo],PDO::PARAM_STR);
						$stmt->bindParam(6,$dados[$this->at_descricao],PDO::PARAM_INT);
						$stmt->bindParam(7,$dados[$this->at_observacao],PDO::PARAM_STR);
						$stmt->bindParam(8,$dados[$this->usu_codigo_criador],PDO::PARAM_INT);
						$stmt->bindParam(9,$dados[$this->fas_codigo],PDO::PARAM_INT);
						$stmt->bindParam(10,$dados[$this->at_codigo_dependente],PDO::PARAM_INT);
						$stmt->bindParam(11,$dados[$this->at_notificacao],PDO::PARAM_INT);
						$stmt->bindParam(12,$dados[$this->at_titulo],PDO::PARAM_STR);

						$stmt->execute();

						$this->at_codigo = $this->conexao->lastInsertId();

						return($this->at_codigo);

					}
					catch (PDOException $e)
					{
						throw new PDOException("Erro na tabela". get_class($this)."-". $e->getMessage(),$e->getCode());
					}

	}

	#Usado para listar as atividades, na tela de atividade
	public function listarAtividade($dados)
	{
		$query = ("SELECT ATI.at_codigo, at_titulo, PRO.pro_titulo, USU.usu_nome, date_format(ATI.at_previsao_inicio,'%d-%m-%Y'),
						  date_format(ATI.at_previsao_fim,'%d-%m-%Y'),STI.sta_descricao, substr(ATI.at_descricao,1,60), 
						  date_format(max(APO.ap_data_criacao),'%d-%m-%Y %H:%i:%s') AS 'Maior Data',					
						  substr((SELECT ap_descricao FROM tb_apontamento WHERE ap_codigo = max(APO.ap_codigo)) ,1,30) AS 'Descricao',					
						  count(APO.ap_codigo) AS 'Qtd Apontamento'
					FROM tb_atividade AS ATI
					INNER JOIN tb_projeto AS PRO
					ON ATI.pro_codigo = PRO.pro_codigo
					INNER JOIN tb_status_atividade AS STI
					ON ATI.sta_codigo = STI.sta_codigo
					INNER JOIN tb_usuario AS USU
					ON ATI.usu_codigo_responsavel = USU.usu_codigo
					LEFT JOIN tb_apontamento AS APO
					ON ATI.at_codigo = APO.at_codigo
					WHERE PRO.dep_codigo = ?
					AND ATI.pro_codigo LIKE ?
					AND ATI.sta_codigo LIKE ?
					AND ATI.usu_codigo_responsavel LIKE ?
					AND ATI.at_descricao LIKE ?
					GROUP BY ATI.at_codigo
					ORDER BY ATI.at_codigo DESC");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->execute(array("{$dados['dep_codigo']}",
								  "{$dados[$this->pro_codigo]}",
								 "{$dados[$this->sta_codigo]}",
								 "{$dados[$this->usu_codigo_responsavel]}",
								 "%{$dados[$this->at_descricao]}%"
			));

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException('Erro na tabela: '.get_class($this).$e->getMessage(),$e->getCode());
		}
	}
	
	#Usado para listar as atividades, na exporta��o do excel da tela de atividade
	public function listarAtividadeSemQuebrarLinha($dados)
	{
		$query = ("SELECT ATI.at_codigo, PRO.pro_titulo, USU.usu_nome, date_format(ATI.at_previsao_inicio,'%d-%m-%Y'),
						  date_format(ATI.at_previsao_fim,'%d-%m-%Y'),STI.sta_descricao, ATI.at_descricao,
						  date_format(max(APO.ap_data_criacao),'%d-%m-%Y %H:%i:%s') AS 'Maior Data',
						  (SELECT ap_descricao FROM tb_apontamento WHERE ap_codigo = max(APO.ap_codigo)) AS 'Descricao',
						  count(APO.ap_codigo) AS 'Qtd Apontamento'
					FROM tb_atividade AS ATI
					INNER JOIN tb_projeto AS PRO
					ON ATI.pro_codigo = PRO.pro_codigo
					INNER JOIN tb_status_atividade AS STI
					ON ATI.sta_codigo = STI.sta_codigo
					INNER JOIN tb_usuario AS USU
					ON ATI.usu_codigo_responsavel = USU.usu_codigo
					LEFT JOIN tb_apontamento AS APO
					ON ATI.at_codigo = APO.at_codigo
					WHERE PRO.dep_codigo = ?
					AND ATI.pro_codigo LIKE ?
					AND ATI.sta_codigo LIKE ?
					AND ATI.usu_codigo_responsavel LIKE ?
					AND ATI.at_descricao LIKE ?
					GROUP BY ATI.at_codigo
					ORDER BY ATI.at_codigo DESC");
	
		try
		{
			$stmt = $this->conexao->prepare($query);
	
			$stmt->execute(array("{$dados['dep_codigo']}",
			"{$dados[$this->pro_codigo]}",
			"{$dados[$this->sta_codigo]}",
			"{$dados[$this->usu_codigo_responsavel]}",
			"%{$dados[$this->at_descricao]}%"
			));
	
			return($stmt);
	
		} catch (PDOException $e)
		{
		throw new PDOException('Erro na tabela: '.get_class($this).$e->getMessage(),$e->getCode());
		}
	}

	public function update($dados)
	{
		$query = ("UPDATE $this->tabela
					SET $this->pro_codigo = ?,
						$this->usu_codigo_responsavel = ?,
						$this->at_previsao_inicio = ?,
						$this->at_previsao_fim = ?,
						$this->sta_codigo = ?,
						$this->at_descricao = ?,
						$this->at_observacao = ?,
						$this->fas_codigo = ?,
						$this->at_codigo_dependente = ?,
						$this->at_notificacao = ?
					
					WHERE $this->at_codigo = ? ");
						
					try{

						$stmt = $this->conexao->prepare($query);

						$stmt->bindParam(1,$dados[$this->pro_codigo],PDO::PARAM_INT);
						$stmt->bindParam(2,$dados[$this->usu_codigo_responsavel],PDO::PARAM_INT);
						$stmt->bindParam(3,$dados[$this->at_previsao_inicio],PDO::PARAM_STR);
						$stmt->bindParam(4,$dados[$this->at_previsao_fim],PDO::PARAM_STR);
						$stmt->bindParam(5,$dados[$this->sta_codigo],PDO::PARAM_INT);
						$stmt->bindParam(6,$dados[$this->at_descricao],PDO::PARAM_STR);
						$stmt->bindParam(7,$dados[$this->at_observacao],PDO::PARAM_STR);
						$stmt->bindParam(8,$dados[$this->fas_codigo],PDO::PARAM_INT);
						$stmt->bindParam(9,$dados[$this->at_codigo_dependente],PDO::PARAM_INT);
						$stmt->bindParam(10,$dados[$this->at_notificacao],PDO::PARAM_INT);
						$stmt->bindParam(11,$dados[$this->at_codigo],PDO::PARAM_INT);

						$stmt->execute();

						return($stmt);

					} catch (PDOException $e)
					{
						throw new PDOException($e->getMessage(),$e->getCode());
					}

	}

	public function getFormAlteracao($at_codigo)
	{
		$query = ("SELECT * FROM $this->tabela
					WHERE $this->at_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$at_codigo,PDO::PARAM_INT);

			$stmt->execute();

			$dados = $stmt->fetch();

			return($dados);


		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function getUsuarioAtividadeProjeto($at_codigo)
	{
		$query = ("SELECT at_codigo, ATI.pro_codigo,
					    (SELECT usu_codigo_solicitante 
					        FROM tb_projeto 
					        WHERE ATI.pro_codigo = pro_codigo
					    ) AS usu_codigo_solicitante, usu_codigo_responsavel 
					FROM tb_atividade AS ATI 
					WHERE at_codigo = ?
				  ");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$at_codigo,PDO::PARAM_INT);

			$stmt->execute();

			$dados = $stmt->fetch();

			return($dados);


		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function updateStatusAtividade($dados)
	{
		$query = ("UPDATE $this->tabela
					SET $this->sta_codigo = ?					
					WHERE $this->at_codigo = ? 
				  ");
			
		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->sta_codigo],PDO::PARAM_INT);
			$stmt->bindParam(2,$dados[$this->at_codigo],PDO::PARAM_INT);
				
			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function getStatusAtividade($at_codigo)
	{
		$query = ("SELECT $this->sta_codigo
					FROM $this->tabela
					WHERE $this->at_codigo = ?
				  ");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$at_codigo,PDO::PARAM_INT);

			$stmt->execute();

			$dados = $stmt->fetch();

			return($dados[0]);


		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function listarAtividadeProjeto($pro_codigo)
	{
		$query = ("SELECT at_codigo, (SELECT concat(usu_nome,' ',usu_sobrenome) FROM tb_usuario WHERE usu_codigo_responsavel = usu_codigo) AS Usuario, 
					    	date_format(at_previsao_inicio,'%d/%m/%Y') Inicio, date_format(at_previsao_fim,'%d/%m/%Y') Fim, 
					       (SELECT sta_descricao FROM tb_status_atividade WHERE ATI.sta_codigo = sta_codigo) AS 'Status', 
					       at_descricao
					FROM tb_atividade AS ATI
					WHERE pro_codigo = ?
					ORDER BY 1 ");

		try
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$pro_codigo,PDO::PARAM_INT);
			
			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException('Erro na tabela: '.get_class($this).$e->getMessage(),$e->getCode());
		}
	}
	
	public function listarAtividadePDF($at_codigo)
	{
		$query = ("SELECT at_codigo, (SELECT concat(usu_nome,' ',usu_sobrenome) FROM tb_usuario WHERE usu_codigo_responsavel = usu_codigo) AS Usuario, 
					    	date_format(at_previsao_inicio,'%d/%m/%Y') Inicio, date_format(at_previsao_fim,'%d/%m/%Y') Fim, 
					       (SELECT sta_descricao FROM tb_status_atividade WHERE ATI.sta_codigo = sta_codigo) AS 'Status', 
					       at_descricao
					FROM tb_atividade AS ATI
					WHERE at_codigo = ?
					ORDER BY 1 ");

		try
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$at_codigo,PDO::PARAM_INT);
			
			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException('Erro na tabela: '.get_class($this).$e->getMessage(),$e->getCode());
		}
	}

	#Usado no Painel de Atividade 
	public function totalAtividadePainel($dados)
	{
		$query = ("SELECT count(*) as 'Total'
					FROM tb_atividade as ATI
					INNER JOIN tb_projeto as PRO
					ON ATI.pro_codigo = PRO.pro_codigo
					INNER JOIN tb_status_atividade as STI
					ON ATI.sta_codigo = STI.sta_codigo
					WHERE PRO.dep_codigo = ?
					AND ATI.sta_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$dados['dep_codigo'],PDO::PARAM_INT);
			$stmt->bindParam(2,$dados['sta_codigo'],PDO::PARAM_INT);			
			
			$stmt->execute();

			return($stmt->fetch());

		} catch (PDOException $e)
		{
			throw new PDOException('Erro na tabela: '.get_class($this).$e->getMessage(),$e->getCode());
		}
	}
	
	#Usado no Painel de Atividade 
	public function listarAtividadePainel($dados)
	{
		$query = ("SELECT ATI.at_codigo, substring(PRO.pro_titulo,1,20) AS 'Titulo', 
							substring(ATI.at_descricao,1,15) AS 'Descricao',
					DATEDIFF(curdate(),at_previsao_inicio) as 'Tempo'
					FROM tb_atividade AS ATI
					INNER JOIN tb_projeto AS PRO
					ON ATI.pro_codigo = PRO.pro_codigo
					WHERE ATI.usu_codigo_responsavel = ?
					AND ATI.sta_codigo = ?
					AND PRO.dep_codigo = ?
					ORDER BY 4 DESC");

		try
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$dados['usu_codigo_responsavel'],PDO::PARAM_INT);
			$stmt->bindParam(2,$dados['sta_codigo'],PDO::PARAM_INT);			
			$stmt->bindParam(3,$dados['dep_codigo'],PDO::PARAM_INT);			
			
			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException('Erro na tabela: '.get_class($this).$e->getMessage(),$e->getCode());
		}
	}
	
	
	#Usado no Painel de Atividade
	public function graficoAtividade()
	{
		$query = ("SELECT 
						(SELECT sta_descricao
							FROM tb_status_atividade
							WHERE sta_codigo = ATI.sta_codigo ) AS 'STATUS' ,
					count(*) AS 'Quantidade'
					FROM tb_atividade AS ATI
					WHERE sta_codigo IN (1,2)
					AND usu_codigo_responsavel IN (SELECT USU.usu_codigo
									FROM tb_usuario AS USU
									INNER JOIN tb_acesso AS ACE
									ON USU.usu_codigo = ACE.usu_codigo
									WHERE USU.dep_codigo = ?
									AND ACE.ace_ativo = 'S')
					GROUP BY sta_codigo;");

		try
		{
			$stmt = $this->conexao->prepare($query);
				
			$stmt->execute(array($_SESSION['dep_codigo']));
			
			foreach ($stmt as $value){
				echo '[',"'",$value[0],"'",',',$value[1],'],';
			}
			
	
		} catch (PDOException $e)
		{
			throw new PDOException('Erro na tabela: '.get_class($this).$e->getMessage(),$e->getCode());
		}
	}

	#Painel Grafico de Atividade por usuario
	public function graficoAtividadePorUsuario($dados)
	{
		$query = ("SELECT
						(SELECT usu_nome
							FROM tb_usuario
							WHERE usu_codigo =  ATV.usu_codigo_responsavel) AS Usuario, count(*) AS Quantidade
					FROM tb_atividade AS ATV
					INNER JOIN tb_projeto AS PRO
					ON PRO.pro_codigo = ATV.pro_codigo
					WHERE PRO.dep_codigo = ?
					AND ATV.sta_codigo IN(1,2)
					GROUP BY 1;");
	
		try
		{
			$stmt = $this->conexao->prepare($query);
	
			$stmt->bindParam(1, $dados['dep_codigo']);
			#$stmt->bindParam(2, $dados['sta_codigo']);
			
			$stmt->execute();
				
			foreach ($stmt as $value){
				echo '[',"'",$value[0],"'",',',$value[1],'],';
			}
				
	
		} catch (PDOException $e)
		{
			throw new PDOException('Erro na tabela: '.get_class($this).$e->getMessage(),$e->getCode());
		}
	}
	
	
	public function validateQtdAtividadeEmAndamento($pro_codigo)
	{
		$query = ("select count(*) from tb_atividade 
					where pro_codigo = ?
					and sta_codigo = 2;");
		
		try
		{
			$stmt = $this->conexao->prepare($query);
				
			$stmt->bindParam(1,$pro_codigo,PDO::PARAM_INT);
				
			$stmt->execute();
		
			$dados = $stmt->fetch();
			
			return($dados[0]);
		
		} catch (PDOException $e)
		{
			throw new PDOException('Erro na tabela: '.get_class($this).$e->getMessage(),$e->getCode());
		}
	}

    #Usado no Painel de Tarefas
    public function listarAtividadePainelTarefas($dados)
    {
        $query = ("SELECT concat('Atividade: ', at_codigo) AS atividade
                    FROM tb_atividade
                    WHERE usu_codigo_responsavel = ?
                    AND sta_codigo = ?
                    ORDER BY at_codigo
                  ");

        try
        {
            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados['usu_codigo_responsavel'],PDO::PARAM_INT);
            $stmt->bindParam(2,$dados['sta_codigo'],PDO::PARAM_INT);

            $stmt->execute();

            return($stmt);

        } catch (PDOException $e)
        {
            throw new PDOException('Erro na tabela: '.get_class($this).$e->getMessage(),$e->getCode());
        }
    }

	#usado para listar atividade dependente
	public function listarAtividadeDependente($dados)
	{
		$query = ("SELECT at_codigo, substring(at_descricao,1,30) AS at_descricao
					FROM tb_atividade
					WHERE pro_codigo = ?
					AND sta_codigo = 1
					AND at_codigo != ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados['pro_codigo'],PDO::PARAM_INT);
			$stmt->bindParam(2,$dados['at_codigo'],PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException('Erro na tabela: '.get_class($this).$e->getMessage(),$e->getCode());
		}
	}

	#usado no cadastro de projeto para validar se existe atividades que não sejam pendentes
	public function getCountQtdAtividadeByProjetos($pro_codigo)
	{
		$query = ("SELECT COUNT(*) AS qtd_atividade
					FROM tb_atividade
					WHERE pro_codigo = ?
					AND sta_codigo != 1;");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$pro_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetch(\PDO::FETCH_ASSOC));

		} catch (PDOException $e)
		{
			throw new PDOException('Erro na tabela: '.get_class($this).$e->getMessage(),$e->getCode());
		}
	}

	public function updateTipoAtividade($dados)
	{
		$query = ("UPDATE tb_atividade
					SET at_tipo_atividade = ?
					WHERE at_codigo = ?
				  ");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados['at_tipo_atividade'],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados['at_codigo'],PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function getAtividadeDependente($at_codigo)
	{
		$query = ("SELECT sta_codigo, at_codigo
					FROM tb_atividade
					WHERE at_codigo = (SELECT at_codigo_dependente
										FROM tb_atividade
										WHERE at_codigo = ?)");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$at_codigo,\PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetch(\PDO::FETCH_ASSOC));

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	//Atualiza a data de inicio efetivo da atividade
	public function updateDataInicioAtividade($dados)
	{
		$query = ("UPDATE tb_atividade
					SET at_inicio = ?
					WHERE at_codigo = ?
				  ");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados['at_inicio'],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados['at_codigo'],PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException('Tabela atividade ' . $e->getMessage(),$e->getCode());
		}

	}

	//Atualiza a data de fim efetivo da atividade
	public function updateDataFimAtividade($dados)
	{
		$query = ("UPDATE tb_atividade
					SET at_fim = ?
					WHERE at_codigo = ?
				  ");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados['at_fim'],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados['at_codigo'],PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}


	//Obtem a data de inicio e fim efetivos da atividade
	public function getDataInicioFimAtividade($at_codigo)
	{
		$query = ("SELECT at_inicio, at_fim
					FROM tb_atividade
					WHERE at_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$at_codigo,\PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetch(\PDO::FETCH_ASSOC));

		} catch (PDOException $e)
		{
			throw new PDOException('Erro ao buscar as datas ' . $e->getMessage(),$e->getCode());
		}

	}

	//Obetem codigo do projeto
	// usado para envio de notificacao de apontamento
	public function getProCodigo($at_codigo)
	{
		$query = ("SELECT pro_codigo
					FROM tb_atividade
					WHERE at_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$at_codigo,\PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetch(\PDO::FETCH_ASSOC));

		} catch (PDOException $e)
		{
			throw new PDOException('Erro ao buscar as datas ' . $e->getMessage(),$e->getCode());
		}

	}


	//Obetem a lista de atividades para notificacao automatica
	// usado para envio de notificacao da atividade para o responsavel
	public function listaNotificaoAtividade()
	{
		$query = ("SELECT
						(SELECT pro_titulo
							FROM tb_projeto
							WHERE ATV.pro_codigo = pro_codigo) AS pro_titulo,
						at_codigo,
						(SELECT concat(usu_nome,' ', usu_sobrenome)
							FROM tb_usuario
							WHERE usu_codigo_responsavel = usu_codigo) AS usu_nome,
						(SELECT usu_email
							FROM tb_usuario
							WHERE usu_codigo_responsavel = usu_codigo) AS usu_email,
						(SELECT sta_descricao
							FROM tb_status_atividade
							WHERE ATV.sta_codigo = sta_codigo) AS sta_descricao,
						at_previsao_fim,datediff(at_previsao_fim, date_format(now(),'%Y-%m-%d')) AS dias
					FROM tb_atividade ATV
					WHERE at_notificacao = 1
					AND sta_codigo IN (1,2)
					AND datediff(at_previsao_fim, date_format(now(),'%Y-%m-%d')) <= 5
					ORDER BY at_codigo;");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->execute();

			return($stmt->fetchAll(\PDO::FETCH_ASSOC));

		} catch (PDOException $e)
		{
			throw new PDOException('Erro ao listar ' . $e->getMessage(),$e->getCode());
		}

	}


	//Usado no painel de detalhe das atividades
	public function listarAtividadeByProjeto($pro_codigo)
	{
		$query = ("SELECT at_codigo,
						(SELECT concat(usu_nome,' ', usu_sobrenome)
							FROM tb_usuario
							WHERE usu_codigo_responsavel = usu_codigo) AS responsavel,
						(SELECT sta_descricao
							FROM tb_status_atividade
							WHERE ATV.sta_codigo = sta_codigo) AS 'status',
							concat(at_previsao_inicio,' 00:00:00') AS previsao_inicio,

							concat(at_previsao_fim,' 00:00:00') AS previsao_fim,
							IF(sta_codigo < 3, now(), ifnull(at_fim, now())) AS atual

					FROM tb_atividade ATV
					WHERE fas_codigo IS NULL
					AND pro_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$pro_codigo,\PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetchAll(\PDO::FETCH_ASSOC));

		} catch (\PDOException $e)
		{
			throw new \PDOException('Erro ao listar ' . $e->getMessage(),$e->getCode());
		}

	}


	//Usado no painel de detalhe das atividades por fase
	public function listarAtividadeByFaseAndProjeto($dados)
	{
			$query = ("SELECT at_codigo,
							(SELECT concat(usu_nome,' ', usu_sobrenome)
								FROM tb_usuario
								WHERE usu_codigo_responsavel = usu_codigo) AS responsavel,
							(SELECT sta_descricao
								FROM tb_status_atividade
								WHERE ATV.sta_codigo = sta_codigo) AS 'status',
								concat(at_previsao_inicio,' 00:00:00') AS previsao_inicio,

							concat(at_previsao_fim,' 00:00:00') AS previsao_fim,
							IF(sta_codigo < 3, now(), ifnull(at_fim, now())) AS atual,

								fas_codigo
						FROM tb_atividade ATV
						WHERE fas_codigo = ?
						AND pro_codigo = ?
						ORDER BY fas_codigo;");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados['fas_codigo'],\PDO::PARAM_INT);
			$stmt->bindParam(2,$dados['pro_codigo'],\PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetchAll(\PDO::FETCH_ASSOC));

		} catch (\PDOException $e)
		{
			throw new \PDOException('Erro ao listar ' . $e->getMessage(),$e->getCode());
		}

	}

	//Usado no painel de atividade
	public function getFormDetalheAtividade($at_codigo)
	{
		$query = ("SELECT at_codigo, at_descricao,
						(SELECT sta_descricao
							FROM tb_status_atividade
							WHERE ATV.sta_codigo = sta_codigo) AS 'status',
						(SELECT concat(usu_nome,' ', usu_sobrenome)
								FROM tb_usuario
								WHERE usu_codigo = usu_codigo_responsavel) AS responsavel,
						   date_format(at_previsao_inicio,'%d-%m-%Y') AS at_previsao_inicio,
						   date_format(at_previsao_fim,'%d-%m-%Y') AS at_previsao_fim,
						   (SELECT fas_descricao
								FROM tb_fase_projeto
								WHERE  ATV.fas_codigo = fas_codigo) AS fas_descricao,
								IF(at_tipo_atividade = 1,'Nao Planejado','Planejado') AS planejamento,
								date_format(at_inicio,'%d-%m-%Y') AS at_inicio,
								date_format(at_fim,'%d-%m-%Y') AS at_fim
					FROM tb_atividade AS ATV
					WHERE at_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$at_codigo,PDO::PARAM_INT);

			$stmt->execute();

			$dados = $stmt->fetch(\PDO::FETCH_ASSOC);

			return($dados);


		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}


	//Usado no painel de projetos detalhados
	public function getPlanejamentoAtividade($pro_codigo)
	{
		$query = ("SELECT count(*) AS plano
					FROM tb_atividade
					WHERE pro_codigo = ?
					GROUP BY at_tipo_atividade
					ORDER BY at_tipo_atividade;
				");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$pro_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_NUM);


		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	#Usado no Painel de projeto
	public function graficoPainelDetalheAtividade($pro_codigo)
	{
		$query = ("SELECT
					(SELECT sta_descricao
						FROM tb_status_atividade
						WHERE sta_codigo = ATI.sta_codigo ) AS 'STATUS' ,
				count(*) AS 'Quantidade'
				FROM tb_atividade AS ATI
				WHERE pro_codigo = ?
				GROUP BY sta_codigo");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$pro_codigo,\PDO::PARAM_INT);

			$stmt->execute();

			foreach ($stmt as $value){
				echo '[',"'",$value[0],"'",',',$value[1],'],';
			}


		} catch (PDOException $e)
		{
			throw new PDOException('Erro na tabela: '.get_class($this).$e->getMessage(),$e->getCode());
		}
	}


	#Usado no Painel de projeto detalhes
	public function graficoPainelDetalheAtividadePrazo($pro_codigo)
	{
		$query = ("SELECT
					IF(ROUND(((datediff(IF(sta_codigo > 2,IFNULL(at_fim,now()),now()), at_previsao_inicio) + 1) /
							   (datediff(at_previsao_fim, at_previsao_inicio) + 1) * 100),2) <= 100,'Dentro','Fora') AS prazo,

						COUNT(IF(ROUND(((datediff(IF(sta_codigo > 2,IFNULL(at_fim,now()),now()), at_previsao_inicio) + 1) /
							   (datediff(at_previsao_fim, at_previsao_inicio) + 1) * 100),2) <= 100,'dentro','fora') ) AS qtd
					FROM tb_atividade WHERE pro_codigo = ?
					GROUP BY prazo;");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$pro_codigo,\PDO::PARAM_INT);

			$stmt->execute();

			foreach ($stmt as $value){
				echo '[',"'",$value[0],"'",',',$value[1],'],';
			}


		} catch (PDOException $e)
		{
			throw new PDOException('Erro na tabela: '.get_class($this).$e->getMessage(),$e->getCode());
		}
	}


	public function listarAtividadeProjetoByUser($dados)
	{
		$query = ("SELECT
						at_codigo, at_codigo,PRO.pro_titulo,
						at_previsao_inicio,
						date_format(at_previsao_fim,'%d-%m-%Y') AS at_previsao_fim,
							(SELECT sta_descricao
								FROM tb_status_atividade
								WHERE ATV.sta_codigo = sta_codigo) AS sta_descricao,

						concat(
							concat(at_previsao_inicio,' 00:00:00'),'|',
							concat(at_previsao_fim,' 00:00:00'),'|',
							IF(sta_codigo < 3, now(), ifnull(at_fim, now()))) AS DATAS

						FROM tb_atividade ATV
						INNER JOIN tb_projeto AS PRO
						ON ATV.pro_codigo = PRO.pro_codigo

						WHERE ATV.usu_codigo_responsavel = ?
						AND sta_codigo IN (1,2)
						AND at_previsao_inicio >= ?
						AND at_previsao_inicio <= ?
						ORDER BY ATV.pro_codigo, at_previsao_inicio;");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados['usu_codigo_responsavel'],PDO::PARAM_INT);
			$stmt->bindParam(2,$dados['data1'],PDO::PARAM_INT);
			$stmt->bindParam(3,$dados['data2'],PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException('Erro na tabela: '.get_class($this).$e->getMessage(),$e->getCode());
		}
	}


	public function getQuantidadeAtividadeByUser($dados)
	{
		$query = ("SELECT
						count(at_codigo) AS qtd
						FROM tb_atividade
						WHERE usu_codigo_responsavel = ?
						AND sta_codigo IN (1,2)
						AND at_previsao_inicio >= ?
						AND at_previsao_inicio <= ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados['usu_codigo_responsavel'],PDO::PARAM_INT);
			$stmt->bindParam(2,$dados['data1'],PDO::PARAM_INT);
			$stmt->bindParam(3,$dados['data2'],PDO::PARAM_INT);

			$stmt->execute();

			$dados  = $stmt->fetch(\PDO::FETCH_ASSOC);

			return $dados['qtd'];

		} catch (PDOException $e)
		{
			throw new PDOException('Erro na tabela: '.get_class($this).$e->getMessage(),$e->getCode());
		}
	}


	public function graficAtividadeAbertaByUser($dados)
	{
		$query = ("SELECT date_format(at_previsao_inicio,'%y/%m') AS inicio , count(*) AS QTD
						FROM tb_atividade
						WHERE usu_codigo_responsavel = ?
						AND at_previsao_inicio >= ?
						GROUP BY 1
						ORDER BY 1;");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados['usu_codigo_responsavel'],PDO::PARAM_INT);
			$stmt->bindParam(2,$dados['data'],PDO::PARAM_STR);

			$stmt->execute();

			foreach ($stmt as $value){
				echo '[',"'",$value[0],"'",',',$value[1],'],';
			}


		} catch (PDOException $e)
		{
			throw new PDOException('Erro na tabela: '.get_class($this).$e->getMessage(),$e->getCode());
		}
	}

	public function graficAtividadeConcludidoByUser($dados)
	{
		$query = ("SELECT date_format(at_fim,'%y/%m') AS inicio, count(*) AS QTD
						FROM tb_atividade
						WHERE usu_codigo_responsavel = ?
						AND at_fim >= ?
						GROUP BY 1
						ORDER BY 1;");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados['usu_codigo_responsavel'],PDO::PARAM_INT);
			$stmt->bindParam(2,$dados['data'],PDO::PARAM_STR);

			$stmt->execute();

			foreach ($stmt as $value){
				echo '[',"'",$value[0],"'",',',$value[1],'],';
			}


		} catch (PDOException $e)
		{
			throw new PDOException('Erro na tabela: '.get_class($this).$e->getMessage(),$e->getCode());
		}
	}

	#Obtem a data maior e data menor dentre as atividades do usuario
	public function getMaxAndMinDataAtividades($usu_codigo_responsavel)
	{

		$query = ("SELECT
						date_format(min(at_previsao_inicio),'%d-%m-%Y') AS menor_data,
						date_format(max(at_previsao_fim),'%d-%m-%Y') AS maior_data
					FROM tb_atividade
					WHERE usu_codigo_responsavel = ?
					AND sta_codigo IN (1,2);");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->execute(array("{$usu_codigo_responsavel}"));

			return($stmt->fetch(\PDO::FETCH_ASSOC));

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}


	#Obtem o mairo numero de atividade de um projeto
	public function getNumeroAtividadeProjeto($pro_codigo)
	{

		$query = ("SELECT count(at_codigo) AS pro_codigo
					FROM tb_atividade
					WHERE pro_codigo = ?;");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->execute(array("{$pro_codigo}"));

			$pro_codigo = $stmt->fetch(\PDO::FETCH_ASSOC);

			return $pro_codigo['pro_codigo'];

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}


}

?>