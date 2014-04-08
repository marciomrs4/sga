  </div>
<!--FIM Corpo principal do site -->    

<!--INICIO menu secundário da direita -->
    <div id="nav_main">
    <div class="titulo_menu_direita">Menu</div>
        <ul>
			<li><a href="Departamentos.php"><img src='./css/images/departamento.png'> Departamentos</a></li>			        
			<li><a href="Usuarios.php"><img src='./css/images/perfil.jpg'> <?php echo($_SESSION['config']['usuario']);?></a></li>
			<li><a href="Tempo.php"><img src='./css/images/tempo.png'> Tempo</a></li>			
			<li><a href="Prioridades.php"><img src='./css/images/prioridade.png'> Prioridade</a></li>
			<li><a href="Problemas.php"><img src='./css/images/ocorrencia.png'> <?php echo($_SESSION['config']['problema']);?></a></li>			

			<li><a href="CadastrarCheckList.php"><img src='./css/images/ck.png'> CheckList</a></li>	
			
		<!-- <li><a href="chamadotransportelistar.php">Solicitação de transporte</a></li>
			<li><a href="cadastroreuniaolistar.php">Lista de Reunioes</a></li>						
			-->
		</ul>
    </div>
<!--FIM menu secundário da direita -->    
    
</div>
<!-- FIM Do quadro da pagina INTEIRA -->
