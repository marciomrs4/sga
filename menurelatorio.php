</div>
<!--FIM Corpo principal do site -->

<!--INICIO menu secund?rio da direita -->
<div id="nav_main">
	<div class="titulo_menu_direita">Menu</div>
	<ul>
        <span>
		<?php
		if(in_array($_SESSION['tac_codigo'],array(ControleDeAcesso::$Tecnico,ControleDeAcesso::$TecnicoADM))){
		?>
			<b>Relat�rios</b>
		</span>
		<!--
			<li><a href="RelatorioPorUsuario.php">Chamados por usuario</a></li>
			<li><a href="RelatorioPorArea.php">Chamados por �rea</a></li>
			<li><a href="RelatorioPorPeriodo.php">Chamados por Per�odo</a></li>
			<li><a href="RelatorioPorPrioridade.php">Chamados por Prioridade</a></li>			
  		-->
		<li><a href="RelatorioPorPeriodoTempo.php">Chamados por Tempo</a></li>
		<li><a href="RelatorioAvaliacaoChamados.php" target="_blank">Avalia��o dos Chamados</a></li>
		<li><a href="RelatorioSolucao.php" target="_blank">Tempo de Solu��o</a></li>
		<li><a href="RelatorioSolucaoTempoEnvioTerceiro.php" target="_blank">Tempo de Solu��o com Terceiro</a></li>
		<li><a href="RelatorioDeTarefa.php" target="_blank">Relat�rio de Tarefas</a></li>
		<li><a href="RelatorioMelhoria.php">Relat�rio de Melhoria</a></li>
		<hr>
		<?php
		}
		?>
		<span>
			<b>Pain�is</b>
		</span>
		<li><a href="PainelProjetoUsuarios.php" target="_blank">Painel de Projetos</a></li>
		<?php

		if(in_array($_SESSION['tac_codigo'],array(ControleDeAcesso::$TecnicoADM, ControleDeAcesso::$Tecnico))) {
			?>
			<li><a href="PainelChamados.php">Painel de Chamados</a></li>
			<li><a href="PainelProjetosEquipe.php">Painel de Atividades</a></li>
<!--			<li><a href="PainelAtividade.php">Painel de Atividade</a></li>-->
			<!--			<li><a href="PainelProjeto.php">Painel de Projetos</a></li>-->
			<li><a href="PainelTarefas.php" target="_blank">Painel de Tarefas</a></li>


			<?php
		}

		if(in_array($_SESSION['tac_codigo'],array(ControleDeAcesso::$Tecnico,ControleDeAcesso::$TecnicoADM))) {
			?>
			<hr>
			<span><b>Gr�ficos</b></span>
			<li><a href="GraficoQuantidadeChamado.php">Chamado por Atendente</a></li>
			<li><a href="GraficoQuantidadeAtividade.php">Atividade por Status</a></li>
			<li><a href="GraficoAtividadePorUsuario.php">Quantidade de Atividade</a></li>
			<li><a href="GraficoQuantidadeChamadoAbertoPorArea.php">Chamado por Area no Per�odo</a></li>
			<?php
		}
		?>
	</ul>
</div>
<!--FIM menu secund?rio da direita -->

</div>
<!-- FIM Do quadro da pagina INTEIRA -->
