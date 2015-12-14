<?php

class TbCadastroRnc extends Banco
{

    private $tabela = 'tb_rnc';
    private $nc_codigo = 'nc_codigo';
    private $nc_descricaocompleta = 'nc_descricaocompleta';
    private $nc_local_ocorrencia = 'nc_local_ocorrencia';
    private $nc_data_ocorrencia = 'nc_data_ocorrencia';
    private $usu_emitente_codigo = 'usu_emitente_codigo';
    private $dep_responsavel_codigo = 'dep_responsavel_codigo';
    private $nc_acao_imediata = 'nc_acao_imediata';
    private $nc_causas = 'nc_causas';
    private $nc_acao_melhoria = 'nc_acao_melhoria';
    private $nc_prazo_implatacao = 'nc_prazo_implatacao';
    private $nc_resp_implantacao = 'nc_resp_implantacao';
    private $snc_codigo = 'snc_codigo';
    private $nc_data_criacao = 'nc_data_criacao';
    private $nc_data_resposta_gestor = 'nc_data_resposta_gestor';
    private $nc_edicao_gestor = 'nc_edicao_gestor';
    private $usu_codigo_criador = 'usu_codigo_criador';
    private $usu_codigo_repondedor = 'usu_codigo_repondedor';
    private $usu_codigo_verificador = 'usu_codigo_verificador';
    private $pro_codigo_tecnico_rnc = 'pro_codigo_tecnico_rnc';
    private $nc_previsao_encerramento = 'nc_previsao_encerramento';



    public function insert($dados)
    {
        $query = ("INSERT INTO $this->tabela ($this->nc_descricaocompleta,$this->nc_local_ocorrencia,
                               $this->nc_data_ocorrencia,$this->usu_emitente_codigo,$this->dep_responsavel_codigo,
                               $this->nc_acao_imediata, $this->usu_codigo_criador, $this->pro_codigo_tecnico_rnc)
                  VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
        
        try {
                  $stmt = $this->conexao->prepare($query);
                  
                  $stmt->bindParam(1,$dados[$this->nc_descricaocompleta],PDO::PARAM_STR);
                  $stmt->bindParam(2,$dados[$this->nc_local_ocorrencia],PDO::PARAM_STR);
                  $stmt->bindParam(3,$dados[$this->nc_data_ocorrencia],PDO::PARAM_STR);
                  $stmt->bindParam(4,$dados[$this->usu_emitente_codigo],PDO::PARAM_INT);
                  $stmt->bindParam(5,$dados[$this->dep_responsavel_codigo],PDO::PARAM_INT);
                  $stmt->bindParam(6,$dados[$this->nc_acao_imediata],PDO::PARAM_STR);
                  $stmt->bindParam(7,$dados[$this->usu_codigo_criador],PDO::PARAM_STR);
                  $stmt->bindParam(8,$dados[$this->pro_codigo_tecnico_rnc],PDO::PARAM_INT);

                  $stmt->execute();
                  
                  return ($this->conexao->lastInsertId());
                  
        } catch (PDOException $e)
        {
            throw new PDOException("Erro na tabela: " . get_class($this)."-". $e->getMessage(),$e->getCode());
        }
    }
    
    
    public function update($dados)
    {
        $query = ("UPDATE $this->tabela
                                SET $this->nc_causas = ?,
                                    $this->nc_acao_melhoria = ?,
                                    $this->nc_prazo_implatacao = ?,
                                    $this->nc_resp_implantacao = ?,    
                                    $this->nc_data_resposta_gestor = ?,
                                    $this->nc_edicao_gestor = ?,
                                    $this->snc_codigo = ?,
                                    $this->usu_codigo_repondedor = ?
                                WHERE $this->nc_codigo = ? ");
        try {
            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados[$this->nc_causas], PDO::PARAM_STR);
            $stmt->bindParam(2,$dados[$this->nc_acao_melhoria], PDO::PARAM_STR);
            $stmt->bindParam(3,$dados[$this->nc_prazo_implatacao], PDO::PARAM_STR);
            $stmt->bindParam(4,$dados[$this->nc_resp_implantacao], PDO::PARAM_STR);
            $stmt->bindParam(5,$dados[$this->nc_data_resposta_gestor], PDO::PARAM_STR);
            $stmt->bindParam(6,$dados[$this->nc_edicao_gestor],PDO::PARAM_INT);
            $stmt->bindParam(7,$dados[$this->snc_codigo],PDO::PARAM_INT);
            $stmt->bindParam(8,$dados[$this->usu_codigo_repondedor], PDO::PARAM_INT);
            $stmt->bindParam(9,$dados[$this->nc_codigo], PDO::PARAM_INT);
            
            $stmt->execute();

            return($stmt);

        } catch (\PDOException $e) {
            throw new \PDOException("Erro na tabela: " . get_class($this)."-". $e->getMessage(),$e->getCode());
        }

    }

    public function listTelaRnc($dados)
    {
        $query = ("SELECT nc_codigo, date_format(nc_data_ocorrencia,'%d-%m-%Y') AS nc_data_ocorrencia, nc_descricaocompleta, 
                          nc_local_ocorrencia,DEP.dep_descricao
                          FROM tb_rnc AS RNC
                          INNER JOIN tb_departamento AS DEP
                          ON RNC.dep_responsavel_codigo = DEP.dep_codigo
                          WHERE DEP.dep_codigo = ?

                          ORDER BY nc_codigo DESC");
        
        try{
            
            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados['dep_codigo_teste'],\PDO::PARAM_INT);
                    
            $stmt->execute();
            
            return $stmt;
            
        }  catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }
    
     public function getFormRnc($nc_codigo)
    {
        $query = ("SELECT * FROM $this->tabela
                   WHERE nc_codigo = ?");
        
        try{
            
            $stmt = $this->conexao->prepare($query);
            
            $stmt->bindParam(1,$nc_codigo,\PDO::PARAM_INT);
            
            $stmt->execute();
            
            return $stmt->fetch(\PDO::FETCH_ASSOC);;
            
        }  catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }


    public function getStatus($nc_codigo)
    {
        $query = ("SELECT snc_codigo FROM $this->tabela
                   WHERE nc_codigo = ?");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$nc_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $dados['snc_codigo'];

        }  catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }

    //Usado na tela de listagem de RNC para a Area/Gestor
    public function listarRncGestor($dados)
    {
        $query = ("SELECT nc_codigo, concat(nc_codigo,'/',date_format(nc_data_criacao,'%y')) AS numero, date_format(nc_data_ocorrencia,'%d-%m-%Y') AS nc_data_ocorrencia, nc_descricaocompleta,
                          nc_local_ocorrencia, DEP.dep_descricao, date_format(nc_data_criacao,'%d-%m-%Y') AS nc_data_criacao,
                          (SELECT snc_descricao
                			FROM tb_status_rnc
			                WHERE RNC.snc_codigo = snc_codigo) AS snc_descricao
                    FROM tb_rnc AS RNC
                    INNER JOIN tb_departamento AS DEP
                    ON RNC.dep_responsavel_codigo = DEP.dep_codigo
                    WHERE DEP.dep_codigo = ?
                    AND nc_data_criacao >= ?
                    AND nc_data_criacao <= ?
                    AND snc_codigo LIKE ?
                    AND nc_descricaocompleta LIKE ?
                    ORDER BY nc_codigo DESC");

        try{

            $data1 = $dados['data1'].' 00:00:01';
            $data2 = $dados['data2'].' 23:59:59';

            $stmt = $this->conexao->prepare($query);

            $stmt->execute(array("{$dados['dep_responsavel_codigo']}",
                                 "{$data1}",
                                 "{$data2}",
                                 "{$dados['sta_codigo_rnc']}",
                                 "%{$dados['nc_descricaocompleta']}%"
                                )
                            );

            return $stmt;

        }  catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }


    //Usado na tela de listagem de RNC para a Qualidade por data de verificacao
    public function listarRncQualidadeVerificacao($dados)
    {
        $query = ("SELECT nc_codigo, concat(nc_codigo,'/',date_format(nc_data_criacao,'%y')) AS numero, date_format(nc_data_ocorrencia,'%d-%m-%Y') AS nc_data_ocorrencia,
                          nc_descricaocompleta, (SELECT pro_descricao FROM tb_problema WHERE pro_codigo =  pro_codigo_tecnico_rnc) AS pro_codigo_tecnico_rnc,
                          nc_local_ocorrencia, DEP.dep_descricao, date_format(nc_data_criacao,'%d-%m-%Y') AS nc_data_criacao,
                          (SELECT snc_descricao
                			FROM tb_status_rnc
			                WHERE RNC.snc_codigo = snc_codigo) AS snc_descricao,
			                date_format(nc_previsao_encerramento,'%d-%m-%Y') AS nc_previsao_encerramento
                    FROM tb_rnc AS RNC
                    INNER JOIN tb_departamento AS DEP
                    ON RNC.dep_responsavel_codigo = DEP.dep_codigo
                    WHERE DEP.dep_codigo LIKE ?
                    AND nc_previsao_encerramento >= ?
                    AND nc_previsao_encerramento <= ?
                    AND snc_codigo LIKE ?
                    AND nc_descricaocompleta LIKE ?
                    ORDER BY nc_codigo DESC");

        try{

            $data1 = $dados['data1'].' 00:00:01';
            $data2 = $dados['data2'].' 23:59:59';

            $stmt = $this->conexao->prepare($query);

            $stmt->execute(array("{$dados['dep_responsavel_codigo']}",
                    "{$data1}",
                    "{$data2}",
                    "{$dados['sta_codigo_rnc']}",
                    "%{$dados['nc_descricaocompleta']}%"
                )
            );

            return $stmt;

        }  catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }

    //Usado na tela de listagem de RNC para a Qualidade por data de Abertura
    public function listarRncQualidadeAbertura($dados)
    {
        $query = ("SELECT nc_codigo, concat(nc_codigo,'/',date_format(nc_data_criacao,'%y')) AS numero, date_format(nc_data_ocorrencia,'%d-%m-%Y') AS nc_data_ocorrencia,
                          nc_descricaocompleta, (SELECT pro_descricao FROM tb_problema WHERE pro_codigo =  pro_codigo_tecnico_rnc) AS pro_codigo_tecnico_rnc,
                          nc_local_ocorrencia, DEP.dep_descricao, date_format(nc_data_criacao,'%d-%m-%Y') AS nc_data_criacao,
                          (SELECT snc_descricao
                			FROM tb_status_rnc
			                WHERE RNC.snc_codigo = snc_codigo) AS snc_descricao,
			                date_format(nc_previsao_encerramento,'%d-%m-%Y') AS nc_previsao_encerramento
                    FROM tb_rnc AS RNC
                    INNER JOIN tb_departamento AS DEP
                    ON RNC.dep_responsavel_codigo = DEP.dep_codigo
                    WHERE DEP.dep_codigo LIKE ?
                    AND nc_data_criacao >= ?
                    AND nc_data_criacao <= ?
                    AND snc_codigo LIKE ?
                    AND nc_descricaocompleta LIKE ?
                    ORDER BY nc_codigo DESC");

        try{

            $data1 = $dados['data1'].' 00:00:01';
            $data2 = $dados['data2'].' 23:59:59';

            $stmt = $this->conexao->prepare($query);

            $stmt->execute(array("{$dados['dep_responsavel_codigo']}",
                    "{$data1}",
                    "{$data2}",
                    "{$dados['sta_codigo_rnc']}",
                    "%{$dados['nc_descricaocompleta']}%"
                )
            );

            return $stmt;

        }  catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }


    //Atualiza informacao na verificacao
    public function updateVerificacao($dados)
    {
        $query = ("UPDATE $this->tabela
                   SET $this->snc_codigo = ?,
                       $this->nc_previsao_encerramento = ?
                   WHERE $this->nc_codigo = ? ");
        try {
            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados[$this->snc_codigo], PDO::PARAM_INT);
            $stmt->bindParam(2,$dados[$this->nc_previsao_encerramento], PDO::PARAM_STR);
            $stmt->bindParam(3,$dados[$this->nc_codigo], PDO::PARAM_INT);

            $stmt->execute();

            return($stmt);

        } catch (\PDOException $e) {
            throw new \PDOException("Erro na tabela: " . get_class($this)."-". $e->getMessage(),$e->getCode());
        }

    }


    //Libera edicao da RNC para o Gestor
    public function updateRespostaGestor($dados)
    {
        $query = ("UPDATE $this->tabela
                   SET $this->nc_edicao_gestor = ?
                   WHERE $this->nc_codigo = ? ");
        try {
            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$dados[$this->nc_edicao_gestor], PDO::PARAM_STR);
            $stmt->bindParam(2,$dados[$this->nc_codigo], PDO::PARAM_INT);

            $stmt->execute();

            return($stmt);

        } catch (\PDOException $e) {
            throw new \PDOException("Erro na tabela: " . get_class($this)."-". $e->getMessage(),$e->getCode());
        }

    }


    //Usado na tela de associar um chamado a uma RNC
    public function listarRncNaoFechadas()
    {
        $query = ("SELECT nc_codigo,
                          concat(concat(nc_codigo,'/',date_format(nc_data_criacao,'%y')),' - ',
							(SELECT pro_descricao FROM tb_problema WHERE pro_codigo = pro_codigo_tecnico_rnc)) AS titulo
                    FROM tb_rnc
                    WHERE snc_codigo < 4
                    ORDER BY 1 DESC;
                 ");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->execute();

            return $stmt;

        }  catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }


    //Usado na tela de associar um chamado a uma RNC
    public function getNumberRncFormatado($nc_codigo)
    {
        $query = ("SELECT concat(nc_codigo,'/',date_format(nc_data_criacao,'%y')) AS numero
                    FROM tb_rnc
                    WHERE nc_codigo = ?");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$nc_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $dados['numero'];

        }  catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }

    //Usado na tela de relatorio da QUalidade Graficos de RNC
    public function getGraficoRncByDepartamento($dados)
    {
        $query = ("SELECT (SELECT dep_descricao
                                FROM tb_departamento
                                WHERE dep_codigo = dep_responsavel_codigo) AS departamento,
                           COUNT(*) AS qtd
                    FROM tb_rnc
                    WHERE nc_data_criacao >= ?
                    AND nc_data_criacao <= ?
                    GROUP BY 1
                    ORDER BY 1;");

        try{

            $stmt = $this->conexao->prepare($query);

            $data1 = $dados['data1'].' 00:00:01';
            $data2 = $dados['data2'].' 23:59:59';

            $stmt->bindParam(1,$data1,\PDO::PARAM_STR);
            $stmt->bindParam(2,$data2,\PDO::PARAM_STR);

            $stmt->execute();

            foreach ($stmt as $value){
                echo '[',"'",$value[0],"'",',',$value[1],'],';
            }

        }  catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }


    //Usado na tela de relatorio da QUalidade Graficos de RNC
    public function getGraficoRncByTipoOcorrencia($dados)
    {
        $query = ("SELECT (SELECT pro_descricao
                                FROM tb_problema
                                WHERE pro_codigo = pro_codigo_tecnico_rnc) AS problema,
                           count(*) AS qtd
                    FROM tb_rnc
                    WHERE nc_data_criacao >= ?
                    AND nc_data_criacao <= ?
                    GROUP BY 1
                    ORDER BY 1;");

        try{

            $stmt = $this->conexao->prepare($query);

            $data1 = $dados['data1'].' 00:00:01';
            $data2 = $dados['data2'].' 23:59:59';

            $stmt->bindParam(1,$data1,\PDO::PARAM_STR);
            $stmt->bindParam(2,$data2,\PDO::PARAM_STR);

            $stmt->execute();

            foreach ($stmt as $value){
                echo '[',"'",$value[0],"'",',',$value[1],'],';
            }

        }  catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }


    //Usado no script de envio de email para qualidade fazer as verificacoes
    public function listRncToVerificacao()
    {
        $query = ("SELECT nc_codigo,
                        concat(nc_codigo,'/',date_format(nc_data_criacao,'%y')) AS numero_rnc,
                        (SELECT snc_descricao FROM tb_status_rnc WHERE RNC.snc_codigo = snc_codigo) AS snc_codigo,
                        (SELECT pro_descricao FROM tb_problema WHERE pro_codigo =  pro_codigo_tecnico_rnc) AS pro_codigo_tecnico_rnc,
                        date_format(nc_previsao_encerramento,'%d-%m-%Y') AS nc_previsao_encerramento
                        FROM tb_rnc AS RNC
                        WHERE nc_previsao_encerramento <= curdate()
                        AND snc_codigo = 1;");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->execute();

            return $stmt;

        }  catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }

}

