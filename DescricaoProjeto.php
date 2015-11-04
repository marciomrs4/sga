<?php
include_once 'componentes/TopoDescricaoProjeto.php';
?>

<div class="container-fluid">   
    <div class="col-xs-12">

        <!-- DESCRIÇÃO RESUMIDA DA RNC -->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-folder-open"></span> &nbsp;DETALHES DO PROJETO</h3>
            </div>
            <div class="panel-body">

                <?php for ($x = 0; $x <= 2; $x++): ?>
                <div class="col-xs-4">                    
                    <div class="panel panel-default">               
                        <div class="panel-heading">
                            
                        </div>
                        <div class="panel-body"> 
                            
                            <!-- Detalhes do projeto -->
                            <div class="col-xs-12">
                                <label class="text-warning">Número do projeto:</label> <?php echo $n; ?> 
                                <br>
                            </div>
                            <div class="col-xs-12">
                                <label class="text-warning">Título do projeto:</label> Kanban Segunda Fase 
                                <br>
                            </div>
                            <div class="col-xs-12">
                                <label class="text-warning">Usuário solicitante:</label> Wellington Junior 
                                <br>
                            </div>
                            <div class="col-xs-12">
                                <label class="text-warning">Previsão de inicio:</label> 01/01/9999 
                                <br>
                            </div>
                            <div class="col-xs-12">
                                <label class="text-warning">Previsão fim:</label> 01/01/9999 
                                <br>
                            </div>
                            <div class="col-xs-12">
                                <label class="text-warning">Status :</label> Em Andamento 
                            </div>

                        </div>
                    </div>                    
                </div>
                <?php endfor; ?> 
                <!-- Detalhes do projeto -->

                <!-- Lista de atividades -->    
                <div class="col-xs-12">
                    <div class="panel panel-default">               
                        <div class="panel-heading">
                            <div class="panel-title"><span class="glyphicon glyphicon-cog"></span> ATIVIDADES DO PROJETO</div>                                                         
                        </div>
                        
                        <div class="panel-body">  
                            <p class="text-center">
                                    LEGENDA DAS ATIVIDADES - 
                                        <span class="label label-success"> &nbsp;</span>&nbsp; Dentro do prazo &nbsp;
                                        <span class="label label-warning"> &nbsp;</span>&nbsp; Estourando o prazo &nbsp;
                                        <span class="label label-danger"> &nbsp;</span>&nbsp; Fora do prazo &nbsp;
                                    
                            </p>
                            
                            <?php
                                for ($x = 0; $x <= 9; $x++):
                            ?>
                                <div class="col-xs-6">
                                    <div class="panel panel-danger">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" title="Ver Atividade">
                                                    <span class="glyphicon glyphicon-eye-open"></span>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            ...
                                                        </div>
                                                    </div>
                                                </div>

                                                <a>Atividade: <?php echo $n; ?> | Responsável: Wellington | Data: <?php echo date('d-m-Y') ?> </a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endfor; ?>
                                                                                        
                        </div>
                    </div>            
                </div>
                <!-- Fim Lista de atividades -->
                
                <?php for ($x = 0; $x <= 1; $x++): ?>
                <div class="col-xs-6">
                    <div class="panel panel-info">               
                        <div class="panel-heading">
                            <div class="panel-title"><span class="glyphicon glyphicon-picture"></span> GRÁFICO DE ATIVIDADES</div>                                                         
                        </div>
                        
                        <div class="panel-body">      
                            <p class="text-center">LEGENDA DO GRÁFICO - 
                                <span class="label label-success"> &nbsp;</span>&nbsp; Dentro do prazo &nbsp;
                                <span class="label label-warning"> &nbsp;</span>&nbsp; Estourando o prazo &nbsp;
                                <span class="label label-danger"> &nbsp;</span>&nbsp; Fóra do prazo &nbsp;
                            </p>
                            
                            <p>GRÁFICO AQUI</p>
                            
                        </div>
                    </div>            
                </div>
                <?php endfor;?>
                
            </div>                        
            <div class="panel-footer"></div>
        </div>
    </div>
</div>

<?php
include_once 'componentes/footerPainel.php';
?>