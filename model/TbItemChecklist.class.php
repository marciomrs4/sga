<?php

class TbItemChecklist extends Banco
{

	private $tabela = 'tb_item_checklist';

	private $ich_codigo = 'ich_codigo';
	private $ich_titulo_tarefa = 'ich_titulo_tarefa';
	private $ich_ativo = 'ich_ativo';
	private $ich_link = 'ich_link';
	private $che_codigo = 'che_codigo';

	public function insert($dados)
	{
		$query = ("INSERT INTO $this->tabela
					($this->ich_titulo_tarefa, $this->ich_ativo,
					$this->ich_link, $this->che_codigo)
					VALUES(?,?,?,?)");
					try
					{
						$stmt = $this->conexao->prepare($query);

						$stmt->bindParam(1,$dados[$this->ich_titulo_tarefa],PDO::PARAM_STR);
						$stmt->bindParam(2,$dados[$this->ich_ativo],PDO::PARAM_STR);
						$stmt->bindParam(3,$dados[$this->ich_link],PDO::PARAM_STR);
						$stmt->bindParam(4,$dados[$this->che_codigo],PDO::PARAM_INT);

						$stmt->execute();

						return($this->conexao->lastInsertId());

					}catch (PDOException $e)
					{
						throw new PDOException($e->getMessage(), $e->getCode());
					}
	}

	public function select($colum, $param = null)
	{

	}

	#Lista o Checklist na tela de cadastro/alteraчуo
	public function listarChecklist($che_codigo)
	{
		$query = ("SELECT ich_codigo, ich_titulo_tarefa,
					(CASE WHEN ich_ativo = 1 THEN 'ATIVO' ELSE 'INATIVO' END) AS ich_ativo,
					ich_link, (SELECT ane_nome FROM tb_anexo_checklist WHERE A.ich_codigo = ich_codigo) AS ane_nome
					FROM tb_item_checklist AS A
					WHERE che_codigo = ?
				");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$che_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}


	}

	#Listagem de Domingo
	public function listarItemChecklistDiaSemana($che_codigo,$diaSemana)
	{
		$query = ("SELECT A.ich_codigo, A.ich_titulo_tarefa, A.ich_link
					FROM tb_item_checklist AS A
          			INNER JOIN tb_dia_semana_item_checklist AS B
          			ON A.ich_codigo = B.ich_codigo
					WHERE A.che_codigo = ?
          			AND B.$diaSemana = 1
					AND A.ich_ativo = 1
				");

		try
		{
			$stmt = $this->conexao->prepare($query);

				$stmt->bindParam(1,$che_codigo,PDO::PARAM_INT);
				$stmt->execute();
				return($stmt);

		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}

	}
	
	public function getForm($ich_codigo)
	{
		$query = ("SELECT * FROM $this->tabela
					WHERE $this->ich_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$ich_codigo,PDO::PARAM_INT);

			$stmt->execute();

			$dados = $stmt->fetch();

			return($dados);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}

	}

	public function delete($ich_codigo)
	{

		$query = ("DELETE FROM $this->tabela
					WHERE $this->ich_codigo = ?
					");

		$stmt = $this->conexao->prepare($query);

		$stmt->bindParam(1,$ich_codigo,PDO::PARAM_STR);

		$stmt->execute();

		return($stmt);
	}

	public function update($dados)
	{

		$query = ("UPDATE $this->tabela
					SET $this->ich_titulo_tarefa = ?, 
					$this->ich_ativo = ?,
					$this->ich_link = ?
					WHERE $this->ich_codigo = ?
					");

					$stmt = $this->conexao->prepare($query);

					$stmt->bindParam(1,$dados[$this->ich_titulo_tarefa],PDO::PARAM_STR);
					$stmt->bindParam(2,$dados[$this->ich_ativo],PDO::PARAM_INT);
					$stmt->bindParam(3,$dados[$this->ich_link],PDO::PARAM_STR);
					$stmt->bindParam(4,$dados[$this->ich_codigo],PDO::PARAM_INT);

					$stmt->execute();

					return($stmt);
	}

}
?>