<?php

/**
 * 
 * Enter description here ...
 * @author marcio.santos
 * @copyright Todos os Direitos Resevados para o produtor.
 */

class Sessao
{

	public static function criarSessao($dados)
	{

		//Carrega da tabela TbAcesso
		$_SESSION['ace_codigo'] = $dados[0];
		$_SESSION['ace_usuario'] = $dados[1];
		$_SESSION['usu_codigo'] = $dados[2];
		
		//Carrega da tabela TbUsuario
		$_SESSION['usu_nome'] = $dados[3];
		$_SESSION['usu_sobrenome'] = $dados[4];
		$_SESSION['usu_email'] = $dados[5];
		$_SESSION['usu_ramal'] = $dados[6];										
		$_SESSION['dep_codigo'] = $dados[7];
		$_SESSION['tac_codigo'] = $dados[8];
		
		$_SESSION['validacaoform'] = base64_encode(date('d-m-Y'));

	}

	public static function destroiSessao()
	{
		session_unset();
		session_destroy();
		header('location: ../../sga/index.php');
	}

	public static function criarAcaoForm($get,$retorno=true)
	{
		
		foreach ($get as $acao => $valor)
		{
			$_SESSION['acao'] = $acao;
			$_SESSION['valor']	 = $valor;
			$_SESSION['acaoform'] = $acao;
			$_SESSION['valorform'] = $valor;
			break 1;
		}

		if($retorno == true)
		{			
		  header('location: '.$_SERVER['HTTP_REFERER']);
		}
	}

	public static function finalizarSessao($session = null)
	{
		unset($_SESSION['acao'],$_SESSION['valor'],$_SESSION['erro'],$_SESSION['sempermissao'],$_SESSION['mensagem'],$session);
	}

	public static function mostrarSessao()
	{
		echo('<pre>');
			print_r($_SESSION);
		echo('</pre>');
	}

	public static function validarForm($formname)
	{
		if(!isset($_SESSION[$formname]))
		{
			$_SESSION[$formname] = null;
		}

	}
}
?>