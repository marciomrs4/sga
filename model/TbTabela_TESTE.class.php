<?php

class TbTabela_TESTE extends Banco
{
	
	private $tabela = 'tb_prioridade';
	
	public function insertUsuario(Usuario $dados)
	{
		
		foreach ($dados as $dado)
		{
			echo $dado.'<br />';
		}
		
	}
	
	public function insert($dados)
	{
		foreach ($dados as $dado)
		{
			echo $dado;
		}
		
	}

	public function select()
	{
		
	}

	public function getForm($codigo_id_tabela){}
	
	public function update($dados){}

    public function listarSolicitacaoTerceiro()
    {
        $query = ("select sot_codigo, sol_codigo, sot_data_inclusao, sot_data_remocao, sot_tempo_util
                   from tb_solicitacao_terceiro
                   where sot_status = 'N';");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);

        }catch (\PDOException $e){
            throw new PDOException($e->getMessage(), $e->getCode());
        }

    }

    public function getHoraDepartamento($sol_codigo)
    {
        $query = ("select  DEP.dep_codigo, DEP.dep_descricao,
                    DEP.dep_hora_inicio,  DEP.dep_hora_fim, DEP.dep_hora_almoco, DEP.dep_carga_sabado
                    from tb_solicitacao AS SOL
                    inner join tb_departamento AS DEP
                    on SOL.dep_codigo_solicitado = DEP.dep_codigo
                    where SOL.sol_codigo = ?");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$sol_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);

        }catch (\PDOException $e){
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function updateEnvioTerceiro($sot_codigo, $tempo_util)
    {
        $query = ("UPDATE tb_solicitacao_terceiro
                    SET sot_tempo_util = ?
                    WHERE sot_codigo = ?");

        try{

            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(1,$tempo_util,\PDO::PARAM_STR);
            $stmt->bindParam(2,$sot_codigo,\PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;

        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }

}
?>