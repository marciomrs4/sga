</div>     
		<!--FIM Quadro de menu miniatura -->
<!--INICIO menu principal -->
<div id="navcont">
    <ul id="nav">
    
		<?php
		$acesso = new ControleDeAcesso(); 
        $acesso->permitirBotao("<li><a href='Solicitante.php'>Chamado</a></li>",array(ControleDeAcesso::$Solicitante));
        $acesso->permitirBotao("<li><a href='Operacao.php'>Operação</a></li>",array(ControleDeAcesso::$Tecnico,ControleDeAcesso::$TecnicoADM));
        $acesso->permitirBotao("<li><a href='Relatorio.php'>Relatório</a></li>",array(ControleDeAcesso::$Tecnico,ControleDeAcesso::$TecnicoADM));
        $acesso->permitirBotao("<li><a href='Administracao.php'>Administração</a></li>",array(ControleDeAcesso::$TecnicoADM));
        $acesso->permitirBotao("<li><a href='Qualidade.php'>Qualidade</a></li>",array(ControleDeAcesso::$Tecnico,ControleDeAcesso::$TecnicoADM));
        
        ?>                        
    </ul>
</div>    
<!--FIM Menu principal -->

<!--INICIO Corpo principal do site -->
        <div id="content_main">