<?php

class TbServico extends Banco
{

    public function insert($dados){}

    public function update($dados){}

    public function select()
    {
        $query = ("SELECT ser_codigo, ser_descricao
                    FROM tb_servico
                   ORDER BY ser_descricao");

        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            return $stmt;

        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }

    public function getDescricaoServico($ser_codigo)
    {
        $query = ("SELECT ser_descricao
                    FROM tb_servico
                   WHERE ser_codigo = ?");

        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1,$ser_codigo,\PDO::PARAM_INT);
            $stmt->execute();
            $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $dados['ser_descricao'];

        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }

    public function getForm($codigo){}



}
?>