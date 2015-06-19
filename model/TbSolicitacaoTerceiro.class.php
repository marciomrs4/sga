<?php

class TbSolicitacaoTerceiro extends Banco
{

	private $tabela = 'tb_solicitacao_terceiro';
	private $sot_codigo = 'sot_codigo';
	private $sol_codigo = 'sol_codigo';
	private $ter_codigo = 'ter_codigo';
	private $usu_codigo_inclusao = 'usu_codigo_inclusao';
	private $sot_data_inclusao = 'sot_data_inclusao';
	private $sot_descricao_inclusao = 'sot_descricao_inclusao';
	private $sot_data_criacao_inclusao = 'sot_data_criacao_inclusao';
	private $usu_codigo_remocao = 'usu_codigo_remocao';
	private $sot_data_remocao = 'sot_data_remocao';
	private $sot_descricao_remocao = 'sot_descricao_remocao';
	private $sot_data_criacao_remocao = 'sot_data_criacao_remocao';
	private $sot_tempo_util = 'sot_tempo_util';
	private $sot_tempo_total = 'sot_tempo_total';
    private $sot_status = 'sot_status';
	
	
	public function insert($dados)
	{
		$query = ("INSERT INTO 
						tb_solicitacao_terceiro (sol_codigo, ter_codigo, usu_codigo_inclusao, 
												 sot_data_inclusao, sot_descricao_inclusao, 
												 sot_data_criacao_inclusao) 
					VALUES (?, ?, ?, ?, ?, ?)");
	
		try {	
			
			$stmt = $this->conexao->prepare($query);
		
			$stmt->bindParam(1, $dados['sol_codigo'], PDO::PARAM_INT);
			$stmt->bindParam(2, $dados['ter_codigo'], PDO::PARAM_INT);
			$stmt->bindParam(3, $dados['usu_codigo_inclusao'], PDO::PARAM_INT);
			$stmt->bindParam(4, $dados['sot_data_inclusao'], PDO::PARAM_STR);
			$stmt->bindParam(5, $dados['sot_descricao_inclusao'], PDO::PARAM_STR);
			$stmt->bindParam(6, $dados['sot_data_criacao_inclusao'], PDO::PARAM_STR);
			
			$stmt->execute();

			return $this->conexao->lastInsertId();
			
		} catch (PDOException $e) {
			throw new PDOException($e->getMessage(), $e->getCode());
		}
		
		
	}
		
		
	
	public function updateRemocaoTerceiro($dados)
	{
	    $query = ("UPDATE $this->tabela
	                SET $this->usu_codigo_remocao = ?,
	                    $this->sot_data_remocao = ?,
	                    $this->sot_descricao_remocao = ?,
	                    $this->sot_data_criacao_remocao = ?,
	                    $this->sot_tempo_util = ?,
	                    $this->sot_tempo_total = ?,
	                    $this->sot_status = ?
	                WHERE $this->sot_codigo = ?");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados['usu_codigo_remocao'],\PDO::PARAM_INT);
            $stmt->bindParam(2,$dados['sot_data_remocao'],\PDO::PARAM_STR);
            $stmt->bindParam(3,$dados['sot_descricao_remocao'],\PDO::PARAM_STR);
            $stmt->bindParam(4,$dados['sot_data_criacao_remocao'],\PDO::PARAM_STR);
            $stmt->bindParam(5,$dados['sot_tempo_util'],\PDO::PARAM_STR);
            $stmt->bindParam(6,$dados['sot_tempo_total'],\PDO::PARAM_STR);
            $stmt->bindParam(7,$dados['sot_status'],\PDO::PARAM_STR);
            $stmt->bindParam(8,$dados['sot_codigo'],\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;


        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

	
	}
	
	
	public function select()
	{
		$query = ("SELECT sot_codigo, sol_codigo, ter_codigo, 
						  usu_codigo_inclusao, sot_data_inclusao, 
						  sot_descricao_inclusao, sot_data_criacao_inclusao, 
						  usu_codigo_remocao, sot_data_remocao, sot_descricao_remocao, 
						  sot_data_criacao_remocao, sot_tempo_util, sot_tempo_total 
					FROM tb_solicitacao_terceiro");
	}

    /*Usado na tela de alteracao de solicitacao e validacao ao tentar criar uma nova entrada
    de terceiro
    */
    public function getChamadoInTerceiro($sol_codigo)
    {

        $query = ("SELECT sot_codigo, sol_codigo, sot_status
					FROM tb_solicitacao_terceiro
					WHERE sol_codigo = ?
					AND sot_status = 'S'");

        try
        {

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$sol_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);


        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }

    /*Usado na tela de envio de terceiro, quando vamos remover do terceiro
    formulario de EnvioTerceiro
  */
    public function getTerceiro($sot_codigo)
    {

        $query = ("SELECT sot_codigo, sol_codigo, sot_descricao_inclusao, ter_codigo
					FROM tb_solicitacao_terceiro
					WHERE sot_codigo = ?");

        try
        {

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$sot_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;


        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }

    /*Usado na tela de envio de terceiro, lista de envios para terceiro
  */
    /**
     * @param $sol_codigo
     * @return PDOStatement
     * @exemplo Usado para alguma coisa
     */
    public function listarEnvioTerceiro($sol_codigo)
    {

        $query = ("SELECT sot_codigo, TER.ter_descricao, concat(USU.usu_nome,' ' ,USU.usu_sobrenome) AS 'Usuario',
                           date_format(sot_data_inclusao,'%d-%m-%Y %H:%i:%s') AS sot_data_inclusao,
                           substring(sot_descricao_inclusao,1,30)
                    FROM tb_solicitacao_terceiro AS SOL
                    INNER JOIN tb_usuario AS USU
                    ON USU.usu_codigo = SOL.usu_codigo_inclusao
                    INNER JOIN tb_terceiro AS TER
                    ON TER.ter_codigo = SOL.ter_codigo
                    WHERE sol_codigo = ?
                    ");

        try
        {

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$sol_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;


        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }

    /*Usado na tela de remocao de terceiro, lista de remocao de terceiro
*/
    public function listarRemocaoTerceiro($sol_codigo)
    {

        $query = ("SELECT sot_codigo, TER.ter_descricao, concat(USU.usu_nome,' ' ,USU.usu_sobrenome) AS 'Usuario',
                           date_format(sot_data_remocao,'%d-%m-%Y %H:%i:%s') AS sot_data_remocao,
                           substring(sot_descricao_remocao,1,30) as 'Descricao'
                    FROM tb_solicitacao_terceiro AS SOL
                    INNER JOIN tb_usuario AS USU
                    ON USU.usu_codigo = SOL.usu_codigo_remocao
                    INNER JOIN tb_terceiro AS TER
                    ON TER.ter_codigo = SOL.ter_codigo
                    WHERE sol_codigo = ?
                    ");

        try
        {

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$sol_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;


        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }

    /*Usado no formulario de remocao de terceiro, e usado no metodo
    getTempoEmTerceiro
*/
    public function getDataEnvioTerceiro($sot_codigo)
    {

        $query = ("SELECT sot_data_inclusao
					FROM tb_solicitacao_terceiro
					WHERE sot_codigo = ?");

        try
        {

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$sot_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            $data =  $stmt->fetch(\PDO::FETCH_ASSOC);

            return $data['sot_data_inclusao'];

        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }

/*
 * Tempo util usado para o calculo no momento de gravar o retorno do terceiro
 */
    public function getTempoUtil($sot_codigo)
    {

        $query = ("SELECT sec_to_time(SUM((time_to_sec(sot_tempo_util)))) AS TempoUtil
                    FROM tb_solicitacao_terceiro
                    WHERE sol_codigo = ?");

        try
        {

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$sot_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            $data = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $data['sot_data_inclusao'];

        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }

    /* Retorna o terceiro que foi usado no envio do terceiro */
    public function getDescricaoTerceiro($sot_codigo)
    {

        $query = ("SELECT TER.ter_descricao
                    FROM tb_solicitacao_terceiro AS SOL
	                INNER JOIN tb_terceiro AS TER
                    ON TER.ter_codigo = SOL.ter_codigo
                    WHERE sot_codigo = ?;");

        try
        {

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$sot_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            $dados = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $dados['ter_descricao'];

        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }

    /* Retorna a data de criacao deste envio para terceiro */
    public function getTempoEmTerceiro($sot_codigo)
    {


        try{

            $dataEnvio = new DateTime($this->getDataEnvioTerceiro($sot_codigo));

            $dataAtual = new DateTime();

            return $dataEnvio->diff($dataAtual)
                             ->format('%Y Anos %M meses %D dias %H horas %I minutos e %S segundos.');


        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }

}
?>