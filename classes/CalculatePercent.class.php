<?php
/**
 * @author M�rcio Ramos e-mail: marciomrs4@hotmail.com
 * @name Calcudo de Porcentagem entre datas
 * @example Essa classe � utilizada para criar percentagem entre datas
 * @package script
 * @version 1.0 Data 20/04/2011
 * 
 */
class CalculatePercent
{	


	private $dataInicial;
	private $dataFinal;
	private $dataAtual;
	private $percentual;


	public function __construct($dataInicial, $dataFinal, $dataAtual = null)
	{
		$this->dataInicial = $dataInicial;
		$this->dataFinal = $dataFinal;
		$this->dataAtual = $dataAtual;
	}


	private function calculatePercent()
	{
		$dataInicio = new DateTime($this->dataInicial);

		$dataFinal = new DateTime($this->dataFinal);

		if($this->dataAtual == null){
			$dataAtual = new DateTime('now');
		}else{
			$dataAtual = new DateTime($this->dataAtual);
		}



		$totalDias =  $dataInicio->diff($dataFinal)->days + 1;

		$totalDiaParcial = $dataInicio->diff($dataAtual)->days + 1;

		$valorPencentual = $totalDiaParcial / $totalDias;

		$this->percentual = sprintf('%.2f', $valorPencentual * 100);


	}

	public function getPercent()
	{
		$this->calculatePercent();

		return $this->percentual;
	}

	public function getColor()
	{
		$this->calculatePercent();

		$danger = 'danger';
		$warning = 'warning';
		$success = 'success';

		if($this->percentual <= 80){
			return $success;
		}elseif($this->percentual <= 99){
			return $warning;
		}else{
			return $danger;
		}

	}


}

?>