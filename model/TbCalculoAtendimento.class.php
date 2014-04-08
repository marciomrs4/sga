<?php

class TbCalculoAtendimento extends Banco
{

	private $tabela = 'tb_calculo_atendimento';

	private $tea_codigo = 'tea_codigo';
	private $sol_codigo = 'sol_codigo';
	private $usu_codigo = 'usu_codigo';
	private $sta_codigo = 'sta_codigo';
	private $tea_data_acao = 'tea_data_acao';

	#Insere o atendimento
	public function insertCalculoAtendimento($dados)
	{
		$query = ("INSERT
					INTO $this->tabela ($this->sol_codigo,$this->usu_codigo,
					$this->sta_codigo)
					VALUES(?,?,?)");

					try{
						$stmt = $this->conexao->prepare($query);

						$stmt->bindParam(1,$dados[$this->sol_codigo],PDO::PARAM_INT);
						$stmt->bindParam(2,$_SESSION['usu_codigo'],PDO::PARAM_INT);
						$stmt->bindParam(3,$dados[$this->sta_codigo],PDO::PARAM_INT);

						$stmt->execute();

						return($this->conexao->lastInsertId());

					}
					catch (PDOException $e)
					{
						throw new PDOException("Erro na tabela". get_class($this)."-". $e->getMessage(),$e->getCode());
					}

	}
	

	#Verifica se jс houve um inserчуo de qualquer status
	#Em uso no metodo de Cadastro
	public function verificaAberto($dados)
	{
		$query = ("SELECT * FROM $this->tabela
					WHERE sol_codigo = ? 
					AND sta_codigo = 1");

		try
		{
			$stmt = $this->conexao->prepare($query);
				
			$stmt->bindParam(1,$dados[$this->sol_codigo],PDO::PARAM_INT);
				
			$stmt->execute();
				
			$dados = $stmt->fetch();
				
			return($dados);
				
				
		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}

	}

	#Verifica se jс houve um inserчуo de qualquer status
	#Em uso no metodo de Cadastro
	public function verificaEmAndamento($dados)
	{
		$query = ("SELECT * FROM $this->tabela
					WHERE sol_codigo = ? 
					AND sta_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);
				
			$stmt->bindParam(1,$dados[$this->sol_codigo],PDO::PARAM_INT);
			$stmt->bindParam(2,$dados[$this->sta_codigo],PDO::PARAM_INT);
				
			$stmt->execute();
				
			$dados = $stmt->fetch();
				
			return($dados);
				
				
		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}

	}

	#Pega a data da solicitacуo de acordo com status passado
	public function getDataPorStatus($sol_codigo,$sta_codigo)
	{
		$query = ("SELECT date_format(tea_data_acao,'%d-%m-%Y %H:%i:%s') 
					FROM $this->tabela
					WHERE sol_codigo = ? 
					AND sta_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);
				
			$stmt->bindParam(1,$sol_codigo,PDO::PARAM_INT);
			$stmt->bindParam(2,$sta_codigo,PDO::PARAM_INT);
				
			$stmt->execute();
				
			$dados = $stmt->fetch();
				
			return($dados[0]);
				
				
		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}


	}

	public function updateEmAtendimento($sol_codigo)
	{
		$query = ("UPDATE $this->tabela
					SET	$this->tea_em_atendimento = ?
					WHERE $this->sol_codigo = ? 
				  ");

		$this->tea_em_atendimento = ValidarDatas::dataHoraAtual();

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$this->tea_em_atendimento,PDO::PARAM_STR);
			$stmt->bindParam(2,$sol_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function updateCancelado($sol_codigo)
	{
		$query = ("UPDATE $this->tabela
					SET	$this->tea_cancelado = ?
					WHERE $this->sol_codigo = ? 
				  ");

		$this->tea_cancelado = ValidarDatas::dataHoraAtual();

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$this->tea_cancelado,PDO::PARAM_STR);
			$stmt->bindParam(2,$sol_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function updateParalizado($sol_codigo)
	{
		$query = ("UPDATE $this->tabela
					SET	$this->tea_paralizado = ?
					WHERE $this->sol_codigo = ? 
				  ");

		$this->tea_paralizado = ValidarDatas::dataHoraAtual();

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$this->tea_paralizado,PDO::PARAM_STR);
			$stmt->bindParam(2,$sol_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function updateConcluido($sol_codigo)
	{
		$query = ("UPDATE $this->tabela
					SET	$this->tea_concluido = ?
					WHERE $this->sol_codigo = ? 
				 ");

		$this->tea_concluido = ValidarDatas::dataHoraAtual();

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$this->tea_concluido,PDO::PARAM_STR);
			$stmt->bindParam(2,$sol_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function select($colum,$param)
	{
		$query = (" ");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getMessage());
		}
	}

	public function getForm($sol_codigo)
	{
		$query = ("SELECT * FROM  $this->tabela
				   WHERE $this->sol_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$sol_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetch());

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}

}
?>