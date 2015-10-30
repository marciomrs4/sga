<?php

class TbApontamentoProjeto extends Banco
{

    private $tabela = 'tb_apontamento_projeto';
    private $ap_codigo = 'ap_codigo';
    private $ap_descricao = 'ap_descricao';
    private $ap_data_criacao = 'ap_data_criacao';
    private $pro_codigo = 'pro_codigo';
    private $usu_codigo = 'usu_codigo';


    public function insert($dados)
    {

        $query = ("INSERT INTO $this->tabela
					($this->ap_descricao, $this->pro_codigo, $this->usu_codigo)
                    VALUE(?, ?, ?)");

        try
        {
            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados[$this->ap_descricao],PDO::PARAM_STR);
            $stmt->bindParam(2,$dados[$this->pro_codigo],PDO::PARAM_INT);
            $stmt->bindParam(3,$dados[$this->usu_codigo],PDO::PARAM_INT);

            $stmt->execute();

            $this->ap_codigo = $this->conexao->lastInsertId();

            return($this->ap_codigo);


        } catch (Exception $e)
        {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }


    public function listarApontamento($pro_codigo)
    {

        $query = ("SELECT ap_descricao,
                        date_format(ap_data_criacao, '%d/%m/%Y %H:%i:%s') AS ap_data_criacao,
                        (SELECT concat(usu_nome,' ', usu_sobrenome)
                            FROM tb_usuario WHERE APO.usu_codigo = usu_codigo) AS usu_nome
                    FROM tb_apontamento_projeto AS APO
                    WHERE pro_codigo = ?;
                    ");

        try
        {
            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$pro_codigo,PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;


        } catch (Exception $e)
        {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }




    public function update($dados)
    {}

}

?>