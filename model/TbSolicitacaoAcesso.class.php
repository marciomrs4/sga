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
        $query =  ("SELECT * FROM tb_solicitacao_acesso
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
}
?>