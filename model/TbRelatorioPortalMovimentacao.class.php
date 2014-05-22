<?php

class TbRelatorioPortalMovimentacao extends Banco_postgree
{
	

	public function getRelatorioMovimentacao($dados)
	{
		
		$query = ("SELECT a.artigoid,b.referencia,b.descricao,  to_char(long2timestamp(datadoeventoms),'DD-MM-YYYY'),
      					  to_char(long2timestamp(datadoeventoms),'HH:MM:SS'), a.quantidade, a.codigodaordem, a.lote  
				   FROM cead_fluxo_estoque a , cead_artigo b 
				   WHERE a.artigoid = b.codigo 
				   		AND a.tipodefluxo = 'ENTRADA' 
				   		AND long2timestamp(datadoeventoms) >= ?  
				   		AND long2timestamp(datadoeventoms) <= ?
				   ORDER BY  4, 6, 2");
		
		try {
			
			$date1 = $dados['data1'].' 00:00:01';
			$date2 = $dados['data2'].' 23:59:59';
			
			$stmt = $this->conexao->prepare($query);
			
			$stmt->execute(array($date1,$date2));
			
			return($stmt);
			
		} catch (PDOException $e) {
			
			throw new PDOException($e->getMessage(), $e->getCode());
		}
		
		
	}

	
	
}
?>