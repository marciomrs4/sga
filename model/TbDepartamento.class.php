<?php

class TbDepartamento extends Banco
{

	private $tabela = 'tb_departamento';

	private $dep_codigo = 'dep_codigo';
	private $dep_descricao = 'dep_descricao';
	private $dep_email = 'dep_email';
	private $pro_permite_listar_chamado = 'pro_permite_listar_chamado';

    /** Campos add devido ao calculo do tempo de atendimento*/
    private $dep_hora_inicio = 'dep_hora_inicio';
    private $dep_hora_fim = 'dep_hora_fim';
    private $dep_hora_almoco = 'dep_hora_almoco';
    private $dep_carga_sabado = 'dep_carga_sabado';


	public function getDepDescricao($dep_codigo)
	{

		$query = ("SELECT $this->dep_descricao
						FROM $this->tabela
						WHERE $this->dep_codigo= ?");
		try
		{
			$stmt = $this->conexao->prepare($query);
			$stmt->bindParam(1,$dep_codigo,PDO::PARAM_INT);
			$stmt->execute();
			$dados = $stmt->fetch();
			return($dados[0]);

		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}

	public function getDepartamentoEmail($dep_codigo)
	{

		$query = ("SELECT $this->dep_email
						FROM $this->tabela
						WHERE $this->dep_codigo = ?");
		try
		{
			$stmt = $this->conexao->prepare($query);
			$stmt->bindParam(1,$dep_codigo,PDO::PARAM_INT);
			$stmt->execute();
			$dados = $stmt->fetch();
			return($dados[0]);

		}catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}

	public function insert($dados)
	{


		$query = ("INSERT INTO $this->tabela ($this->dep_descricao,
		$this->dep_email, $this->pro_permite_listar_chamado)
					VALUES(?, ?, ?)");

		try{
			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados[$this->dep_descricao],PDO::PARAM_INT);
			$stmt->bindParam(2,$dados[$this->dep_email],PDO::PARAM_STR);
			$stmt->bindParam(3,$dados[$this->pro_permite_listar_chamado],PDO::PARAM_STR);
            $stmt->bindParam(4,$dados[$this->dep_hora_inicio],PDO::PARAM_INT);
            $stmt->bindParam(5,$dados[$this->dep_hora_fim],PDO::PARAM_INT);
            $stmt->bindParam(6,$dados[$this->dep_hora_almoco],PDO::PARAM_INT);
            $stmt->bindParam(7,$dados[$this->dep_carga_sabado],PDO::PARAM_INT);

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
					SET	$this->dep_descricao = ?,
					    $this->dep_email = ?,
					    $this->pro_permite_listar_chamado = ?,
					    $this->dep_hora_inicio = ?,
                        $this->dep_hora_fim = ?,
                        $this->dep_hora_almoco = ?,
                        $this->dep_carga_sabado = ?
					WHERE $this->dep_codigo = ? ");
					try
					{
						$stmt = $this->conexao->prepare($query);
						$stmt->bindParam(1,$dados[$this->dep_descricao],PDO::PARAM_STR);
						$stmt->bindParam(2,$dados[$this->dep_email],PDO::PARAM_STR);
						$stmt->bindParam(3,$dados[$this->pro_permite_listar_chamado],PDO::PARAM_INT);
                        $stmt->bindParam(4,$dados[$this->dep_hora_inicio],PDO::PARAM_INT);
                        $stmt->bindParam(5,$dados[$this->dep_hora_fim],PDO::PARAM_INT);
                        $stmt->bindParam(6,$dados[$this->dep_hora_almoco],PDO::PARAM_INT);
                        $stmt->bindParam(7,$dados[$this->dep_carga_sabado],PDO::PARAM_INT);
						$stmt->bindParam(8,$dados[$this->dep_codigo],PDO::PARAM_INT);

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

	public function listarMeusDepartamentos($dep_codigo)
	{
		$query = ("SELECT dep_codigo, dep_descricao
					FROM $this->tabela 
					WHERE dep_codigo = ?
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

	#Usado em Cadastro de usuario e altera��o de usuario
	public function listarTodosDepartamentos()
	{
		$query = ("SELECT dep_codigo, dep_descricao, dep_email, 
    				IF(pro_permite_listar_chamado = 1,'SIM','NAO') as 'Listar Chamado'
					FROM tb_departamento 
					WHERE dep_codigo != 1
				  ");

		try
		{
			$stmt = $this->conexao->prepare($query);
			$stmt->execute();
			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}

	}


	#Permite listar, usado nas telas de cadastro de problemas e cadastro de checklist
	public function listarDepartamentos()
	{
		$query = ("SELECT dep_codigo, dep_descricao, dep_email
					FROM tb_departamento 
					WHERE pro_permite_listar_chamado = 1
				  ");

		try
		{
			$stmt = $this->conexao->prepare($query);
			$stmt->execute();
			return($stmt);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}

	}

	public function getForm($codigo)
	{

		$query = ("SELECT * FROM  $this->tabela
				   WHERE $this->dep_codigo = ?");

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

	#Grafico de Pizza, Chamados por Area
	public function graficoChamadoPorArea()
	{
	
		$query = ("SELECT DEP.dep_descricao, count(USU.dep_codigo)
					FROM tb_solicitacao AS SOL
					INNER JOIN tb_usuario AS USU
					ON SOL.usu_codigo_solicitante = USU.usu_codigo
					INNER JOIN tb_departamento AS DEP
					ON USU.dep_codigo = DEP.dep_codigo
					WHERE sol_data_inicio >= '2014-01-01 00:00:00' AND sol_data_fim <= '2014-12-31 23:59:59'
					GROUP BY USU.dep_codigo
					ORDER BY 2 DESC
					LIMIT 10;");
	
		try{
	
			$stmt = $this->conexao->prepare($query);
				
/* 			$stmt->bindParam(':dep_codigo', $dados['dep_codigo']);
			$stmt->bindParam(':sta_codigo', $dados['sta_codigo']);
			$stmt->bindParam(':ace_ativo', $dados['ace_ativo']); */
				
			$stmt->execute();
				
			foreach ($stmt as $value){
				echo '[',"'",utf8_encode($value[0]),"'",',',$value[1],'],';
			}
	
	
		} catch (PDOException $e){
			throw new PDOException($e->getMessage(),$e->getCode());
		}
	}
	

    public function getAllHours($dep_codigo)
    {

        $query = ("SELECT dep_hora_inicio, dep_hora_fim,
                          dep_hora_almoco, dep_carga_sabado
                      FROM  $this->tabela
				      WHERE $this->dep_codigo = ?");

        try
        {
            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dep_codigo,PDO::PARAM_INT);

            $stmt->execute();

            return($stmt->fetch(\PDO::FETCH_ASSOC));

        } catch (PDOException $e)
        {
            throw new PDOException($e->getMessage(),$e->getCode());
        }
    }

}
?>