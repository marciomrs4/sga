<?php

class TbPerfil extends Banco
{

    public function insert($dados){}

    public function update($dados){}

   /* public function select()
    {
        $query = ("SELECT soc_codigo, soc_descricao
                    FROM tb_tipo_solicitacao_acesso");

        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            return $stmt;

        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }*/

    public function selectByServico($ser_codigo)
    {
        $query = ("SELECT per_codigo, per_descricao
                    FROM tb_perfil
                    WHERE ser_codigo = ?");

        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1,$ser_codigo,\PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;

        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }

    public function getDescricaoPerfil($per_codigo)
    {
        $query = ("SELECT per_descricao
                    FROM tb_perfil
                   WHERE per_codigo = ?");

        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1,$per_codigo,\PDO::PARAM_INT);
            $stmt->execute();
            $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $dados['per_descricao'];

        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }

    public function getForm($codigo){}


}
?>