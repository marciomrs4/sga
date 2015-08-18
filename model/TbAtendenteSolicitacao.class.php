<?php

class TbAtendenteSolicitacao extends Banco
{

	private $tabela = 'tb_atendente_solicitacao';

	private $ats_codigo = 'ats_codigo';
	private $usu_codigo_atendente = 'usu_codigo_atendente';
	private $sol_codigo = 'sol_codigo';
	private $pri_codigo = 'pri_codigo';

	public function insert($dados)
	{

		$query = ("INSERT INTO $this->tabela
					($this->usu_codigo_atendente,$this->sol_codigo,$this->pri_codigo)
					VALUES(?,?,?)
					");
			
		$stmt = $this->conexao->prepare($query);

		$stmt->bindParam(1,$dados[$this->usu_codigo_atendente],PDO::PARAM_INT);
		$stmt->bindParam(2,$dados[$this->sol_codigo],PDO::PARAM_INT);
		$stmt->bindParam(3,$dados[$this->pri_codigo],PDO::PARAM_INT);

		$stmt->execute();

		return($stmt);

	}

	#Usado para confirmar se existe algu�m atendendo a solicita��o
	#para evitar q se criei dois atendimentos.
	public function confirmarAtendente($sol_codigo)
	{
		$query = ("SELECT $this->usu_codigo_atendente FROM $this->tabela
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

	public function select($colum, $param = null)
	{

		$query = ("SELECT $this->usu_codigo_atendente FROM $this->tabela
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

	#Retorna o nome do atendente da solicitacao
	public function getNomeAtendente($sol_codigo)
	{
		$query = ("SELECT usu_codigo_atendente, USU.usu_nome, sol_codigo
					FROM  tb_atendente_solicitacao
					INNER JOIN tb_usuario AS USU
					ON usu_codigo_atendente = usu_codigo
					WHERE sol_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$sol_codigo,PDO::PARAM_INT);

			$stmt->execute();

			$dados = $stmt->fetch();

			return($dados);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}

	public function getForm($codigo_id_tabela){}

	#Atualiza o usuario que esta atendendo a solicitacao
	public function update($dados)
	{
		$query = ("UPDATE $this->tabela
					SET $this->usu_codigo_atendente = ?
					WHERE $this->sol_codigo = ?");
		
		try 
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados['usu_codigo_atendente'],PDO::PARAM_INT);
			$stmt->bindParam(2,$dados['sol_codigo'],PDO::PARAM_INT);
			
			$stmt->execute();
			
		} catch (PDOException $e) 
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
		
	}
	
	
	#Utilizado no Painel de Chamados
	public function listarSolicitacaoPainel($dados)
	{

            $query = ("SELECT  ate.sol_codigo,
                            (SELECT usu_nome FROM tb_usuario
                                WHERE usu_codigo = so.usu_codigo_solicitante ) as 'Solicitante',
                                      DATEDIFF(now(),(SELECT tea_data_acao FROM tb_calculo_atendimento
                                WHERE so.sol_codigo = sol_codigo AND sta_codigo = 1)
                                ) AS Tempo,
                              #(SELECT pri_descricao FROM tb_prioridade WHERE ate.pri_codigo = pri_codigo) as pri_descricao,
							concat(so.sol_data_inicio , ' | ',
									(CASE so.sta_codigo WHEN 2 THEN now() WHEN 3 THEN so.sol_data_fim ELSE so.sol_data_fim END),' | ',
									(SELECT pro_tempo_solucao
										FROM tb_problema as PRO
										WHERE so.pro_codigo_tecnico = PRO.pro_codigo))
							AS 'SLA'

                       FROM tb_atendente_solicitacao AS ate
                       INNER JOIN tb_solicitacao AS so
                       ON ate.sol_codigo = so.sol_codigo
                       WHERE ate.usu_codigo_atendente = ?
                       AND so.sta_codigo = ?
                       ORDER BY 4 DESC;");
		
		try 
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados['usu_codigo_atendente'],PDO::PARAM_INT);
			$stmt->bindParam(2,$dados['sta_codigo'],PDO::PARAM_INT);
			
			$stmt->execute();
			
			return($stmt);
			
		} catch (PDOException $e) 
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
		
	}

    #Utilizado no Painel de Tarefas
    public function listarChamadosPainelTarefas($dados)
    {

        $query = ("SELECT  concat('Chamado: ',ate.sol_codigo) as chamado
                    FROM tb_atendente_solicitacao AS ate
                    INNER JOIN tb_solicitacao AS so
                    ON ate.sol_codigo = so.sol_codigo
                    WHERE ate.usu_codigo_atendente = ?
                    AND so.sta_codigo = ?
                    ORDER BY ate.sol_codigo");

        try
        {
            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados['usu_codigo_atendente'],PDO::PARAM_INT);
            $stmt->bindParam(2,$dados['sta_codigo'],PDO::PARAM_INT);

            $stmt->execute();

            return($stmt);

        } catch (PDOException $e)
        {
            throw new PDOException($e->getMessage(),$e->getCode());
        }

    }


}
?>