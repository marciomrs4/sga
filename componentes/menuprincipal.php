</div>     
		<!--FIM Quadro de menu miniatura -->
<!--INICIO menu principal -->
<div id="navcont">
    <ul id="nav">
    
		<?php
		$acesso = new ControleDeAcesso(); 
        $acesso->permitirBotao("<li><a href='Solicitante.php'>Chamado</a></li>",array(ControleDeAcesso::$Solicitante));
        $acesso->permitirBotao("<li><a href='Operacao.php'>Opera��o</a></li>",array(ControleDeAcesso::$Tecnico,ControleDeAcesso::$TecnicoADM));

//        if($_SESSION['dep_codigo'] == 36) {
//            $acesso->permitirBotao("<li><a href='Qualidade.php'>Qualidade</a></li>", array(ControleDeAcesso::$Tecnico, ControleDeAcesso::$TecnicoADM));
//        }

        if($_SESSION['dep_codigo'] != 36) {
            $acesso->permitirBotao("<li><a href='GestorRnc.php'>Qualidade</a></li>", array(ControleDeAcesso::$Tecnico, ControleDeAcesso::$Solicitante, ControleDeAcesso::$TecnicoADM));
        }

        $acesso->permitirBotao("<li><a href='Relatorio.php'>Relat�rio</a></li>",array(ControleDeAcesso::$Solicitante,ControleDeAcesso::$Tecnico,ControleDeAcesso::$TecnicoADM));
        $acesso->permitirBotao("<li><a href='Administracao.php'>Administra��o</a></li>",array(ControleDeAcesso::$TecnicoADM));

        
        ?>                        
    </ul>
</div>    
<!--FIM Menu principal -->

<!--INICIO Corpo principal do site -->
        <div id="content_main">