<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

class Migrate extends Banco
{

    public function listarAtividades($pro_codigo)
    {
        $query = "SELECT at_codigo, pro_codigo, at_titulo
                    FROM tb_atividade
                    WHERE pro_codigo = ?
                    ORDER BY at_codigo";

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$pro_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);

        }catch (\PDOException $e){
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function listProjeto()
    {
        $query = ("SELECT pro_codigo
                    FROM tb_projeto
                    ORDER BY 1");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);

        }catch (\PDOException $e){
            new PDOException($e->getMessage());
        }
    }

    public function updateAtividade($dados)
    {
        $query = "UPDATE tb_atividade
                    SET at_titulo = ?
                    WHERE at_codigo = ?";

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados['at_titulo']);
            $stmt->bindParam(2,$dados['at_codigo']);

            $stmt->execute();

            return $stmt;

        }catch (\PDOException $e){
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

}


$obj = new Migrate();


echo 'Processando...<br><br>';

foreach($obj->listProjeto() as $projeto){

    $x = 1;

    foreach($obj->listarAtividades($projeto['pro_codigo']) as $valor){

        $dados['at_titulo'] = $projeto['pro_codigo']-1 .'-'.$x;
        $dados['at_codigo'] = $valor['at_codigo'];

        $obj->updateAtividade($dados);

        $x++;

    }


}


echo 'Finalizado !';

?>