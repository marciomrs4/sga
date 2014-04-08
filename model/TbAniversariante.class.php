<?php

class TbAniversariante extends Banco
{
	private $tabela = 'tb_aniversariante';


	private $ani_codigo = 'ani_codigo';
	private $ani_drt = 'ani_drt';
	private $ani_nome = 'ani_nome';
	private $ani_setor = 'ani_setor';
	private $ani_data_nascimento = 'ani_data_nascimento';
	private $ani_dia = 'ani_dia';
	private $ani_mes = 'ani_mes';
	private $ani_ano = 'ani_ano';
	private $ani_unidade = 'ani_unidade';
	
	public function insert($dados)
	{

		$query = ("INSERT INTO $this->tabela 
					($this->ani_drt, $this->ani_nome, $this->ani_setor, $this->ani_data_nascimento,
					 $this->ani_dia, $this->ani_mes, $this->ani_ano, $this->ani_unidade)
					VALUES(?,?,?,?,?,?,?,?)");

		try{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->ani_drt],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->ani_nome],PDO::PARAM_STR);
			$stmt->bindParam(3,$dados[$this->ani_setor],PDO::PARAM_STR);
			$stmt->bindParam(4,$dados[$this->ani_data_nascimento],PDO::PARAM_STR);
			$stmt->bindParam(5,$dados[$this->ani_dia],PDO::PARAM_INT);
			$stmt->bindParam(6,$dados[$this->ani_mes],PDO::PARAM_INT);
			$stmt->bindParam(7,$dados[$this->ani_ano],PDO::PARAM_INT);
			$stmt->bindParam(8,$dados[$this->ani_unidade],PDO::PARAM_STR);

			$stmt->execute();
			
			$this->ani_codigo = $this->conexao->lastInsertId();

			return($this->ani_codigo);

		}
		catch (PDOException $e)
		{
			throw new PDOException("Erro na tabela: ". get_class($this)."-". $e->getMessage(),$e->getCode());
		}

	}

	public function update($dados)
	{
		$query = ("UPDATE $this->tabela
					SET	$this->ani_drt = ?,
						$this->ani_nome = ?,
						$this->ani_setor= ?,
						$this->ani_data_nascimento = ?,
						$this->ani_dia = ?,
						$this->ani_mes = ?,
						$this->ani_ano = ?,
						$this->ani_unidade = ?
					WHERE $this->ani_codigo= ? ");
					
		try
		{
			
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->ani_drt],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->ani_nome],PDO::PARAM_STR);
			$stmt->bindParam(3,$dados[$this->ani_setor],PDO::PARAM_STR);
			$stmt->bindParam(4,$dados[$this->ani_data_nascimento],PDO::PARAM_STR);
			$stmt->bindParam(5,$dados[$this->ani_dia],PDO::PARAM_STR);
			$stmt->bindParam(6,$dados[$this->ani_mes],PDO::PARAM_STR);
			$stmt->bindParam(7,$dados[$this->ani_ano],PDO::PARAM_STR);
			$stmt->bindParam(8,$dados[$this->ani_unidade],PDO::PARAM_STR);
			$stmt->bindParam(9,$dados[$this->ani_codigo],PDO::PARAM_INT);

			$stmt->execute();
			
			return($stmt);

		}
		catch (PDOException $e)
		{
			throw new PDOException("Erro na tabela". get_class($this)."-". $e->getMessage(),$e->getCode());
		}

	}

	#Listar na tela de Aniversariantes
	public function listarAniversariante($dados)
	{
		$query = ("SELECT ani_codigo, ani_drt, ani_nome, ani_setor, ani_dia, ani_mes
					FROM tb_aniversariante
					WHERE ani_dia LIKE ?
					AND ani_mes LIKE ?
					AND ani_unidade LIKE ?
					AND ani_nome LIKE ?
					ORDER BY ani_dia
				  ");

		try
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->execute(array("{$dados[$this->ani_dia]}",
								 "{$dados[$this->ani_mes]}",
								 "{$dados[$this->ani_unidade]}",
								 "%{$dados[$this->ani_nome]}%"
								 )
							);

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}

	}
	
	#Listar na tela de Aniversariantes PDF
	public function listarAniversariantePDF($dados)
	{
		$query = ("SELECT ani_codigo, ani_dia, ani_nome, ani_setor
					FROM tb_aniversariante
					WHERE ani_mes LIKE ?
					AND ani_unidade LIKE ?
					ORDER BY ani_dia
				  ");

		try
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->execute(array("{$dados[$this->ani_mes]}",
								 "{$dados[$this->ani_unidade]}"
								)
							);

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}

	}
	
	#Get para o formulario de alteraчуo
	public function getForm($ani_codigo)
	{
		$query = ("SELECT *
					FROM tb_aniversariante
					WHERE $this->ani_codigo = ?
				  ");

		try
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$ani_codigo,PDO::PARAM_INT);
			
			$stmt->execute();

			return($stmt->fetch());

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}

	}
	
	public function delete($ani_codigo)
	{
		$query = ("DELETE FROM $this->tabela
					WHERE $this->ani_codigo = ? ");
					
		try
		{
			
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$ani_codigo,PDO::PARAM_INT);

			$stmt->execute();
			
			return($stmt);

		}
		catch (PDOException $e)
		{
			throw new PDOException("Erro na tabela". get_class($this)."-". $e->getMessage(),$e->getCode());
		}

	}
	
}

?>