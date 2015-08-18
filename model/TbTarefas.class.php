<?php

class TbTarefas extends Banco
{

    public function insert($dados)
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

    }

    public function listarTarefas($dados)
    {

        $query = ("SELECT tar_codigo, tar_descricao, tar_data
                    FROM tb_tarefas
                    WHERE tar_data > ?
                    AND usu_codigo = ?
                    AND dep_codigo = ?
                    ORDER BY tar_codigo DESC");

        try
        {
            $dados['tar_data'] = date('Y-m-d 00:00:01');

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados['tar_data'],\PDO::PARAM_STR);
            $stmt->bindParam(2,$dados['usu_codigo'],\PDO::PARAM_INT);
            $stmt->bindParam(3,$dados['dep_codigo'],\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;

        }catch(\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function listarTarefasMaisUsadas($dados)
    {

        $query = ("SELECT count(tar_descricao), tar_descricao
                    FROM tb_tarefas
                    WHERE usu_codigo = ?
                    AND tar_data > ?
                    GROUP BY tar_descricao
                    ORDER BY 1 DESC
                    LIMIT 5;");

        try
        {
            $dados['tar_data'] = date('Y-m-d 00:00:01');

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados['usu_codigo'],\PDO::PARAM_INT);
            $stmt->bindParam(2,$dados['tar_data'],\PDO::PARAM_STR);

            $stmt->execute();

            return $stmt;

        }catch(\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }

}
?>