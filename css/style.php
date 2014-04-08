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
@import url(nav.php);
/* CSS Document */



/* Blanket Styles*/
body {
	background-color: <?php echo($dados['lay_fundo_tela']); ?>;
	margin: 0; padding: 0;
	font-size: small;
	color: #383838;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	}
* html body {
	font-size: x-small; /* for IE5/Win */
	f\ont-size: small; /* for other IE versions */
	}
 
img {
	border-style: none;
}

* {
	margin: 0; padding: 0;
	}
 
a:link, a:visited {
	color: #383838;
	text-decoration: underline;
	}
	
a:hover, a:active {
	color: #585858;
	}
 
 
 
/* Conatiner */ 
#container {
	background-color: #fff;
	width: 98%;
	margin: 0 auto;
	overflow: hidden;
	}

/* Header */
#container h1 {
	background: #FFFFFF url(images/header.png) no-repeat;
	width: 160px;
	height: 120px;
	margin: 10px 0 0 10px;
	text-indent: -9999em;
	float: left;
	}

#cabecalho h2{
	width: 60%;
	height: 120px;
	/* margin: 10px 0px 0px 0px; */
	float: left;
	text-align: center;
	font-size: 26pt;
	font-size-adjust: 100%
	}
	
	
#mensagemerro{
	width: 100px;
	height: 25px;
	margin: 28px 0 0 18px;
	/* float: center; */
	}
	
#buttons {
	margin: 30px 27px 0;
	float: right;
	}
	
#buttons img {
	padding-left: 20px;
	}


/* Info */
#info {
	background: url(images/info_bg.gif) no-repeat;
	width: 823px;
	height: 161px;
	margin: 0 auto;
	clear: both;
	}
	
#info h2 {
	font: 100 140% Arial, Helvetica, sans-serif;
	letter-spacing: 1.5px;
	color: #464646;
	padding: 22px 0 0 25px;
	}
	
#info p {
	width: 220px;
	color: #898888;
	padding: 5px 0 0 25px;
	}
	
#whatisthis {
	float: left;
	width: 300px;
	}
	
#templatetypes {
	float:left;
	width: 200px;
	padding: 21px 0 0 66px;
	}
	
#supportlinks {
	float: right;
	width: 155px;
	padding: 21px 50px 0;
	}
	
#info ul {
	list-style-image: url(images/bullet.gif);
}

#info li {
	line-height: 22px;
	}
	
#info a:link, #info a:visited {
	color: #585858;
	text-decoration: none;
	}
	
#info a:hover, #info a:active {
	color: #585858;
	background-color: #FFFFFF;
	}
	
	
	
/* Main Content Area */
#content_main {
	width: 750px;
	padding: 0 0 0 15px;
	margin: 20px 0;
	float: left;
	text-align: justify;
	}
	
#content_main p {
	line-height: 23px;
	display: block;
	text-align: left;
	padding-bottom: 10px;
	}	
	
#nav_main {
	float: right;
	width: 185px;
	background: url(images/r_bg.gif) repeat-y;
	height: 650px;
	padding: 0 0px 0 25px;
	margin: 32px 0;
	}
	
#nav_main ul {
	list-style: none;
	}
	
#nav_main ul li {
	line-height: 23px;
	}
	
#nav_main a:link, #nav_main a:visited {
	color: #383838;
	text-decoration: none;
	}
	
#nav_main  a:hover, #info a:active {
	color: #585858;
	text-decoration:underline;
	}
	
#card {
	float: left;
	}
	
h3 {
	font-family: "Times New Roman", Times, serif;
	font-size: 180%;
	font-weight: 100;
	}
	
h4 {
	color: #bbbbbb;
	font-family: "Times New Roman", Times, serif;
	font-weight: 100;
	padding-bottom: 8px;
	}
	
hr { 
	border: 0;
	color: #d7d5cb;
	background: #d7d5cb;
	height: 1px;
	margin: 15px 0 20px 0;
}	
	
/* Footer */
#footer {
	width: 98%;
	color: #fff;
	font-size: 85%;
	margin: 20px auto;
	}	
	
#footer a:link, #footer a:hover, #footer a:active, #footer a:visited {
	color: #fff;
	text-decoration: none;
	}
	
#copyright {
	float: left;
	}
	
#nav_footer {
	float: right;
	list-style: none;
	}
	
#nav_footer li {
	float: left;
	}