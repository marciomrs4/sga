<?php


/**
 *@author Márcio Ramos
 *@name Classe para login
 *@version 2.0
 *@example Utilizado para controle de login
 *@return Retorna um objeto
 */
class Logar extends Dados
{

	public function fazerLogin()
	{

		try
		{

			ValidarCampos::campoVazio($this->dados['ace_usuario'],$_SESSION['config']['usuario']);
			ValidarCampos::campoVazio($this->dados['ace_senha'],$_SESSION['config']['senha']);
	
			$this->dados['ace_senha'] = Validacao::hashSenha($this->dados['ace_senha']);		
			
		}catch (CampoVazioException $e)
		{
			throw new CampoVazioException($e->getMessage(),$e->getCode());
		}
		try 
		{
			$tbacesso = new TbAcesso();
			$confirma = $tbacesso->confirmarUsuario($this->dados);
			
			if($confirma != 1)
			{
				throw new Exception($_SESSION['config']['usuario'].' não encontrado');
				
			}elseif ($confirma == 1)
			{
				$dados = $tbacesso->getAcesso($this->dados);
				
				$tbusuario = new TbUsuario();
				$dados2 = $tbusuario->getUsuario($dados['usu_codigo']);
				
				$dados3 = array_merge($dados,$dados2);
				
				Sessao::criarSessao($dados3);
			}
			
		} catch (PDOException $e) 
		{
			throw new PDOException($e->getMessage(),$e->getCode());
		}
		
	}
}
?>