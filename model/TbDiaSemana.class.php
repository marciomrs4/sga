<?php
class TbDiaSemana extends Banco
{

	private $tabela = 'tb_dia_semana_item_checklist';
	
	private $dse_codigo = 'dse_codigo';
	private $ich_codigo = 'ich_codigo';
	private $dse_segunda = 'dse_segunda';
	private $dse_terca = 'dse_terca';
	private $dse_quarta = 'dse_quarta';
	private $dse_quinta = 'dse_quinta';
	private $dse_sexta = 'dse_sexta';
	private $dse_sabado = 'dse_sabado';
	private $dse_domingo = 'dse_domingo';
	
	
	public function insert($dados)
	{
	
		$query = ("INSERT INTO $this->tabela
					($this->ich_codigo, $this->dse_segunda, $this->dse_terca, $this->dse_quarta,
					$this->dse_quinta, $this->dse_sexta, $this->dse_sabado, $this->dse_domingo)
					VALUES(?,?,?,?,?,?,?,?)");

		try
		{

			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->ich_codigo],PDO::PARAM_INT);
			$stmt->bindParam(2,$dados[$this->dse_segunda],PDO::PARAM_INT);
			$stmt->bindParam(3,$dados[$this->dse_terca],PDO::PARAM_INT);
			$stmt->bindParam(4,$dados[$this->dse_quarta],PDO::PARAM_INT);
			$stmt->bindParam(5,$dados[$this->dse_quinta],PDO::PARAM_INT);
			$stmt->bindParam(6,$dados[$this->dse_sexta],PDO::PARAM_INT);
			$stmt->bindParam(7,$dados[$this->dse_sabado],PDO::PARAM_INT);
			$stmt->bindParam(8,$dados[$this->dse_domingo],PDO::PARAM_INT);
						
			$stmt->execute();

			$this->dse_codigo = $this->conexao->lastInsertId();
						
			return($this->dse_codigo);

		}
		catch (PDOException $e)
		{
			throw new PDOException("Erro na tabela". get_class($this)."-". $e->getMessage(),$e->getCode());
		}
	}
	
	public function update($dados)
	{
		$query = ("UPDATE $this->tabela
					SET $this->dse_segunda = ?, 
						$this->dse_terca = ?, 
						$this->dse_quarta = ?,
						$this->dse_quinta = ?, 
						$this->dse_sexta = ?, 
						$this->dse_sabado = ?, 
						$this->dse_domingo = ?
					WHERE $this->ich_codigo = ?");

		try
		{

			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->dse_segunda],PDO::PARAM_INT);
			$stmt->bindParam(2,$dados[$this->dse_terca],PDO::PARAM_INT);
			$stmt->bindParam(3,$dados[$this->dse_quarta],PDO::PARAM_INT);
			$stmt->bindParam(4,$dados[$this->dse_quinta],PDO::PARAM_INT);
			$stmt->bindParam(5,$dados[$this->dse_sexta],PDO::PARAM_INT);
			$stmt->bindParam(6,$dados[$this->dse_sabado],PDO::PARAM_INT);
			$stmt->bindParam(7,$dados[$this->dse_domingo],PDO::PARAM_INT);
			
			$stmt->bindParam(8,$dados[$this->ich_codigo],PDO::PARAM_INT);
			
			$stmt->execute();
						
			return($stmt);

		}
		catch (PDOException $e)
		{
			throw new PDOException("Erro na tabela". get_class($this)."-". $e->getMessage(),$e->getCode());
		}
	}

	public function select()
	{
		
	}
	
	public function getForm($ich_codigo)
	{
		$query = ("SELECT 
					$this->dse_segunda, $this->dse_terca, $this->dse_quarta,
					$this->dse_quinta, $this->dse_sexta, $this->dse_sabado, $this->dse_domingo
					FROM $this->tabela
					WHERE $this->ich_codigo = ?");

		try
		{

			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$ich_codigo,PDO::PARAM_INT);
			
			$stmt->execute();
			
			$dados = $stmt->fetch(PDO::FETCH_ASSOC);
		
			return($dados);

		}
		catch (PDOException $e)
		{
			throw new PDOException("Erro na tabela". get_class($this)."-". $e->getMessage(),$e->getCode());
		}
		
	}

		
}
?>