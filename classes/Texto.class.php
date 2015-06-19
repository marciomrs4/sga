<?php
/**
 * @author M�rcio Ramos e-mail: marciomrs4@hotmail.com
 * @name Titulo
 * @example Essa classe � utilizada para criar titulo j� formatado
 * @package script
 * @version 1.0 Data 20/04/2011
 * 
 */
final class Texto
{	

	
	/**
	 * @author M�rcio Ramos e-mail: marciomrs4@hotmail.com
	 * @name criaTitulo
	 * @package script
	 * @param titulo
	 */
	
	
	public static function criarTitulo($titulo)
	{	
		echo("<p class='titulo'> {$titulo} </p>");		
	}
	
	public static function criarSubTitulo($string)
	{
		echo("<p class='subtitulo'> {$string} </p><hr>");
	}

	public static function mostrarMensagem($msg)
	{

		$Mensagem = isset($msg) ? $msg : null;
		
		echo $Mensagem,'<br/>';
		
	}
		
	public static function letterRed($string)
	{
		return("<font color='red'>{$string}</font>");
	}

	public static function letterBlue($string)
	{
		return("<font color='blue'>{$string}</font>");
	}
	
	public static function erro($msg)
	{
		return("<span class='erro'> {$msg} </span>");
	}
	
	public static function sucesso($msg)
	{
		return("<p class='sucesso'> {$msg} </p>");
	}
	
	public static function InverterString($string)
	{
		return strrev($string);
	}
	
}

?>