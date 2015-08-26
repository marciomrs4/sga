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

		
}
?>