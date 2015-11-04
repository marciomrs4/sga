<?php

class TbRncEficaz extends Banco {

    private $tabela = 'tb_rnc_eficaz';
    private $efi_codigo = 'efi_codigo';
    private $efi_descricao = 'efi_descricao';

    public function getDescricao() {
        $query = ("SELECT $this->efi_codigo,$this->efi_descricao
    				FROM $this->tabela    				
    			  ");

        try {
            $stmt = $this->conexao->prepare($query);

            $stmt->execute();

            return($stmt->fetch());
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getMessage());
        }
    }

    public function listRncEficaz() 
    {
        $query = ("SELECT $this->efi_codigo,$this->efi_descricao
    				FROM $this->tabela    				
    			  ");

        try {
            $stmt = $this->conexao->prepare($query);

            $stmt->execute();

            return $stmt;
            
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getMessage());
        }
    }

}
