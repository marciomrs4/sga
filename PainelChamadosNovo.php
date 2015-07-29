<?php
	 include_once 'componentes/TopoPainelChamados.php';
?>
	
	<div class="container-fluid">
	<!-- Div Principal -->	
	<?php 
	$rand = rand(1,1000);
	?>
	
	<div class="panel panel-default">
  		<div class="panel-heading"><h4>Total de Chamado(s): <?php echo $rand;?> Em aberto, <?php echo $rand;?> Em atendimento  e <?php echo $rand;?>
  		 concluídos hoje</h4></div> 
	</div>			
		
		<?php 
		for($x =0 ; $x<=7; $x++):
		?>			
				
		<div class="container col-sm-3">
		<!-- Div Painel Chamados -->
			<div class="panel panel-primary">
			
			<div class="panel-heading">			
				<h3 class="panel-title"><span class="glyphicon glyphicon-user"></span> Usuário - <?php echo $x; ?></h3>		
			</div>
			
				<div class="panel-body">
				
					<div class="table-responsive">
                    <table class="table table-bordered">                       
                       <tr class="active">
                       		<td></td>                        			                   	
                    		<td>Número</td>
							<td>Usuário</td>
                    		<td>SLA</td>                    	                    	                    	                                        		                    		
                    	</tr>                   	
                    	
                    	<tr> 
                    		<td class="col-sm-1">
                    			<div class="btn-group">
                    				<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                    					<span class="caret"></span>
                    				</button>
                    				<ul class="dropdown-menu" role="menu">
                    					<li>
                    						<button type="button" value="" class="chamado">Ver chamado</button>
                    					</li>	
                    				</ul>
                    			</div>
                    		</td>	                    	                   	
                    		<td><?php echo rand(1,1000);?></td>
							<td><?php echo chr(rand(1,1000)); ?></td>
                    		<td>
                    		<div class="progress">
  								<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="60" aria-valuemin="0" 
  									 aria-valuemax="100" style="width: 60%;">
    								60%
								  </div>
								</div>
                    		</td>                     		                   	                    	                    	                                        		                    	
                    	</tr>                   	
                    </table>
                    </div>				
				</div>
				<div class="panel-footer"></div>			
			</div>
			
		<!-- Fim Div Painel Chamados -->
		</div>						
		
		<?php endfor;?>
					
	</div>
	<!-- Fim Div Principal -->
	
<?php 
	include_once 'componentes/footerPainel.php'; 
?>
