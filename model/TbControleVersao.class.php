<?php
class TbControleVersao extends Banco
{
    private $tabela = 'tb_controle_versao';
    private $vso_codigo = 'vso_codigo';
    private $sis_codigo = 'sis_codigo';
    private $vso_versao = 'vso_versao';
    private $vso_data = 'vso_data';
    private $vso_aprovador = 'vso_aprovador';
    private $vso_novas_instalacoes = 'vso_novas_instalacoes';
    private $vso_obs = 'vso_obs';
    private $usu_codigo = 'usu_codigo';

    public function insert($dados)
    {
        $query = ("INSERT INTO $this->tabela ($this->sis_codigo, $this->vso_versao, $this->vso_data,
											  $this->vso_aprovador,$this->vso_novas_instalacoes,
											  $this->vso_obs, $this->usu_codigo)
				   VALUES(?, ?, ?, ?, ?, ?, ?)");

        try {
            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados[$this->sis_codigo],PDO::PARAM_INT);
            $stmt->bindParam(2,$dados[$this->vso_versao],PDO::PARAM_STR);
            $stmt->bindParam(3,$dados[$this->vso_data],PDO::PARAM_STR);
            $stmt->bindParam(4,$dados[$this->vso_aprovador],PDO::PARAM_STR);
            $stmt->bindParam(5,$dados[$this->vso_novas_instalacoes],PDO::PARAM_STR);
            $stmt->bindParam(6,$dados[$this->vso_obs],PDO::PARAM_STR);
            $stmt->bindParam(7,$dados[$this->usu_codigo],PDO::PARAM_INT);

            $stmt->execute();

            return ($this->conexao->lastInsertId());

        }catch (PDOException $e)
        {
            throw new PDOException("Erro na tabela: " . get_class($this)."-". $e->getMessage(),$e->getCode());
        }
    }

    //Listagem da tela de versões
    public function listarVersoes($dados)
    {
        $query = ("SELECT vso_codigo, SIS.sis_descricao, vso_versao, date_format(vso_data, '%d-%m-%Y') AS vso_data, vso_aprovador
	   						FROM tb_controle_versao AS VERSAO
	   						INNER JOIN tb_sistemas AS SIS
	   						ON VERSAO.sis_codigo = SIS.sis_codigo
	   						WHERE SIS.sis_codigo LIKE ?
	   						AND vso_data >= ?
	   						AND vso_data <= ?");
        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->execute(array("{$dados['sis_codigo']}",
                    "{$dados['data1']}",
                    "{$dados['data2']}"
                )
            );

            return $stmt;

        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }

    #Alteração de versão
    public function update($dados)
    {
        $query = ("UPDATE $this->tabela
					SET $this->sis_codigo = ?,
						$this->vso_versao = ?,
						$this->vso_data = ?,
						$this->vso_aprovador = ?,
						$this->vso_novas_instalacoes = ?,
						$this->vso_obs = ?
					WHERE vso_codigo = ?");
        try
        {
            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados[$this->sis_codigo],PDO::PARAM_INT);
            $stmt->bindParam(2,$dados[$this->vso_versao],PDO::PARAM_STR);
            $stmt->bindParam(3,$dados[$this->vso_data],PDO::PARAM_STR);
            $stmt->bindParam(4,$dados[$this->vso_aprovador],PDO::PARAM_STR);
            $stmt->bindParam(5,$dados[$this->vso_novas_instalacoes],PDO::PARAM_STR);
            $stmt->bindParam(6,$dados[$this->vso_obs],PDO::PARAM_STR);
            $stmt->bindParam(7,$dados[$this->vso_codigo],PDO::PARAM_INT);

            $stmt->execute();

            return ($stmt);

        }catch (PDOException $e)
        {
            throw new PDOException("Erro na TbControleVersao".$e->getMessage(),$e->getCode());
        }
    }

    public function getFormVersao($vso_codigo)
    {
        $query = ("SELECT * FROM $this->tabela
						WHERE vso_codigo = ?");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$vso_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);;

        }  catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }
}
?>