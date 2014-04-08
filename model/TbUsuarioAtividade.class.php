<?php

class TbUsuarioAtividade extends Banco
{

	private $tabela = 'tb_usuario_atividade';

	private $ua_codigo = 'ua_codigo';
	private $at_codigo = 'at_codigo';
	private $usu_codigo = 'usu_codigo';
	private $tua_codigo = 'tua_codigo';

	public function insert($dados)
	{

		$query =  ("INSERT INTO $this->tabela
					($this->at_codigo, $this->usu_codigo, $this->tua_codigo)
					VALUES(?,?,?)
					");

		try
		{

			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->at_codigo],PDO::PARAM_INT);
			$stmt->bindParam(2,$dados[$this->usu_codigo],PDO::PARAM_INT);
			$stmt->bindParam(3,$dados[$this->tua_codigo],PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);
		}
		catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}

	}

	#Usado na listagem do cadastro de Utilizador Atividade
	public function listar($at_codigo)
	{
		$query = ("SELECT ua_codigo,
				    (SELECT concat(usu_nome,' ',usu_sobrenome) 
				        FROM tb_usuario 
				        WHERE USA.usu_codigo = usu_codigo) AS usu_nome, 
				    (SELECT tua_descricao 
				        FROM tb_tipo_usuario_atividade 
				        WHERE USA.tua_codigo =  tua_codigo) AS tua_descricao
					FROM tb_usuario_atividade AS USA
					WHERE at_codigo = ?
				  ");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$at_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}

	}


	public function select($colum, $param = null)
	{

	}

	public function getForm($ua_codigo)
	{
		$query = ("SELECT ua_codigo, at_codigo,
						  usu_codigo, tua_codigo
					FROM tb_usuario_atividade
					WHERE ua_codigo = ?
					");

		try
		{

			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$ua_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetch());


		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}

	public function update($dados)
	{
		$query = ("UPDATE tb_usuario_atividade
			        SET usu_codigo = ?,
			            tua_codigo = ?
			        WHERE ua_codigo = ?
					");

		try
		{

			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->usu_codigo],PDO::PARAM_INT);
			$stmt->bindParam(2,$dados[$this->tua_codigo],PDO::PARAM_INT);
			$stmt->bindParam(3,$dados[$this->ua_codigo],PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);


		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}

	public function delete($dados)
	{
		$query = ("DELETE FROM tb_usuario_atividade
			        WHERE ua_codigo = ?
					");

		try
		{

			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->ua_codigo],PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);


		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}

		#Verifica se existe atividade com usuário informado
	public function verificaUsuariosAtividade($at_codigo)
	{
		$query = ("SELECT ua_codigo, at_codigo,
						  usu_codigo, tua_codigo
					FROM tb_usuario_atividade
					WHERE at_codigo = ?
					");

		try
		{

			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$at_codigo,PDO::PARAM_INT);

			$stmt->execute();

			$dados = $stmt->fetch();
			
			return($dados[0]);


		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}
		
	
}
?>