  </div>
<!--FIM Corpo principal do site -->    

<!--INICIO menu secund?rio da direita -->
    <div id="nav_main">
    <div class="titulo_menu_direita">Menu</div>    
        <ul>
        <?php
		$controleacesso = new ControleDeAcesso();

		$avaliacao = ("<li><a href='AvaliacaoChamado.php'><img src='./css/images/avaliacao.png'> Avalia��o</a></li>");
		$controleacesso->permitirBotao($avaliacao, array(ControleDeAcesso::$Solicitante,ControleDeAcesso::$Tecnico,ControleDeAcesso::$TecnicoADM));


		$botaobusca = ("<li><a href='Busca.php'><img src='./css/images/search.png'> Pesquisar</a></li>");
		$controleacesso->permitirBotao($botaobusca, array(ControleDeAcesso::$Solicitante,ControleDeAcesso::$Tecnico,ControleDeAcesso::$TecnicoADM));
		
		$botaoMelhoria = ("<li><a href='Melhoria.php'><img src='./css/images/melhoria.png'> Melhoria</a></li>");
		$controleacesso->permitirBotao($botaoMelhoria, array(ControleDeAcesso::$Solicitante,ControleDeAcesso::$Tecnico,ControleDeAcesso::$TecnicoADM));
		
		$botaosol = ("<li><a href='Solicitante.php'><img src='./css/images/chamado.png'> Chamado</a></li>");
		$controleacesso->permitirBotao($botaosol, array(ControleDeAcesso::$Solicitante));
		
		$botaoOperacao = ("<li><a href='Operacao.php'><img src='./css/images/chamado.png'> Chamados Recebidos</a></li>");
		$controleacesso->permitirBotao($botaoOperacao, array(ControleDeAcesso::$Tecnico,ControleDeAcesso::$TecnicoADM));

		$botaoSolicitacao = ("<li><a href='Solicitante.php'><img src='./css/images/chamado.png'> Chamados Enviados</a></li>");
		$controleacesso->permitirBotao($botaoSolicitacao, array(ControleDeAcesso::$Tecnico,ControleDeAcesso::$TecnicoADM));
		
		$botaoprojeto = ("<li><a href='Projetos.php'><img src='./css/images/projeto.png'> Projetos</a></li>");					
		$controleacesso->permitirBotao($botaoprojeto, array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico));
		
		$botaoprojeto = ("<li><a href='Atividade.php'><img src='./css/images/atividade.png'> Atividade</a></li>");					
		$controleacesso->permitirBotao($botaoprojeto, array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico));
		
		$botaocklist = ("<li><a href='ExecutarCheckList.php'><img src='./css/images/ck.png'> CheckList</a></li>");
		$controleacesso->permitirBotao($botaocklist, array(ControleDeAcesso::$Tecnico,ControleDeAcesso::$TecnicoADM));

		$botaocklist = ("<li><a href='Aniversariante.php'><img src='./css/images/niver.png'> Anivers�rio</a></li>");
		$controleacesso->permitirBotao($botaocklist, array(ControleDeAcesso::$Tecnico,ControleDeAcesso::$TecnicoADM));

        $SolicitacaoAcesso = ("<li><a href='SolicitacaoAcessoListar.php'><img src='./css/images/acessorestrito.jpg'> Solicita��o de Acesso</a></li>");
        $controleacesso->permitirBotao($SolicitacaoAcesso, array(ControleDeAcesso::$Solicitante,ControleDeAcesso::$Tecnico,ControleDeAcesso::$TecnicoADM));


		if(($_SESSION['dep_codigo'] == 5) OR ($_SESSION['dep_codigo'] == 47)) {
			$ControleVersao = ("<li><a href='ControleVersao.php'><img src='./css/images/versao.png'> Controle de Vers�o</a></li>");
			$controleacesso->permitirBotao($ControleVersao, array(ControleDeAcesso::$Solicitante,ControleDeAcesso::$Tecnico,ControleDeAcesso::$TecnicoADM));
		}

		?>
		</ul>
    </div>
<!--FIM menu secund?rio da direita -->    
    
</div>
<!-- FIM Do quadro da pagina INTEIRA -->
