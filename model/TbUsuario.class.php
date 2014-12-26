<?php

class TbUsuario extends Banco
{

	private $tabela = 'tb_usuario';

	private $usu_codigo = 'usu_codigo';
	private $usu_nome = 'usu_nome';
	private $usu_sobrenome = 'usu_sobrenome';
	private $usu_email = 'usu_email';
	private $usu_ramal = 'usu_ramal';
	private $dep_codigo = 'dep_codigo';
	private $tac_codigo = 'tac_codigo';
	private $usu_cargo = 'usu_cargo';
	private $usu_drt = 'usu_drt';
	
	public function insert($dados)
	{
		
		
		$query = ("INSERT INTO $this->tabela 
					($this->usu_nome, $this->usu_sobrenome, $this->usu_email,
					 $this->usu_ramal, $this->dep_codigo, $this->tac_codigo)
					VALUES(?,?,?,?,?,?)
				  ");

		try{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->usu_nome],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->usu_sobrenome],PDO::PARAM_STR);
			$stmt->bindParam(3,$dados[$this->usu_email],PDO::PARAM_STR);
			$stmt->bindParam(4,$dados[$this->usu_ramal],PDO::PARAM_STR);
			$stmt->bindParam(5,$dados[$this->dep_codigo],PDO::PARAM_INT);
			$stmt->bindParam(6,$dados[$this->tac_codigo],PDO::PARAM_INT);															

			$stmt->execute();

			return($this->conexao->lastInsertId());

		}
		catch (PDOException $e)
		{
			throw new PDOException("Erro na tabela". get_class($this)."-". $e->getMessage(),$e->getCode());
		}

	}

	public function update($dados)
	{
		$query = ("UPDATE $this->tabela
					SET	$this->usu_nome = ?,
						$this->usu_sobrenome = ?,
						$this->usu_email = ?,
						$this->usu_ramal = ?,
						$this->dep_codigo = ?,
						$this->tac_codigo = ?
																										
					WHERE $this->usu_codigo = ? ");
		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->usu_nome],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[$this->usu_sobrenome],PDO::PARAM_STR);
			$stmt->bindParam(3,$dados[$this->usu_email],PDO::PARAM_STR);
			$stmt->bindParam(4,$dados[$this->usu_ramal],PDO::PARAM_STR);
			$stmt->bindParam(5,$dados[$this->dep_codigo],PDO::PARAM_INT);
			$stmt->bindParam(6,$dados[$this->tac_codigo],PDO::PARAM_INT);
			$stmt->bindParam(7,$dados[$this->usu_codigo],PDO::PARAM_INT);

			$stmt->execute();

			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	#utilizado no cadastro de apontamento/atribuicao de atividade 
	public function selectUsuarioDepCompleto($dep_codigo)
	{
		$query = ("SELECT a.usu_codigo, concat(a.usu_nome,' ',a.usu_sobrenome)
					FROM tb_usuario as a
					INNER JOIN tb_acesso AS c
					ON a.usu_codigo = c.usu_codigo
					WHERE a.usu_codigo != 1 
					AND c.ace_ativo = 'S'
					AND dep_codigo = ?
					ORDER BY 2;
                    ");
		
		try 
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$dep_codigo,PDO::PARAM_INT);
			
			$stmt->execute();
			
			return($stmt);
			
		} catch (PDOException $e) 
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
		
	}

	
	#Listagem de usuсrios, usada para busca na tela de Operaчуo/atividade
	public function selectUsuarioPorDepartamento($dep_codigo)
	{
			$query = ("SELECT a.usu_codigo, a.usu_nome
						FROM tb_usuario as a
						INNER JOIN tb_acesso AS c
						ON a.usu_codigo = c.usu_codigo
						WHERE a.usu_codigo != 1 
						AND c.ace_ativo = 'S'
						AND dep_codigo = ?
						ORDER BY 2;
					");
		
		try 
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$dep_codigo,PDO::PARAM_INT);
			
			$stmt->execute();
			
			return($stmt);
			
		} catch (PDOException $e) 
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
		
	}
	
	
	#Usado na lista de usuсrios na abertura de chamado
	public function selectUsuarios()
	{
		$query = ("SELECT usu_codigo, concat(usu_nome,' ',usu_sobrenome), dep_descricao, tac_descricao
					FROM tb_usuario AS a
					INNER JOIN tb_departamento AS b
					ON a.dep_codigo = b.dep_codigo
					INNER JOIN tb_tipo_acesso AS c
					ON a.tac_codigo = c.tac_codigo
        		    WHERE usu_codigo != 1
        		    ORDER BY 2
				");
		
		try 
		{
			$stmt = $this->conexao->prepare($query);
			
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
	
	public function getUsuario($usu_codigo)
	{
		$query = ("SELECT $this->usu_nome, $this->usu_sobrenome, $this->usu_email,
						  $this->usu_ramal, $this->dep_codigo, $this->tac_codigo
    				FROM $this->tabela
    				WHERE $this->usu_codigo = ?
    			  ");

		try
		{
			$stmt = $this->conexao->prepare($query);
				
			$stmt->bindParam(1,$usu_codigo,PDO::PARAM_INT);
				
			$stmt->execute();
				
			return($stmt->fetch());

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getMessage());
		}
	}
	
	public function getForm($usu_codigo)
	{

		$query = ("SELECT $this->usu_codigo, $this->usu_nome, $this->usu_sobrenome, $this->usu_email,
						  $this->usu_ramal, $this->dep_codigo, $this->tac_codigo 
						  FROM  $this->tabela 
				   		WHERE $this->usu_codigo = ?");

		try
		{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$usu_codigo,PDO::PARAM_INT);

			$stmt->execute();

			return($stmt->fetch());

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}

	}

	public function validaEmailUsuario($usu_email)
	{
		
		$query = ("SELECT $this->usu_codigo 
					FROM $this->tabela
					WHERE $this->usu_email = ?");
		
		try 
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$usu_email,PDO::PARAM_STR);
			
			$stmt->execute();
			
			$dados = $stmt->fetch();
			
			return($dados[0]);
			
		} catch (PDOException $e) 
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
		
	}
	
	#Listagem usada no cadastro de usuario Atividade
	public function selectUsuariosAtividade($dados)
	{
		$query = ("SELECT usu_codigo, concat(usu_nome,' ',usu_sobrenome) 
					as usu_nome 
					FROM tb_usuario 
					WHERE usu_codigo NOT IN(?,?)
					AND usu_codigo != 1
				  ");
		
		try 
		{
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1,$dados[2],PDO::PARAM_STR);
			$stmt->bindParam(2,$dados[3],PDO::PARAM_STR);			
			
			$stmt->execute();
			
			return($stmt);
			
		} catch (PDOException $e) 
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}
	
	#Listagem usada na tela de cadastro de usuario
	public function listarUsuarios($dados)
	{
		$query = ("SELECT a.usu_codigo, IF(ACE.ace_ativo = 'S','Ativo','Inativo'), concat(a.usu_nome,' ',a.usu_sobrenome), b.dep_descricao, c.tac_descricao, a.usu_email, a.usu_ramal
					FROM tb_usuario AS a
						INNER JOIN tb_departamento AS b
						ON a.dep_codigo = b.dep_codigo
						INNER JOIN tb_tipo_acesso AS c
						ON a.tac_codigo = c.tac_codigo
						INNER JOIN tb_acesso AS ACE
						ON a.usu_codigo = ACE.usu_codigo
	        		    WHERE a.usu_codigo != 1
	                AND a.dep_codigo LIKE ?
	                AND a.usu_nome LIKE ?
        		    ORDER BY 2,3;
				");

		
		try 
		{
			$stmt = $this->conexao->prepare($query);
						
			$stmt->execute(array("{$dados['dep_codigo']}","%{$dados['usu_nome']}%"));
			
			return($stmt);
			
		} catch (PDOException $e) 
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}

	#Listagem usada no Painel de Chamados
	public function listarUsuariosPainel($dados)
	{
/*		$query = ("SELECT u.usu_codigo, u.usu_nome
					FROM tb_usuario u
					INNER JOIN tb_acesso a
					ON u.usu_codigo = a.usu_codigo
					WHERE u.dep_codigo = ?
					AND a.ace_ativo = 'S'");
*/
		
			$query = ("SELECT u.usu_codigo, count(ATS.sol_codigo) , u.usu_nome
				FROM tb_usuario u
				INNER JOIN tb_acesso a
				ON u.usu_codigo = a.usu_codigo
				INNER JOIN tb_atendente_solicitacao AS ATS
				ON ATS.usu_codigo_atendente = U.usu_codigo
				LEFT JOIN tb_solicitacao AS SOL
				ON SOL.sol_codigo = ATS.sol_codigo
				WHERE u.dep_codigo = ?
				AND SOL.sta_codigo = ?
				AND a.ace_ativo = 'S'
				GROUP BY u.usu_codigo
				ORDER BY 2 DESC");
		
		try 
		{
			$stmt = $this->conexao->prepare($query);
						
			$stmt->execute(array("{$dados['dep_codigo']}",
								"{$dados['sta_codigo']}"));
			
			return($stmt);
			
		} catch (PDOException $e) 
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}
	
	#Listagem usada no Painel de Atividade
	public function listarUsuariosPainelAtividade($dados)
	{
	
		$query = ("SELECT u.usu_codigo, count(ATS.at_codigo) , u.usu_nome
				FROM tb_usuario u
				INNER JOIN tb_acesso a
				ON u.usu_codigo = a.usu_codigo
				INNER JOIN tb_atividade AS ATS
				ON ATS.usu_codigo_responsavel = U.usu_codigo
				WHERE u.dep_codigo = ?
				AND ATS.sta_codigo = ?
				AND a.ace_ativo = 'S'
				GROUP BY u.usu_codigo
				ORDER BY 2 DESC");
	
		try
		{
			$stmt = $this->conexao->prepare($query);
	
			$stmt->execute(array("{$dados['dep_codigo']}",
			"{$dados['sta_codigo']}"));
				
			return($stmt);
				
		} catch (PDOException $e)
		{
		throw new PDOException($e->getMessage(),$e->getCode());
		}
	}
	
	
	#Lista de Ramais usado na Intranet
	public function listarRamaisIntranet()
	{
		
		$query = ("SELECT concat(usu_nome,' ',usu_sobrenome) AS Nome, usu_ramal, usu_email AS Ramal, DEP.dep_descricao AS Departamento
						FROM tb_usuario AS USU
						INNER JOIN tb_departamento AS DEP
						ON USU.dep_codigo = DEP.dep_codigo
						INNER JOIN tb_acesso AS ACE
						ON USU.usu_codigo = ACE.usu_codigo
						WHERE ace_ativo = 'S' AND USU.usu_codigo != 1
						");
	
		try{
			
			$stmt = $this->conexao->prepare($query);
			$stmt->execute();
			return($stmt);
				
		} catch (PDOException $e){
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}
	
	
	#Grafico de Pizza, Chamado por usuario
	public function graficoChamadoPorUsuario($dados)
	{
	
		$query = ("SELECT u.usu_nome as 'Usuario', count(ATS.sol_codigo) as 'QTD'
				FROM tb_usuario u
				INNER JOIN tb_acesso a
				ON u.usu_codigo = a.usu_codigo
				INNER JOIN tb_atendente_solicitacao AS ATS
				ON ATS.usu_codigo_atendente = U.usu_codigo
				LEFT JOIN tb_solicitacao AS SOL
				ON SOL.sol_codigo = ATS.sol_codigo
				WHERE u.dep_codigo = :dep_codigo
				AND SOL.sta_codigo = :sta_codigo
				AND a.ace_ativo = :ace_ativo
				GROUP BY u.usu_codigo
				ORDER BY 2 DESC");
	
		try{
				
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(':dep_codigo', $dados['dep_codigo']);
			$stmt->bindParam(':sta_codigo', $dados['sta_codigo']);
			$stmt->bindParam(':ace_ativo', $dados['ace_ativo']);
			
			$stmt->execute();
			
			foreach ($stmt as $value){
				echo '[',"'",$value[0],"'",',',$value[1],'],';
			}
				
	
		} catch (PDOException $e){
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}
	
	public function getDepCodigo($usu_codigo)
	{
		$query = ("SELECT dep_codigo 
					FROM tb_usuario 
					WHERE usu_codigo = ?");

		try {
			
			$stmt = $this->conexao->prepare($query);
			
			$stmt->bindParam(1, $usu_codigo,PDO::PARAM_INT);
			
			$stmt->execute();
			
			$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
			
			return($usuario['dep_codigo']);
			
			
		} catch (PDOException $e) {
			throw new PDOException($e->getMessage(), $e->getCode());
		}
		
	}
	
}
?>