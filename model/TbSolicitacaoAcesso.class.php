<?php

class TbSolicitacaoAcesso extends Banco
{

    private $sac_codigo = 'sac_codigo';
    private $usu_codigo_solicitante = 'usu_codigo_solicitante';
    private $sol_codigo = 'sol_codigo';
    private $sac_datacadastro = 'sac_datacadastro';
    private $sac_formulario = 'sac_formulario';

    public function insert($dados)
    {
        $query =  ("INSERT INTO tb_solicitacao_acesso
                    (usu_codigo_solicitante, sol_codigo,
                    sac_datacadastro, sac_formulario)
                    VALUES(?, ?, ?, ?)");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados['usu_codigo_solicitante'],\PDO::PARAM_INT);
            $stmt->bindParam(2,$dados['sol_codigo'],\PDO::PARAM_INT);
            $stmt->bindParam(3,date('Y-m-d H:i:s'),\PDO::PARAM_STR);
            $stmt->bindParam(4,$dados['sac_formulario'],\PDO::PARAM_LOB);

            $stmt->execute();

            return $this->conexao->lastInsertId();

        }catch (\PDOException $e){
            throw new \PDOException($e);
        }


    }

    public function select($sac_codigo)
    {
        $query =  ("SELECT sac_codigo, usu_codigo_solicitante, sol_codigo,
		              date_format(sac_datacadastro,'%d-%m-%Y') AS sac_datacadastro,
		              sac_formulario
		              FROM tb_solicitacao_acesso
                    WHERE sac_codigo = ?");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$sac_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;

        }catch (\PDOException $e){
            throw new \PDOException($e);
        }


    }

    public function listControlAcess($dados)
    {
        $query =  ("SELECT SAC.sac_codigo, SOL.sol_codigo,
                        (SELECT sta_descricao FROM tb_status WHERE sta_codigo = SOL.sta_codigo) AS sta_descricao,
                        date_format(SAC.sac_datacadastro,'%d-%m-%Y %H:%i:%s') AS sac_datacadastro,
                        (SELECT usu_email FROM tb_usuario WHERE usu_codigo = ATE.usu_codigo_atendente) AS usu_email
                    FROM tb_solicitacao AS SOL
                    INNER JOIN tb_solicitacao_acesso AS SAC
                    ON SOL.sol_codigo = SAC.sol_codigo
                    LEFT JOIN tb_atendente_solicitacao AS ATE
                    ON SOL.sol_codigo = ATE.sol_codigo
                    WHERE SOL.sta_codigo LIKE ?
                    AND (SELECT dep_codigo FROM tb_usuario WHERE usu_codigo = SOL.usu_codigo_solicitante) = ?
                    AND SOL.sol_codigo LIKE ?
                    ORDER BY 1 DESC
                    ");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->execute(array("{$dados['sta_codigo']}",
                                 "{$dados['dep_codigo']}",
                                 "%{$dados['sol_codigo']}%")
                           );

            return $stmt;

        }catch (\PDOException $e){
            throw new \PDOException($e);
        }


    }

}
?>
