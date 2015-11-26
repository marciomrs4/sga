<?php
	include_once 'componentes/TopoPainelProjeto.php';
?>

<?php 
	$n = rand(1,100);
?>

<div class="container-fluid">
	<div class="col-sm-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="glyphicon glyphicon-folder-open"></span> Total de Projeto(s) em andamento: <?php echo $n;?>
                    </h3>
                </div>
  			<div class="panel-body">
    			
                        <p class="text-center">
                            LEGENDA DOS PROJETOS - 
                            <span class="label label-success"> &nbsp;</span>&nbsp; Dentro do prazo &nbsp;
                            <span class="label label-warning"> &nbsp;</span>&nbsp; Estourando o prazo &nbsp;
                            <span class="label label-danger"> &nbsp;</span>&nbsp; Fora do prazo &nbsp;
                            <hr>        
                        </p>    
                            
    			<?php 
                            for($x =0 ; $x<=13; $x++):
			?>
    			
                            <div class="col-xs-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="panel-title">

                                                <a href="DescricaoProjeto.php"><button type="button" class="btn btn-primary btn-sm"> Ver Projeto</button></a>
                                                <a>Projeto: <?php echo $n; ?> | Responsável: Wellington | Data: <?php echo date('d-m-Y') ?> </a>

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