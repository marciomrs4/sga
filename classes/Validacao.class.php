<?php

class Validacao extends ClasseException
{
		
	final public static function hashSenha($senha)
	{
		return(sha1($senha));
	}
	
	final public static function descriptograr($campo)
	{
		return(base64_decode($campo)); 
	}

	/*
	public static function campoNaoObrigadorio($campo,$Class,$Method,$param = null)
	{
		if(!empty($campo))
		{
			$Class::$Method($campo,$param);
		}
		
	}
	*/

}