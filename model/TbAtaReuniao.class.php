<?php

class TbAtaReuniao extends Banco
{

    private $tabela = 'tb_ata_reuniao';

    private $ata_codigo = 'ata_codigo';
    private $pro_codigo_projeto = 'pro_codigo_projeto';
    private $usu_codigo_criador = 'usu_codigo_criador';
    private $ata_data_criacao = 'ata_data_criacao';
    private $form_ata_reuniao = 'form_ata_reuniao';


    public function insert($dados)
    {
        $query = ("INSERT INTO $this->tabela
                  ($this->pro_codigo_projeto, $this->usu_codigo_criador,
                  $this->ata_data_criacao, $this->form_ata_reuniao)
                   VALUES(?, ?, ?, ?) ");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados[$this->pro_codigo_projeto],\PDO::PARAM_INT);
            $stmt->bindParam(2,$dados[$this->usu_codigo_criador],\PDO::PARAM_INT);
            $stmt->bindParam(3,$dados[$this->ata_data_criacao],\PDO::PARAM_STR);
            $stmt->bindParam(4,$dados[$this->form_ata_reuniao],\PDO::PARAM_LOB);

            $stmt->execute();

            return $stmt;

        }catch (\PDOException $e){
            throw new PDOException($e->getMessage(), $e->getCode());
        }

    }


    public function update($dados)
    {
        $query = ("UPDATE $this->tabela
                    SET $this->form_ata_reuniao = ?
                    WHERE $this->ata_codigo = ?");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados[$this->form_ata_reuniao],\PDO::PARAM_LOB);
            $stmt->bindParam(2,$dados[$this->ata_codigo],\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;

        }catch (\PDOException $e){
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function getForm($ata_codigo)
    {
        $query = ("SELECT ata_codigo, pro_codigo_projeto, usu_codigo_criador,
		                  ata_data_criacao, form_ata_reuniao
                    FROM tb_ata_reuniao
                    WHERE ata_codigo = ?;");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$ata_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);

        }catch (\PDOException $e){
            throw new PDOException($e->getMessage(), $e->getCode());
        }

    }


    public function listarPauta($pro_codigo)
    {
        $query = ("SELECT ata_codigo,
                            (SELECT concat( usu_nome,' ',usu_sobrenome)
                                FROM tb_usuario
                                WHERE usu_codigo = usu_codigo_criador) AS usu_codigo_criador,
                            date_format(ata_data_criacao,'%d/%m/%Y') AS ata_data_criacao,
                            form_ata_reuniao
                    FROM tb_ata_reuniao
                    WHERE pro_codigo_projeto = ?;");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$pro_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;

        }catch (\PDOException $e){
            throw new PDOException($e->getMessage(), $e->getCode());
        }

    }


}