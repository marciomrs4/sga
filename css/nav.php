<?php 
header("Content-type: text/css");

include_once($_SERVER['DOCUMENT_ROOT'].'/centralsolicitacao/componentes/config.php');
/*
	private $lay_codigo = 'lay_codigo';
	private $lay_fundo_tela = 'lay_fundo_tela';
	private $lay_menu_principal = 'lay_fundo_tela';
	private $lay_botoes_menu = 'lay_botoes_menu';
	private $lay_botoes_tela = 'lay_botoes_tela';
	private $lay_tabela = 'lay_tabela';
	private $lay_tabela_linha_par = 'lay_tabela_linha_par';
	private $lay_tabela_linha_impar = 'lay_tabela_linha_impar';
	private $lay_passar_mouse_botao = 'lay_passar_mouse_botao';
	private $lay_passar_mouse_tabela = 'lay_passar_mouse_tabela';
*/
# Istancia da Classe Busca
$layout = new Busca();
# metodo que busca no banco o layout do usuário
$dados = $layout->getLayoutUsuario($_SESSION['usu_codigo']);

?>

@charset "utf-8";
/* CSS Document */


#navcont {
	margin-left: 11px;
}
	

#nav {

	background: <?php echo($dados['lay_menu_principal']); ?>;
 
 /*   
 	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#5D81B1), to(#5D81B1), color-stop(.6,#369)); 
 
	background: -moz-linear-gradient(top, #000, #5D81B1) repeat-X;
*/	

	width: 99%;
	height: 38px;
	margin-top: 5px;
	list-style: none;
	float: left;
	}

#nav li {
	float: left;
	}
	
#nav a:link, #nav a:visited {
	float: left;
	line-height: 42px;
	height: 38px;
	display: block;
	padding: 0 22px 0 22px;
	color: #fff;
	text-decoration: none;
	background: url('images/nav/nav_bg.gif') repeat-x;
	}

#nav a:hover, #nav a:active {
	text-decoration: underline;
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#369), to(#369), color-stop(.6,#5D81B1));	
	/* background: #000 url('images/nav/nav_hover.png') repeat-x; */
	}

