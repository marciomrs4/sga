<?php
/**
 * @author M?rcio Ramos e-mail: marciomrs4@hotmail.com
 * @name Titulo
 * @example Essa classe ? utilizada para criar titulo j? formatado
 * @package script
 * @version 1.0 Data 20/04/2011
 * 
 */
final class Erro
{	

	public static function verificarErro($erro)
	{
		return self::encontrarErro($erro);
	}
	
	
	private static function encontrarErro($erro)
	{
		#String de Entrada
		$haystack = $erro;

		#String procurada
		$needle = "UNIQUE";

		if(strpos($haystack, $needle) != '')
		{
			return(Texto::erro('Já existe esse '.$_SESSION['config']['usuario'].' cadastrado'));
		}else {
			return $erro;
		}
		
		
	}


	public static function validarChamadoInRnc($erro)
	{
		#String de Entrada
		$haystack = $erro;

		#String procurada
		$needle = "campo_unique";

		if(strpos($haystack, $needle) != '')
		{
			return(Texto::erro('Esse chamado já foi adcionado a uma RNC.'));
		}else {
			return $erro;
		}


	}



}

?>