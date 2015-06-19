<?php
class ValidarDatas extends ClasseException
{

	private function setTimeZone()
	{
		date_default_timezone_set('America/Sao_Paulo');
	}

	public static function validarDataBrasil($data,$campo = null)
	{
		if(!preg_match("/^[0-9]{2}\-[0-9]{2}\-[0-9]{4}$/",$data))
		{
			throw new Exception("A data no campo {$campo} n�o � v�lida",300);
		}

	}

	public static function dataCliente($data,$separador="-")
	{
		if($data == '')
		{
			return;
		}else{
			if(stristr($data,"-"))
			{
				$data = explode('-',$data);
				$data = $data[2]."".$separador."".$data[1]."".$separador."".$data[0];
			}else
			{
				$data = explode('/',$data);
				$data = $data[2]."".$separador."".$data[1]."".$separador."".$data[0];
			}
			return($data);
		}
	}

	public static function dataBanco($data,$separador="-")
	{

		if($data == '')
		{
			return;
		}else{
			if(stristr($data,"-"))
			{
				$data = explode('-',$data);
				$data = $data[2]."".$separador."".$data[1]."".$separador."".$data[0];
			}else
			{
				$data = explode('/',$data);
				$data = $data[2]."".$separador."".$data[1]."".$separador."".$data[0];
			}
			return($data);
		}
	}

	/**
	 *
	 * Calcula um intervalo de datas
	 * @param string $data
	 * @param int $dias
	 * @example A data deve ser informada no padr�o
	 * 	DIA/MES/ANO
	 * @return string $data
	 * @tutorial Informe a data que deja calcular
	 * e a quantidade de dias que deseja ser calculado
	 * para dias j� passados deve ser inserido valor
	 * negativo. Para calcular uma data a frente (data
	 * futura) basta inserir um valor positivo.
	 */

	public static function dataAnterior($data,$dias)
	{
		self::setTimeZone();

		if(stristr($data,'-'))
		{
			$data = explode('-',$data);
		}
		elseif(stristr($data,'/'))
		{
			$data = explode('/',$data);
		}

		$dia = 86400 * $dias;

		$timestamp = mktime(0,0,0,$data[1],$data[0],$data[2]);

		$timestamp += $dia;

		return date('d-m-Y',$timestamp);
	}

	private static function calculaHora($hora)
	{

	}

	public static function validarAteDataAtual($data,$campo,$frase = null)
	{
		$frase = ($frase == null) ? 'Data inv�lida no campo: ' : frase;

		if(stristr($data,'/'))
		{
			$data = explode('/',$data);
		}else
		{
			$data = explode('-',$data);
		}

		$dataentrada = mktime(0,0,0,$data[1],$data[0],$data[2]);
		$datadodia = mktime(0,0,0,date('m'),date('d'),date('Y'));
			
		if($dataentrada > $datadodia)
		{
			throw new Exception($frase." ".$campo,300);
		}
	}

	public static function validarData($data,$nomecampo = null)
	{
		$data = explode('/',$data);

		if(!checkdate($data[1],$data[0],$data[2]))
		{
			throw new DataInvalidaException("Data inv�lida no campo {$nomecampo}.",300);
		}
	}

	public static function dataHoraAtual()
	{
		return(date('Y-m-d h:i:s'));
	}

	public static function getTimeStamp($data,$dias)
	{
		self::setTimeZone();

		if(stristr($data,'-'))
		{
			$data = explode('-',$data);
		}
		elseif(stristr($data,'/'))
		{
			$data = explode('/',$data);
		}

		$dia = 86400 * $dias;

		$timestamp = mktime(0,0,0,$data[1],$data[0],$data[2]);

		$timestamp += $dia;

		return($timestamp);
	}
	
}
?>