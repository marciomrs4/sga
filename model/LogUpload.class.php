<?php

class LogUpload extends Banco
{

	private $tabela = 'log_upload';
	private $log_codigo = 'log_codigo';
	private $usuario = 'usuario';
	private $data = 'data';
	private $arquivo = 'arquivo';
	private $acao = 'acao';
	private $tipo = 'tipo';
	private $codigo = 'codigo';


	public function insert($dados)
	{
		$query = ("INSERT INTO
					log_upload ($this->usuario, $this->arquivo,
								$this->acao, $this->tipo, $this->codigo)
					VALUES (?, ?, ?, ?, ?)");

		try{

			$stmt = $this->conexao->prepare($query);

			$stmt->bindParam(1,$dados['usuario'],\PDO::PARAM_STR);
			$stmt->bindParam(2,$dados['arquivo'],\PDO::PARAM_STR);
			$stmt->bindParam(3,$dados['acao'],\PDO::PARAM_STR);
			$stmt->bindParam(4,$dados['tipo'],\PDO::PARAM_STR);
			$stmt->bindParam(5,$dados['codigo'],\PDO::PARAM_STR);

			$stmt->execute();

			return $stmt;

		}catch (\PDOException $e){
			throw new \PDOException($e->getMessage(), $e->getCode());
		}
	}
}
?>