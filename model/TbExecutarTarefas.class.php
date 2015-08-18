<?php

class TbExecutarTarefas extends Banco
{

/*    public function insert($dados)
    {
        $query = ("INSERT INTO tb_tarefas
                    (tar_descricao,tar_data,
                     usu_codigo,dep_codigo)
                     VALUES(?, ?, ?, ?)");

        try
        {
            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados['tar_descricao'],\PDO::PARAM_STR);
            $stmt->bindParam(2,$dados['tar_data'],\PDO::PARAM_STR);
            $stmt->bindParam(3,$dados['usu_codigo'],\PDO::PARAM_INT);
            $stmt->bindParam(4,$dados['dep_codigo'],\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;

        }catch(\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }*/

    public function listarExecutarTarefas($dados)
    {

        $query = ("SELECT tae_descricao
                    FROM tb_tarefa_executar
                    WHERE dep_codigo = ?
                    ");

        try
        {

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados['dep_codigo'],\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;

        }catch(\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }

}
?>