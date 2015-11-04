<?php

class TbCadastroRnc extends Banco
{
    private $tabela = 'tb_rnc';
    
    private $nc_codigo = 'nc_codigo';
    private $nc_codigo_pro = 'nc_codigo_pro';
    private $nc_lote = 'nc_lote';
    private $nc_oc = 'nc_oc';
    private $nc_descricao = 'nc_descricao';
    private $nc_quantidade = 'nc_quantidade';
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
    private $nc_data_implantacao = 'nc_data_implantacao';

    public function insert($dados)
    {
        $query = ("INSERT INTO $this->tabela ($this->nc_codigo,$this->nc_codigo_pro,$this->nc_lote,$this->nc_oc,
                               $this->nc_descricao, $this->nc_quantidade,$this->nc_descricaocompleta,$this->nc_local_ocorrencia,$this->nc_data_ocorrencia,
                               $this->usu_emitente_codigo,$this->dep_responsavel_codigo,$this->nc_acao_imediata)
                  VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        try {
                  $stmt = $this->conexao->prepare($query);
                  
                  $stmt->bindParam(1,$dados[$this->nc_codigo],PDO::PARAM_INT);
                  $stmt->bindParam(2,$dados[$this->nc_codigo_pro],PDO::PARAM_STR);
                  $stmt->bindParam(3,$dados[$this->nc_lote],PDO::PARAM_STR);
                  $stmt->bindParam(4,$dados[$this->nc_oc],PDO::PARAM_INT);
                  $stmt->bindParam(5,$dados[$this->nc_descricao],PDO::PARAM_STR);
                  $stmt->bindParam(6,$dados[$this->nc_quantidade],PDO::PARAM_STR);
                  $stmt->bindParam(7,$dados[$this->nc_descricaocompleta],PDO::PARAM_STR);
                  $stmt->bindParam(8,$dados[$this->nc_local_ocorrencia],PDO::PARAM_STR);
                  $stmt->bindParam(9,$dados[$this->nc_data_ocorrencia],PDO::PARAM_STR);
                  $stmt->bindParam(10,$dados[$this->usu_emitente_codigo],PDO::PARAM_INT);
                  $stmt->bindParam(11,$dados[$this->dep_responsavel_codigo],PDO::PARAM_INT);
                  $stmt->bindParam(12,$dados[$this->nc_acao_imediata],PDO::PARAM_STR);
                  
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
                                    $this->nc_data_implantacao = ?
                                    WHERE $this->nc_codigo = ? ");
        try {
            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1, $dados[$this->nc_causas], PDO::PARAM_STR);
            $stmt->bindParam(2, $dados[$this->nc_acao_melhoria], PDO::PARAM_STR);
            $stmt->bindParam(3, $dados[$this->nc_prazo_implatacao], PDO::PARAM_STR);
            $stmt->bindParam(4, $dados[$this->nc_resp_implantacao], PDO::PARAM_STR);
            $stmt->bindParam(5, $dados[$this->nc_data_implantacao], PDO::PARAM_STR);
            $stmt->bindParam(6, $dados[$this->nc_codigo], PDO::PARAM_INT);
            
            $stmt->execute();

            return($stmt);
        } catch (PDOException $e) {
            throw new PDOException("Erro na tabela: " . get_class($this)."-". $e->getMessage(),$e->getCode());
        }
    }

    public function listTelaRnc()
    {
        $query = ("SELECT $this->nc_codigo, 
                          $this->nc_data_ocorrencia,
                          $this->nc_descricaocompleta,
                          $this->nc_local_ocorrencia                
                                FROM $this->tabela");
        
        try{
            
            $stmt = $this->conexao->prepare($query);
                    
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
    
}

