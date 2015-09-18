<?php
class TbTipoSolicitacaoAcesso extends Banco
{
	
	public function insert($dados){}
	
	public function update($dados){}

	public function select()
    {
        $query = ("SELECT soc_codigo, soc_descricao
                    FROM tb_tipo_solicitacao_acesso");

        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            return $stmt;

        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }
	
	public function getForm($codigo){}

    public function getDescription($soc_codigo)
    {
        $query = ("SELECT soc_descricao
                    FROM tb_tipo_solicitacao_acesso
                    WHERE soc_codigo = ?");

        try {
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1,$soc_codigo,\PDO::PARAM_INT);
            $stmt->execute();
            $soc_descricao = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $soc_descricao['soc_descricao'];

        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

    }
		
}
?>