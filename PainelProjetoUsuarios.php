<?php
include_once 'componentes/TopoPainelProjeto.php';


$tbUsuarioProjeto = new TbUsuarioProjeto();

$tbProjeto = new TbProjeto();


?>

<div class="container-fluid">
	<div class="col-sm-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="glyphicon glyphicon-folder-open"></span> Total de Projeto(s) em andamento: <?php echo $tbUsuarioProjeto->countProjectByUser($_SESSION['usu_codigo']); ?>
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

            foreach($tbUsuarioProjeto->findProjetoByUsers($_SESSION['usu_codigo']) as $projeto):

                $dadosProjeto = $tbProjeto->getInfoPainelProjeto($projeto['pro_codigo']);

                $calculatePercent = new CalculatePercent($dadosProjeto['pro_previsao_inicio'],
                                                         $dadosProjeto['pro_previsao_fim']);

           ?>
                <div class="col-xs-6">
                    <div class="panel panel-<?php echo $calculatePercent->getColor(); ?>">
                        <div class="panel-heading">
                            <div class="panel-title">
                                 <a href="DetalheProjeto.php?<?php echo base64_encode(pro_codigo) ?>=<?php echo base64_encode($projeto['pro_codigo']); ?>">
                                     <button type="button" class="btn btn-primary btn-sm"> Ver Projeto</button></a>
                                 <a>Projeto: <?php echo $dadosProjeto['pro_titulo']; ?>  |
                                    Responsável: <?php echo $dadosProjeto['responsavel']; ?> |
                                    Status: <?php echo $dadosProjeto['status'] ?>
                                 </a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
                endforeach;
            ?>

            </div>
  			<div class="panel-footer">

            </div>
		</div>
	</div>
</div>

<?php 
	include_once 'componentes/footerPainel.php';
?>