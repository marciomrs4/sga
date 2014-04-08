<?php

class ValidarCampos extends ClasseException
{

	public static function compararCampos($campo1,$campo2,$nomecampos)
	{
		if((trim($campo1)) != (trim($campo2)))
		{
			throw new CampoDiferenteException("Os valores nos campos {$nomecampos} são diferentes",300);
		}
	}

	public static function campoVazio($campo,$nomecampo = NULL)
	{
		$campo = trim($campo);
		
		if(empty($campo))
		{
			throw new CampoVazioException("O campo {$nomecampo} é obrigatório.",300);
		}
	}

	public static function campoTernario($valor,$true,$false)
	{
		$valor = ($valor % 2) ? $true : $false;
			
		return($valor);
	}

	public static function campoVazioTernario($campo,$returntrue,$returnfalse)
	{
		return (!isset($campo)) ? $returntrue : $returnfalse;
	}

	public static function campoEmptyTernario($campo,$returntrue,$returnfalse)
	{
		return (!empty($campo)) ? $returntrue : $returnfalse;
		
	}
	
	public static function campoVazioHash($campo,$camporeturn)
	{
		if($campo == '')
		{
			$coluna = $camporeturn;
		}else
		{
			$coluna = base64_decode($campo);
		}
		return($coluna);
	}
	
	public static function validarQtdCaracter($valor,$qtd,$campo = null)
	{
		
		if(strlen(trim($valor)) < $qtd)
		{
			throw new Exception("O campo {$campo} requer {$qtd} caracteres",300);
		}
	}

	public static function validaQtdCaracter($campo,$qtdcaracter,$nomecampo = null)
	{
		if(strlen(trim($campo)) <= $qtdcaracter)
		{
			throw new Exception("O campo {$nomecampo} deve ter mais de {$qtdcaracter} caracteres",300);
		}
	}	

	public static function retornarStatus($valor,$true,$false)
	{
		$valor = ($valor % 2) ? $true : $false;
			
		return($valor);
	}	
	
}
?>