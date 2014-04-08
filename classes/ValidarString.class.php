<?php

class ValidarString extends ClasseException
{

	public static function validarEmail($email,$nomecampo = null)
	{
		if(!filter_var($email,FILTER_VALIDATE_EMAIL))
		{
			throw new EmailInvalidoException("O e-mail no campo {$nomecampo} não é válido",1);
		}
	}

	public static function isString($campo,$nomecampo = null)
	{	
		if(!is_string($campo))
		{
			throw new CampoStringException("Valor incorreto: esperado string no campo {$nomecampo} ",300);
		}
	}
	
}

?>