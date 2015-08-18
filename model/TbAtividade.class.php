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


	public function insert($dados)
	{

		$query = ("INSERT INTO $this->tabela
					($this->pro_codigo, $this->usu_codigo_responsavel, $this->at_previsao_inicio, 
					$this->at_previsao_fim, $this->sta_codigo, $this->at_descricao,
					$this->at_observacao, $this->usu_codigo_criador)
					VALUES(?, ?, ?, ?, ?, ?, ?, ?)");


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
		$query = ("SELECT ATI.at_codigo, PRO.pro_titulo, USU.usu_nome, date_format(ATI.at_previsao_inicio,'%d-%m-%Y'), 
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
					$this->at_observacao = ?
					
					WHERE $this->at_codigo = ? ");
						
					try
					{
						$stmt = $this->conexao->prepare($query);

						$stmt->bindParam(1,$dados[$this->pro_codigo],PDO::PARAM_INT);
						$stmt->bindParam(2,$dados[$this->usu_codigo_responsavel],PDO::PARAM_INT);
						$stmt->bindParam(3,$dados[$this->at_previsao_inicio],PDO::PARAM_STR);
						$stmt->bindParam(4,$dados[$this->at_previsao_fim],PDO::PARAM_STR);
						$stmt->bindParam(5,$dados[$this->sta_codigo],PDO::PARAM_INT);
						$stmt->bindParam(6,$dados[$this->at_descricao],PDO::PARAM_STR);
						$stmt->bindParam(7,$dados[$this->at_observacao],PDO::PARAM_STR);
						$stmt->bindParam(8,$dados[$this->at_codigo],PDO::PARAM_INT);
							
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
						FROM tb_status 
						WHERE sta_codigo = ATI.sta_codigo ) AS 'STATUS' , 
				count(*) AS 'Quantidade'
				FROM tb_atividade AS ATI
				GROUP BY sta_codigo");
						
		try
		{
			$stmt = $this->conexao->prepare($query);
				
			$stmt->execute();
			
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
		$query = ("SELECT (SELECT usu_nome FROM tb_usuario WHERE usu_codigo =  usu_codigo_responsavel) AS Usuario, count(*) AS Quantidade
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
}
?>