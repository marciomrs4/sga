<?php

class Error
{
		
	public function showErrors()
	{
		$erros = array();
		
		if(isset($_SESSION['erro']) or isset($_SESSION['erros'])){
		echo '<div class="alert alert-danger">';
			echo $_SESSION['erro'],'<br />';
			$erros = isset($_SESSION['erros']) ? $_SESSION['erros'] : $erros;
			foreach ( $erros as $erro){
				if($erro){
					echo $erro,'<br />';
				}
			}
		echo '</div>';
		}
	}

	public function getDisplay()
	{
		
		if(isset($_SESSION['openmodal'])){
			$_SESSION['display'] = 'block';
			echo $_SESSION['display'];		
		}
				
		unset($_SESSION['display']);
	}
	
	public function showMessages()
	{
		
		if(isset($_SESSION['message'])){

			echo '<div class="alert alert-success">',
				$_SESSION['message'],
			'</div>';
		
		}

		unset($_SESSION['message']);
	}
	
	public function validadeForm($formName)
	{
	    if(!isset($_SESSION[$formName])){
	        //$_SESSION[$formName] == null;
	    }
	    return $this;
	}

	public function clear()
	{

		$modulo = $_SESSION['modulo'];
		$action = $_SESSION['action'];
		
		unset($_SESSION['action'],$_SESSION['modulo'],
			  $_SESSION['value'],$_SESSION['erro'],
			  $_SESSION['erros'],$_SESSION[$modulo.'/'.$action],$_SESSION['openmodal']);
	}
	
}