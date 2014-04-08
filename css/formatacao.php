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

#nav_main2 {
	/* width: 185px;
	height: 650px;
	*/
	padding: 0 0px 0 25px;
	margin: 32px 0;
	}
#nav_main2 ul {
	list-style: none;
	}
	
#nav_main2 ul li {
	line-height: 23px;
	}
	
#nav_main2 a:link, #nav_main2 a:visited {
	color: #383838;
	text-decoration: none;
	}
	
#nav_main2  a:hover, #info a:active {
	color: #585858;
	text-decoration:underline;
	}
li.lista
{
	padding-bottom: 5px;
	padding-top: 5px;	
	color: white;
	font-size: 12pt;
	
}

li.lista:
{
	text-decoration: blink;
	background-color: black;
}

.subtitulo{
	font-size: 16px;
	}

.titulo{font-size:22px;
		}

.erro{
	color:#FF6347;
	}
	
.sucesso{
	color:#06C;
	}	

.linha1{
	background-color:#CCC;
	}
	
.linha2{
	background-color:#FFF;
	}
	
.linha1:hover, .linha2:hover{
	background-color: <?php echo($dados['lay_passar_mouse_tabela']); ?>;
	color:#FFF;
	}
	
	
.linha3{
	background-color:#666;
	color:#FFF;	
	}				
.tabela{background-color:#666;
}

legend{font-weight: bold;}

table thead tr th{ 
	padding: 0px 5px 0px 5px;
	}

table tr td{
	padding: 0px 5px 0px 5px;
	}

a.tabela{color:#FFF; 
		text-decoration:none;
		}

a.tabela:hover{
			color:#CCC;
			}

#colorpickerField1{
	color: <?php echo($dados['lay_fundo_tela']); ?>;
	background-color: <?php echo($dados['lay_fundo_tela']); ?>;
}

#colorpickerField2{
	color: <?php echo($dados['lay_menu_principal']); ?>;
	background-color: <?php echo($dados['lay_menu_principal']); ?>;
}

.layout{
	cursor: pointer;
	width: 60px;
	height: 35px;
	}

#conteudo{

width: 98%;

}

textarea:hover, input:hover, select:hover{
	background-color: #E8E8E8;
	border-color: black;
	color: #000;
	}	
	
.button-menu{
	width: 160px;
	margin-right: 15px;
	margin-bottom: 5px; 
	padding: 5px 5px 5px 5px ;
	background-color: #CFCFCF;
	color: 000;
	font-weight: bold;
	}
	
.button-menu:hover{
	padding: 5px 5px 5px 5px;	
	border-color: black;
	background-color: #E8E8E8;	
	cursor: pointer;
	}	
	
.button-tela{
	width: 160px; 
	padding: 5px 5px 5px 5px ;
	background-color: #CFCFCF;
	color: 000;
	font-weight: bold;
	}
	
.button-tela:hover{
	padding: 5px 5px 5px 5px;	
	border-color: black;
	background-color: #06C;	
	cursor: pointer;
	color: #FFF;
	}
	