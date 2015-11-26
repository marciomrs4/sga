<?php

class TbRncVerificacao extends Banco
{

    private $tabela = 'tb_rnc_verificacao';
    private $ver_codigo = 'ver_codigo';
    private $nc_codigo = 'nc_codigo';
    private $efi_codigo_eficaz = 'efi_codigo_eficaz';
    private $ver_data_resposta = 'ver_data_resposta';
    private $ver_encerrado = 'ver_encerrado';
    private $ver_parecer_qualidade = 'ver_parecer_qualidade';
    private $usu_codigo_criador = 'usu_codigo_criador';

    public function insert($dados)
    {
        $query = ("INSERT INTO
                      tb_rnc_verificacao (nc_codigo, efi_codigo_eficaz, ver_data_resposta,
                                          ver_encerrado, ver_parecer_qualidade, usu_codigo_criador)
                      VALUES (?, ?, ?, ?, ?, ?)");
        try {
            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados['nc_codigo'],\PDO::PARAM_INT);
            $stmt->bindParam(2,$dados['efi_codigo_eficaz'],\PDO::PARAM_INT);
            $stmt->bindParam(3,$dados['ver_data_resposta'],\PDO::PARAM_STR);
            $stmt->bindParam(4,$dados['ver_encerrado'],\PDO::PARAM_STR);
            $stmt->bindParam(5,$dados['ver_parecer_qualidade'],\PDO::PARAM_STR);
            $stmt->bindParam(6,$dados['usu_codigo_criador'],\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;

        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }


    public function getUltimaRncVerificacao($nc_codigo)
    {
        $query = ("SELECT ver_codigo, nc_codigo,
                            (SELECT efi_descricao
                                FROM  tb_rnc_eficaz
                                WHERE efi_codigo = efi_codigo_eficaz ) AS efi_descricao,
                            date_format(ver_data_resposta,'%d-%m-%Y %H:%i:%s') AS ver_data_resposta,
                            IF(ver_encerrado = 1,'SIM','NÃO') AS ver_encerrado,
                         ver_parecer_qualidade, usu_codigo_criador
                    FROM tb_rnc_verificacao
                    WHERE ver_codigo = (SELECT max(ver_codigo)
                                        FROM tb_rnc_verificacao
                                        WHERE nc_codigo = ?)");

        try {

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$nc_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);


        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }


    //Lista as verificacoes por RNC na tela de verificacao
    public function listarVerificaoByRnc($nc_codigo)
    {
        $query = ("SELECT ver_codigo,
                        (SELECT efi_descricao
                            FROM  tb_rnc_eficaz
                            WHERE efi_codigo = efi_codigo_eficaz ) AS efi_descricao,
                        date_format(ver_data_resposta,'%d-%m-%Y %H:%i:%s') AS ver_data_resposta,
                        IF(ver_encerrado = 1,'SIM','NÃO') AS ver_encerrado, ver_parecer_qualidade
                    FROM tb_rnc_verificacao
                    WHERE nc_codigo = ?;
                  ");

        try {

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$nc_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;//->fetchAll(\PDO::FETCH_ASSOC);


        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }


    //Verifica se existe verificacao criada para RNC
    public function countVerificacaoByRnc($nc_codigo)
    {
        $query = ("SELECT count(*) AS qtd
                    FROM tb_rnc_verificacao
                    WHERE nc_codigo = ?;
                  ");

        try {

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$nc_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $dados['qtd'];


        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }


}