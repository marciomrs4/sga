<?php

class ValidarNumeros extends ClasseException
{

	public static function numeroCliente($numero)
	{
		return(number_format($numero,2,',','.'));
	}

	public static function numeroBanco($valor)
	{
		return
		(str_replace(
				array('.',','),
				array('','.'),
				$valor
					)
		);
	}

	public static function validaNumero($numero,$campo = null)
	{
		if(!is_numeric($numero))
		{
			throw new Exception("O valor do campo {$campo} não é um número válido",300);
		}

	}
	
	public static function validarValorMonetario($valor)
	{
		
		echo gettype($valor);		

		$valorcorreto = number_format($valor,2,',','.');

		if($valorcorreto != $valor)
		{
			throw new Exception('Valor incorreto',300);
		}
		
		echo $valorcorreto; //number_format($valor,2,'.','');				
	}

}