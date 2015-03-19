<?php
class TbSistemas extends Banco
{
	
	private $tabela = tb_sistemas;
	
	private $sis_codigo = sis_codigo;
	private $sis_descricao = sis_descricao;
	private $usu_codigo_usuario_chave = usu_codigo_usuario_chave;
	private $sis_status = sis_status;
	
	public function insert($dados)
	{
		$query = ("INSERT INTO
					tb_sistemas (sis_descricao, usu_codigo_usuario_chave, sis_status)
					VALUES ( ?, ?, ?)");
		
		try {
			
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$dados['sis_descricao'],\PDO::PARAM_STR);
			$stmt->bindParam(2,$dados['usu_codigo_usuario_chave'],\PDO::PARAM_INT);
			$stmt->bindParam(3,$dados['sis_status'],\PDO::PARAM_STR);
			
			$stmt->execute();
			
			return $this->conexao->lastInsertId();
			
		} catch (\PDOException $e) {
			throw new \PDOException($e->getMessage(), $e->getCode());
		}
		
	}

	/**
	 * Usado no cadastro de Solicitacao de melhoria
	 * 
	 * 
	 */
	public function listarSistemas()
	{
		$query = ("SELECT sis_codigo, sis_descricao
					FROM tb_sistemas");
		
		try {
				
			$stmt = $this->conexao->prepare($query);
				
			$stmt->execute();
				
			return $stmt;
				
		} catch (\PDOException $e) {
			throw new \PDOException($e->getMessage(), $e->getCode());
		}
		
	}
	
	/**
	 * Usado na listagem de melhoria, na tela de melhoria
	 *
	 *
	 */
	public function listarSistemasPesquisa($usu_codigo_usuario_chave)
	{
		$query = ("SELECT sis_codigo, sis_descricao, concat(usu_nome,' ',usu_sobrenome)
					FROM tb_sistemas AS SIS
					INNER JOIN tb_usuario
					ON usu_codigo = usu_codigo_usuario_chave
					WHERE usu_nome LIKE ?
					ORDER BY 1;");
	
		try {
	
			$stmt = $this->conexao->prepare($query);
			
			$stmt->execute(array("%{$usu_codigo_usuario_chave}%"));
	
			return $stmt;
	
		} catch (\PDOException $e) {
			throw new \PDOException($e->getMessage(), $e->getCode());
		}
	
	}
	
	
	public function getUsuarioChave($sis_codigo)
	{
		
		$query = ("SELECT usu_codigo_usuario_chave 
					FROM tb_sistemas
					WHERE sis_codigo = ?");
		
		try {
		
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$sis_codigo,\PDO::PARAM_INT);
		
			$stmt->execute();
		
			$dados = $stmt->fetch(PDO::FETCH_ASSOC);
			
			return $dados['usu_codigo_usuario_chave'];
		
		} catch (\PDOException $e) {
			throw new \PDOException($e->getMessage(), $e->getCode());
		}
		
	}
	
	public function update($dados)
	{
		$query = ("UPDATE $this->tabela
					SET	$this->sis_descricao = ?,
						$this->usu_codigo_usuario_chave = ?,
						$this->sis_status = ?
					WHERE $this->sis_codigo = ? ");
					try
					{
						$stmt = $this->conexao->prepare($query);

						$stmt->bindParam(1,$dados[$this->sis_descricao],PDO::PARAM_INT);
						$stmt->bindParam(2,$dados[$this->usu_codigo_usuario_chave],PDO::PARAM_INT);
						$stmt->bindParam(3,$dados[$this->sis_status],PDO::PARAM_INT);
						$stmt->bindParam(4,$dados[$this->sis_codigo],PDO::PARAM_INT);
							
						$stmt->execute();

						return($stmt);

					} catch (PDOException $e)
					{
						throw new PDOException("Erro em TbSolicitacao".$e->getMessage(),$e->getCode());
					}

	}

	public function select()
	{
		
	}
	
	/**
	 * Usado para obeter informacoes de envio de email
	 * @param unknown $sis_codigo
	 * @throws \PDOException
	 */
	
	public function getForm($sis_codigo)
	{

		$query = ("SELECT sis_codigo, sis_descricao, 
						  usu_codigo_usuario_chave, sis_status
					FROM tb_sistemas
					WHERE sis_codigo = ?");
		
		try {
		
			$stmt = $this->conexao->prepare($query);
				
			$stmt->bindParam(1,$sis_codigo,\PDO::PARAM_INT);
		
			$stmt->execute();
		
			return $stmt->fetch(PDO::FETCH_ASSOC);
				
		
		} catch (\PDOException $e) {
			throw new \PDOException($e->getMessage(), $e->getCode());
		}
			
	}

		
}
?>