<?php

class TbAnexoCheckList extends Banco
{

	private $tabela = 'tb_anexo_checklist';

	private $ane_codigo = 'ane_codigo';
	private $ane_anexo = 'ane_anexo';
	private $ane_tipo = 'ane_tipo';
	private $ane_nome = 'ane_nome';
	private $ane_tamanho = 'ane_tamanho';
	private $ich_codigo	= 'ich_codigo';

	/**
	 *
	 * Usado para inserчуo de Anexo
	 * @param unknown_type $dados
	 * @throws PDOException
	 */
	public function insert($dados)
	{

		$query = ("INSERT INTO $this->tabela
					($this->ane_anexo, $this->ane_tipo, $this->ane_nome, 
					$this->ane_tamanho, $this->ich_codigo)
					VALUES(?,?,?,?,?)
				  ");

					try
					{
						$stmt = $this->conexao->prepare($query);

						$stmt->bindParam(1,$dados[$this->ane_anexo],PDO::PARAM_LOB);
						$stmt->bindParam(2,$dados[$this->ane_tipo],PDO::PARAM_STR);
						$stmt->bindParam(3,$dados[$this->ane_nome],PDO::PARAM_STR);
						$stmt->bindParam(4,$dados[$this->ane_tamanho],PDO::PARAM_STR);
						$stmt->bindParam(5,$dados[$this->ich_codigo],PDO::PARAM_INT);

						$stmt->execute();

						return($this->conexao->lastInsertId());

					}
					catch (PDOException $e)
					{
						throw new PDOException("Erro na tabela". get_class($this)."-". $e->getMessage(),$e->getCode());
					}

	}

	public function confirmarAnexo($ich_codigo)
	{

		$query = ("SELECT $this->ane_codigo FROM  $this->tabela
				   WHERE $this->ich_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$ich_codigo,PDO::PARAM_INT);

			$stmt->execute();

			$dados = $stmt->fetch();
			
			return($dados[0]);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	/**
	 * Utilizado para Alterar anexos
	 *
	 */
	public function update($dados)
	{
		$query = ("UPDATE $this->tabela
					SET	$this->ane_anexo = ?,
						$this->ane_tipo = ?,
						$this->ane_nome = ?,
						$this->ane_tamanho = ?
					WHERE $this->ane_codigo = ? ");
		try
		{
			$stmt = $this->conexao->prepare($query);
			
				$stmt->bindParam(1,$dados[$this->ane_anexo],PDO::PARAM_LOB);
				$stmt->bindParam(2,$dados[$this->ane_tipo],PDO::PARAM_STR);
				$stmt->bindParam(3,$dados[$this->ane_nome],PDO::PARAM_STR);
				$stmt->bindParam(4,$dados[$this->ane_tamanho],PDO::PARAM_STR);
				$stmt->bindParam(5,$dados[$this->ane_codigo],PDO::PARAM_INT);
			
			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function selectAll()
	{
		$query = ("SELECT $this->ane_codigo, $this->ane_nome,
		$this->ane_tamanho, $this->ane_tipo
					FROM $this->tabela");

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

	public function select($ane_codigo)
	{
		$query = ("SELECT * FROM $this->tabela
					WHERE $this->ane_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);
			$stmt->bindParam(1,$ane_codigo);
			$stmt->execute();

			return($stmt->fetch());

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getMessage());
		}
	}


	public function getForm($codigo)
	{

		$query = ("SELECT * FROM  $this->tabela
				   WHERE $this->ich_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetch());

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

}
?>