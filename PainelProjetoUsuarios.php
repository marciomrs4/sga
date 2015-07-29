<?php
	include_once 'componentes/TopoPainelProjeto.php';
?>

<?php 
	$n = rand(1,100);
?>

<div class="container-fluid">
	<div class="col-sm-12">
	<div class="panel panel-primary">
		<div class="panel-heading"><h4><span class="glyphicon glyphicon-folder-open"></span> Total de Projeto(s) em andamento: <?php echo $n;?></h4></div>
  			<div class="panel-body">
    			
    			<?php 
					for($x =0 ; $x<=13; $x++):
				?>
    			
    			<div class="col-xs-6">
    			<div class="panel panel-default">
    				<div class="panel-heading">
    				<div class="panel-title">
															
					<div class="btn-group">
  						<button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    					Descrição <span class="caret"></span>
  						</button>
  							<ul class="dropdown-menu">
    							<li><a href="#">Ver Projeto</a></li>
    							<li><a href="#">Voltar</a></li>
  							</ul>
					</div>
					
						<a>Projeto: <?php echo $n;?> | Responsável: Wellington | Data: <?php echo date('d-m-Y')?> | Status: </a>
					 
					</div>
					</div>
				</div>
				</div>
				
				<?php 
					endfor;
				?>	
					  			
  			</div>
  			<div class="panel-footer"> </div>
		</div>
	</div>
</div>

<?php 
	include_once 'componentes/footerPainel.php';
?>