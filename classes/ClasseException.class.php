<?php

class CampoDiferenteException extends Exception{}
class CampoVazioException extends Exception{}
class CriacaoSessaoException extends Exception{}
class EmailInvalidoException extends Exception{}
class CampoIncompletoException extends Exception{}
class ErroAoGravarException extends PDOException{}
class DataInvalidaException extends Exception{}
class CampoStringException extends Exception{}

class ClasseException
{

	public static function throwException($e,$post = null,$form = null)
	{
			$_SESSION[$form] = $post;
			
			$_SESSION['erro'] = Texto::erro($e->getMessage());
			
			$_SESSION['acao'] = $_SESSION['acaoform'];
			$_SESSION['valor'] = $_SESSION['valorform'];

			header('location: '.$_SERVER['HTTP_REFERER']);
	}
	
}