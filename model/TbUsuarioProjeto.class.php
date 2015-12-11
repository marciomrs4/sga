<?php

class TbUsuarioProjeto extends Banco
{

    private $tabela = 'tb_usuario_projeto';
    private $usp_codigo = 'usp_codigo';
    private $pro_codigo = 'pro_codigo';
    private $usu_codigo_integrante = 'usu_codigo_integrante';
    private $usu_codigo_criador = 'usu_codigo_criador';
    private $usp_data_criacao = 'usp_data_criacao';


    public function insert($dados)
    {
        $query = ("INSERT INTO
                        tb_usuario_projeto (pro_codigo, usu_codigo_integrante,
                                            usu_codigo_criador, usp_data_criacao)
                        VALUES (?, ?, ?, ?)");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados[$this->pro_codigo],\PDO::PARAM_INT);
            $stmt->bindParam(2,$dados[$this->usu_codigo_integrante],\PDO::PARAM_INT);
            $stmt->bindParam(3,$dados[$this->usu_codigo_criador],\PDO::PARAM_INT);
            $stmt->bindParam(4,$dados[$this->usp_data_criacao],\PDO::PARAM_STR);

            $stmt->execute();

            return $stmt;

        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }

    public function findByProjeto($pro_codigo)
    {
        $query = ("SELECT usp_codigo,
                        (SELECT concat(usu_nome,' ',usu_sobrenome)
                            FROM tb_usuario
                            WHERE usu_codigo = usu_codigo_integrante)
                    AS 'usu_codigo_integrante'
                    FROM tb_usuario_projeto
                    WHERE pro_codigo = ?
                    ORDER BY 2;");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$pro_codigo,\PDO::PARAM_INT);
            $stmt->execute();

            return $stmt;

        }catch (\PDOException $e){

        }

    }

    public function getForm($usp_codigo)
    {
        $query  = ("SELECT usp_codigo, pro_codigo, usu_codigo_integrante,
                           usu_codigo_criador, usp_data_criacao
                    FROM tb_usuario_projeto
                    WHERE usp_codigo = ?");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$usp_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);


        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function update($dados)
    {
        $query = ("UPDATE tb_usuario_projeto
                    SET usu_codigo_integrante = ?
                    WHERE usp_codigo = ?");

        try {

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1, $dados[$this->usu_codigo_integrante], \PDO::PARAM_INT);
            $stmt->bindParam(2, $dados[$this->usp_codigo], \PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;

        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(). $e->getCode());
        }
    }

    public function delete($dados)
    {
        $query = ("DELETE FROM tb_usuario_projeto
                    WHERE usp_codigo = ?");

        try {

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1, $dados[$this->usp_codigo], \PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;

        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(). $e->getCode());
        }
    }


    public function findProjetoByUsers($usu_codigo)
    {
        $query = ("SELECT USU_PRO.pro_codigo, PRO.dep_codigo
                    FROM tb_usuario_projeto AS USU_PRO
                    INNER JOIN tb_projeto AS PRO
                    ON USU_PRO.pro_codigo = PRO.pro_codigo
                    WHERE usu_codigo_integrante = ?
                    AND PRO.stp_codigo = 2
                    ORDER BY 2,1;");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$usu_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);

        }catch (\PDOException $e){

        }

    }

    //Conta quanto projetos em andamento existem por usuario participante
    public function countProjectByUser($usu_codigo)
    {
        $query = ("SELECT count(pro.pro_codigo)
                    FROM tb_usuario_projeto AS usu_pro
                    INNER JOIN tb_projeto AS pro
                    ON usu_pro.pro_codigo = pro.pro_codigo
                    WHERE usu_codigo_integrante = ?
                    AND pro.stp_codigo = 2;
");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$usu_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            $dados = $stmt->fetch(\PDO::FETCH_NUM);

            return $dados['0'];

        }catch (\PDOException $e){

        }

    }

    public function getUserProjetoValidade($dados)
    {
        $query = ("SELECT count(*)
                    FROM tb_usuario_projeto
                    WHERE pro_codigo = ?
                    AND usu_codigo_integrante = ?;
                  ");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados['pro_codigo'],\PDO::PARAM_INT);
            $stmt->bindParam(2,$dados['usu_codigo_integrante'],\PDO::PARAM_INT);

            $stmt->execute();

            $dados = $stmt->fetch(\PDO::FETCH_NUM);

            return $dados['0'];

        }catch (\PDOException $e){

        }
    }

}
?>