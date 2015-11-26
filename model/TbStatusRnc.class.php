<?php

class TbStatusRnc extends Banco
{

	private $tabela = 'tb_status_rnc';

	public static function listarStatus()
	{
		return array(1 => array(1,'Aberta'),
			         2 => array(2,'Respondida'),
					 3 => array(3,'Verificada'),
					 4 => array(4,'Encerrada'),
			);
	}

	public function getStatusRnc($snc_codigo)
	{
		$query = ("SELECT snc_descricao
					FROM tb_status_rnc
					WHERE snc_codigo = ?");

		try{

			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$snc_codigo,\PDO::PARAM_INT);

			$stmt->execute();

			$dados = $stmt->fetch(\PDO::FETCH_ASSOC);

			return $dados['snc_descricao'];

		}catch (\PDOException $e){
			throw new \PDOException($e->getMessage(), $e->getCode());
		}

	}

}
?>