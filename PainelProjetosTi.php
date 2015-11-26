<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/sga/componentes/config.php');
include_once 'componentes/TopoPainelUsuario.php';
?>

<div class="container-fluid">   
    <div class="col-xs-10 col-xs-offset-1">    
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-folder-open"></span>&nbsp; PROJETO:</h3>
            </div>
            <br>
            <div class="panel-body">                                                 
                
                    <div class="col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><span class="glyphicon glyphicon-user"></span> <?php echo(ucfirst($_SESSION['usu_nome'])); ?></h3>
                            </div>
                            <div class="panel-body">
                                
                                <table class="table table-bordered">
                                    <tr>
                                        <h3 class="text-warning">Projeto: X</h3>
                                        
                                        <th class="text-info">                                            
                                            Atividade
                                        </th>                                        
                                        <th class="text-info">                                            
                                            Inicio
                                        </th>                                        
                                        <th class="text-info">                                            
                                            Fim
                                        </th>                                        
                                        <th class="text-info">                                            
                                            Dias
                                        </th>
                                    </tr>
                                    <tr>                                                                                
                                        <td>                                            
                                            Atividade
                                        </td>                                        
                                        <td>                                            
                                            Inicio
                                        </td>                                        
                                        <td>                                            
                                            Fim
                                        </td>                                        
                                        <td>                                            
                                            Dias
                                        </td>
                                    </tr>
                                </table>
                                
                            </div>
                            <div class="panel-footer"></div>
                        </div>
                    </div>
                                                
            </div>
            <div class="panel-footer"></div>
        </div>
    </div>
</div>

<?php
include_once './componentes/footerPainel.php';
?>