  </div>
<!--FIM Corpo principal do site -->    

<!--INICIO menu secund?rio da direita -->
    <div id="nav_main">
       <div class="titulo_menu_direita">Menu</div>
        <ul>
        <span>
			<b>Relatórios</b>
		</span>
<!-- 		<li><a href="RelatorioPorUsuario.php">Chamados por <?php echo($_SESSION['config']['usuario']);?></a></li>
			<li><a href="RelatorioPorArea.php">Chamados por ?rea</a></li>
			<li><a href="RelatorioPorPeriodo.php">Chamados por Per?odo</a></li>
			<li><a href="RelatorioPorPrioridade.php">Chamados por Prioridade</a></li>			
  -->					
			<li><a href="RelatorioPorPeriodoTempo.php">Chamados por Tempo</a></li>			
			<li><a href="RelatorioSolucao.php" target="_blank">Tempo de Solução</a></li>
            <li><a href="RelatorioSolucaoTempoEnvioTerceiro.php" target="_blank">Tempo de Solução com Terceiro</a></li>
            <li><a href="RelatorioDeTarefa.php" target="_blank">Relatório de Tarefas</a></li>
	<hr>		
		<span>
			<b>Painéis</b>
		</span>
			<?php
			if($_SESSION['dep_codigo'] == 36) {
			?>
			<li>
				<a href="PainelQualidade.php" target="_blank">Painel Qualidade</a></li>
			<?php
			}
			?>
			<li><a href="PainelChamados.php">Painel de Chamados</a></li>
			<li><a href="PainelAtividade.php">Painel de Atividade</a></li>																								
<!--			<li><a href="PainelProjeto.php">Painel de Projetos</a></li>-->
			<li><a href="PainelProjetoUsuarios.php">Painel de Projetos</a></li>
            <li><a href="PainelTarefas.php" target="_blank">Painel de Tarefas</a></li>

            <hr>

		<span><b>Gráficos</b></span>
			<li><a href="GraficoQuantidadeChamado.php">Chamado por Atedente</a></li>		
			<li><a href="GraficoQuantidadeAtividade.php">Atividade por Status</a></li>
			<li><a href="GraficoAtividadePorUsuario.php">Quantidade de Atividade</a></li>			
		</ul>
    </div>
<!--FIM menu secund?rio da direita -->    
    
</div>
<!-- FIM Do quadro da pagina INTEIRA -->
