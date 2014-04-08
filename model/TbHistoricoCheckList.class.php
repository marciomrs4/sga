<?php
class TbHistoricoCheckList extends Banco
{
	
	private $tabela = 'tb_historico_checklist';

	private $hck_codigo = 'hck_codigo';
	private $che_codigo = 'che_codigo';
	private $che_titulo = 'che_titulo';
	private $usu_email = 'usu_email';
	private $hck_data = 'hck_data';
	private $hck_status = 'hck_status';
	
	
	public function insert($dados)
	{
		$query = ("INSERT INTO $this->tabela
					($this->che_codigo, $this->che_titulo,
					$this->hck_status,$this->usu_email)
				  	VALUES(?,?,?,?)
					");
		
		try 
		{
			
		$stmt = $this->conexao->prepare($query);

		$stmt->bindParam(1,$dados[$this->che_codigo],PDO::PARAM_INT);
		$stmt->bindParam(2,$dados[$this->che_titulo],PDO::PARAM_STR);
		$stmt->bindParam(3,$dados[$this->hck_status],PDO::PARAM_STR);
		$stmt->bindParam(4,$dados[$this->usu_email],PDO::PARAM_STR);

		$stmt->execute();

		return($this->conexao->lastInsertId());

			
		} catch (PDOException $e) 
		{
			throw new PDOException($e->getMessage(), $e->getCode()); 
		}
		
	}

	#Usado dentro da Classe form componente para saber
	#Se o checklist foi efetuado
	public function confirmCheckList($che_codigo)
	{
		$query = ("SELECT hck_codigo, che_codigo, che_titulo, usu_email, 
						date_format(hck_data ,'%d-%m-%Y %H:%i:%s') AS hck_data, hck_status 
						FROM tb_historico_checklist 
						WHERE date_format(hck_data ,'%d-%m-%Y') = date_format(?,'%d-%m-%Y') 
						AND che_codigo = ?");

		try
		{
			
			$data = date('Y-m-d');
			
			$stmt = $this->conexao->prepare($query);
				
			$stmt->bindParam(1,$data,PDO::PARAM_STR);			
			$stmt->bindParam(2,$che_codigo,PDO::PARAM_INT);		
			
			$stmt->execute();
			
			$dados = $stmt->fetch();
				
			return($dados);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getMessage());
		}
	}
}
?>