<?php

class TbOcorrenciaRnc extends Banco
{

    private $tabela = 'tb_ocorrencia_rnc';

    private $onc_codigo = 'onc_codigo';
    private $nc_codigo = 'nc_codigo';
    private $sol_codigo = 'sol_codigo';


    public function insert($dados)
    {
        $query = ("INSERT INTO tb_ocorrencia_rnc
                    (nc_codigo, sol_codigo)
                    VALUES(?, ?)");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados['nc_codigo'],\PDO::PARAM_INT);
            $stmt->bindParam(2,$dados['sol_codigo'],\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;

        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }


    public function validarOcorrencia($sol_codigo)
    {
        $query = ("SELECT count(*) AS ocorrencia
                    FROM tb_ocorrencia_rnc
                    WHERE sol_codigo = ?");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$sol_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $dados['ocorrencia'];

        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }

    //Lista o chamado add a rnc
    public function listarRncChamado($sol_codigo)
    {
        $query = ("SELECT onc_codigo,
                            concat(
                                    (SELECT concat(nc_codigo,'/',date_format(nc_data_criacao,'%y'))
                                        FROM tb_rnc WHERE RNC.nc_codigo = nc_codigo),' - ',
                                    (SELECT pro_descricao
                                        FROM tb_problema WHERE pro_codigo =
                                            (SELECT pro_codigo_tecnico_rnc
                                                FROM tb_rnc
                                                WHERE nc_codigo = RNC.nc_codigo ))) AS nc_codigo,
                                                sol_codigo
                                            FROM tb_ocorrencia_rnc AS RNC
                                            WHERE sol_codigo = ?");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$sol_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;


        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }

    //Lista o chamado add a rnc
    public function getFormOcorrenciaRnc($onc_codigo)
    {
        $query = ("SELECT onc_codigo, nc_codigo, sol_codigo
                    FROM tb_ocorrencia_rnc
                    WHERE onc_codigo = ?");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$onc_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);


        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }

    public function update($dados)
    {
        $query = ("UPDATE tb_ocorrencia_rnc
                    SET nc_codigo = ?,
                        sol_codigo = ?
                    WHERE onc_codigo = ?");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados['nc_codigo'],\PDO::PARAM_INT);
            $stmt->bindParam(2,$dados['sol_codigo'],\PDO::PARAM_INT);
            $stmt->bindParam(3,$dados['onc_codigo'],\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;

        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }

    //Lista de Chamado por RNC na tela de RNC
    public function listarChamadoByRnc($nc_codigo)
    {
        $query = ("SELECT sol_codigo
                    FROM tb_ocorrencia_rnc
                    WHERE nc_codigo = ?
                    ");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$nc_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;


        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }

}
