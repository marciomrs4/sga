  </div>
<!--FIM Corpo principal do site -->    

<!--INICIO menu secund?rio da direita -->
    <div id="nav_main">
    <div class="titulo_menu_direita">Menu</div>    
        <ul>
        <?php
		$controleacesso = new ControleDeAcesso();

/*		$botaobusca = ("<li><a href='BuscaRnc.php'><img src='./css/images/search.png'> Pesquisar</a></li>");
		$controleacesso->permitirBotao($botaobusca, array(ControleDeAcesso::$Solicitante,ControleDeAcesso::$Tecnico,ControleDeAcesso::$TecnicoADM));*/

		if($_SESSION['dep_codigo'] != 36) {
			$botaoRNCGestor = ("<li><a href='GestorRnc.php'><img src='./css/images/melhoria.png'> RNC</a></li>");
			$controleacesso->permitirBotao($botaoRNCGestor, array(ControleDeAcesso::$Solicitante, ControleDeAcesso::$Tecnico, ControleDeAcesso::$TecnicoADM));
		}

		if($_SESSION['dep_codigo'] == 36) {
			$botaoRNCQualidade = ("<li><a href='Qualidade.php'><img src='./css/images/melhoria.png'> RNC</a></li>");
			$controleacesso->permitirBotao($botaoRNCQualidade, array(ControleDeAcesso::$Solicitante, ControleDeAcesso::$Tecnico, ControleDeAcesso::$TecnicoADM));
		}
		?>
		</ul>
    </div>
<!--FIM menu secund?rio da direita -->    
    
</div>
<!-- FIM Do quadro da pagina INTEIRA -->
