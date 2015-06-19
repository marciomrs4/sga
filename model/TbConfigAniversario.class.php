<?php

class TbConfigAniversario extends Banco
{

	public static function listarMeses()
	{
		return array(1 => array(1,'Janeiro'),
					 2 => array(2,'Fevereiro'),
					 3 => array(3,'Março'),
					 4 => array(4,'Abril'),
					 5 => array(5,'Maio'),
					 6 => array(6,'Junho'),
					 7 => array(7,'Julho'),
					 8 => array(8,'Agosto'),
					 9 => array(9,'Setembro'),
					 10 => array(10,'Outubro'),
					 11 => array(11,'Novembro'),
					 12 => array(12,'Dezembro')
					 );
	}

	public static function listarUnidade()
	{
		return array(1 => array(1,'CEADIS'),
					 2 => array(2,'UDTP')
					);
		
	}

	public static function listarDias()
	{
		
		for($x = 1; $x <= 31; $x++)
		{
			$array[] = array($x,$x);
		}
		
		return($array);
	}
	
	public static function checkMes($mes)
	{
		
		switch ($mes)
		{
			case 1:
				return('Janeiro');
			break;			

			case 2:
				return('Fevereiro');
			break;
			
			case 3:
				return('Março');
			break;

			case 4:
				return('Abril');
			break;
			
			case 5:
				return('Maio');
			break;

			case 6:
				return('Junho');
			break;
			
			case 7:
				return('Julho');
			break;
			
			case 8:
				return('Agosto');
			break;
			
			case 9:
				return('Setembro');
			break;
			
			case 10:
				return('Outubro');
			break;
			
			case 11:
				return('Novembro');
			break;
			
			case 12:
				return('Dezembro');
			break;
			
			Default:
				return('Não Encontrado');
			break;
		}
	}
	
}
?>