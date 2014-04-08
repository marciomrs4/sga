<?php

class TbLayout extends Banco
{

	private $tabela = 'tb_layout';

	private $lay_codigo = 'lay_codigo';
	private $lay_fundo_tela = 'lay_fundo_tela';
	private $lay_menu_principal = 'lay_menu_principal';
	private $lay_botoes_menu = 'lay_botoes_menu';
	private $lay_botoes_tela = 'lay_botoes_tela';
	private $lay_tabela = 'lay_tabela';
	private $lay_tabela_linha_par = 'lay_tabela_linha_par';
	private $lay_tabela_linha_impar = 'lay_tabela_linha_impar';
	private $lay_passar_mouse_botao = 'lay_passar_mouse_botao';
	private $lay_passar_mouse_tabela = 'lay_passar_mouse_tabela';
	private $usu_codigo = 'usu_codigo';
	
	
	public function selecLayoutUsuario($usu_codigo)
	{
		$query = ("SELECT * FROM $this->tabela
					WHERE $this->usu_codigo = ?");
		
		try 
		{
			$stmt = $this->conexao->prepare($query);
				
			$stmt->bindParam(1,$usu_codigo,PDO::PARAM_INT);
			
			$stmt->execute();
			
			$dados = $stmt->fetch(PDO::FETCH_ASSOC);
			
			return($dados);
			
		} catch (PDOException $e) 
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
		
	}
	
	public function insertLayout($usu_codigo)
	{
		
		
		$query = ("INSERT INTO 
					$this->tabela ($this->lay_fundo_tela, $this->lay_menu_principal, $this->lay_botoes_menu,
								   $this->lay_botoes_tela, $this->lay_tabela, $this->lay_tabela_linha_par,
								   $this->lay_tabela_linha_impar, $this->lay_passar_mouse_botao,
								   $this->lay_passar_mouse_tabela,$this->usu_codigo)
					VALUES(?,?,?,?,?,?,?,?,?,?)");

			$dados[$this->lay_fundo_tela] = '#FFFFFF';
			$dados[$this->lay_menu_principal] = '#0066CC';
			$dados[$this->lay_botoes_menu] = '#CFCFCF';
			$dados[$this->lay_botoes_tela] = '#CFCFCF';
			$dados[$this->lay_tabela]= '#5D81B1';
			$dados[$this->lay_tabela_linha_par] = '#000000';												
			$dados[$this->lay_tabela_linha_impar] = '#CCCCCC';
			$dados[$this->lay_passar_mouse_botao] = '#E8E8E8';
			$dados[$this->lay_passar_mouse_tabela] = '#778899';
					

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->lay_fundo_tela],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->lay_menu_principal],PDO::PARAM_STR);
			$stmt->bindParam(3,$dados[$this->lay_botoes_menu],PDO::PARAM_STR);
			$stmt->bindParam(4,$dados[$this->lay_botoes_tela],PDO::PARAM_STR);
			$stmt->bindParam(5,$dados[$this->lay_tabela],PDO::PARAM_STR);
			$stmt->bindParam(6,$dados[$this->lay_tabela_linha_par],PDO::PARAM_STR);												
			$stmt->bindParam(7,$dados[$this->lay_tabela_linha_impar],PDO::PARAM_STR);
			$stmt->bindParam(8,$dados[$this->lay_passar_mouse_botao],PDO::PARAM_STR);
			$stmt->bindParam(9,$dados[$this->lay_passar_mouse_tabela],PDO::PARAM_STR);
			$stmt->bindParam(10,$usu_codigo,PDO::PARAM_INT);
				
			$stmt->execute();

			return($this->conexao->lastInsertId());

		}
		catch (PDOException $e)
		{
			throw new PDOException("Erro na tabela". get_class($this)."-". $e->getMessage(),$e->getCode());
		}

	}

	public function updateLayout($dados)
	{
		$query = ("UPDATE $this->tabela
					SET	$this->lay_fundo_tela = ?,
						$this->lay_menu_principal = ?,
						$this->lay_botoes_menu = ?,
						$this->lay_botoes_tela = ?
					WHERE $this->usu_codigo = ? ");
		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->lay_fundo_tela],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->lay_menu_principal],PDO::PARAM_STR);			
			$stmt->bindParam(3,$dados[$this->lay_botoes_menu],PDO::PARAM_STR);
			$stmt->bindParam(4,$dados[$this->lay_botoes_tela],PDO::PARAM_STR);						
			$stmt->bindParam(5,$dados[$this->usu_codigo],PDO::PARAM_INT);									
			
			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}
	
	public function updateLayoutDefault($usu_codigo)
	{
		
		$query = ("UPDATE $this->tabela
					SET	$this->lay_fundo_tela = ?,
						$this->lay_menu_principal = ?,
						$this->lay_botoes_menu = ?,
						$this->lay_botoes_tela = ?,
						$this->lay_tabela = ?,
						$this->lay_tabela_linha_par = ?,
						$this->lay_tabela_linha_impar = ?,
						$this->lay_passar_mouse_botao = ?,
						$this->lay_passar_mouse_tabela = ?
					WHERE $this->usu_codigo = ? ");
		
			$dados[$this->lay_fundo_tela] = '#000000';
			$dados[$this->lay_menu_principal] = '#0066CC';
			$dados[$this->lay_botoes_menu] = '#CFCFCF';
			$dados[$this->lay_botoes_tela] = '#CFCFCF';
			$dados[$this->lay_tabela]= '#5D81B1';
			$dados[$this->lay_tabela_linha_par] = '#FFFFFF';												
			$dados[$this->lay_tabela_linha_impar] = '#CCCCCC';
			$dados[$this->lay_passar_mouse_botao] = '#E8E8E8';
			$dados[$this->lay_passar_mouse_tabela] = '#778899';
			
			try 
			{

			$stmt = $this->conexao->prepare($query);
					
				$stmt->bindParam(1,$dados[$this->lay_fundo_tela],PDO::PARAM_STR);
				$stmt->bindParam(2,$dados[$this->lay_menu_principal],PDO::PARAM_STR);
				$stmt->bindParam(3,$dados[$this->lay_botoes_menu],PDO::PARAM_STR);
				$stmt->bindParam(4,$dados[$this->lay_botoes_tela],PDO::PARAM_STR);
				$stmt->bindParam(5,$dados[$this->lay_tabela],PDO::PARAM_STR);
				$stmt->bindParam(6,$dados[$this->lay_tabela_linha_par],PDO::PARAM_STR);												
				$stmt->bindParam(7,$dados[$this->lay_tabela_linha_impar],PDO::PARAM_STR);
				$stmt->bindParam(8,$dados[$this->lay_passar_mouse_botao],PDO::PARAM_STR);
				$stmt->bindParam(9,$dados[$this->lay_passar_mouse_tabela],PDO::PARAM_STR);
				$stmt->bindParam(10,$usu_codigo,PDO::PARAM_INT);
				
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
	
	public function getForm($codigo)
	{

		$query = ("SELECT * FROM  $this->tabela 
				   WHERE $this-> = ?");

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