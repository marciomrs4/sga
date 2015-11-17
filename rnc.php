<?php
include_once 'componentes/TopoRnc.php';
?>

<!-- QUALIDADE -->
<div class="container-fluid">   
    <div class="col-xs-12">    
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-user"></span> QUALIDADE</h3>
            </div>

            <div class="panel-body">

                <form name="rnc" method="post" action="action/cadastrarRnc.php">

                    <?php if($_SESSION['erro']):?>
                        <div class="alert alert-danger" role="alert"><?php echo $_SESSION['erro']; ?></div>
                    <?php endif;?>
                        
                    <?php if($_SESSION['mensagem']):?>
                        <div class="alert alert-success" role="alert"><?php echo $_SESSION['mensagem']; ?></div>
                    <?php endif;?>    
                                                                
                    
                    <div class="col-xs-12">
                        <label class="text-info">DESCRIÇÃO DA NÃO COMFORMIDADE:</label>
                        <textarea class="form-control" rows="3" name="nc_descricaocompleta" placeholder="DESCRIÇÃO"
                                  value="<?php echo($_SESSION['rnc']['nc_descricaocompleta']); ?>"></textarea>
                        <br>
                    </div>
                    <div class="col-xs-3">
                        <label class="text-info">LOCAL DA OCORRÊNCIA:</label>
                        <input type="text" class="form-control" name="nc_local_ocorrencia" placeholder="LOCAL"
                               value="<?php echo($_SESSION['rnc']['nc_local_ocorrencia']); ?>">                                                                 
                    </div>
                    <div class="col-xs-3">
                        <label class="text-info">DATA DA OCORRÊNCIA:</label>
                        <input type="date" class="form-control" name="nc_data_ocorrencia" placeholder="DATA DA OCORRÊNCIA" title="DATA DA OCORRÊNCIA"
                               value="<?php echo($_SESSION['rnc']['nc_data_ocorrencia']); ?>">                                                                 
                    </div>
                    <div class="col-xs-3">
                        <label class="text-info">EMITENTE:</label>
                        
                    <?php
                    $tbUsuario = new TbUsuario();
                    
                    $selectUsuarios = new SelectOption();
                    
                    $selectUsuarios->setStmt($tbUsuario->selectUsuarios())
                            ->isRequire()
                            ->setClass('form-control')
                            ->setOptionEmpty('SELECIONE')
                            ->setSelectName('usu_emitente_codigo')
                            ->listOption();
                    ?>
                        
                    </div>
                                                            
                    <div class="col-xs-3">
                        <label class="text-info">DEPTO RESPONSÁVEL:</label>

                        <?php
                        $tbDepartamento = new TbDepartamento();

                        //$tbDepartamento->getAllDepartamentos();

                        $SelectDepartamento = new SelectOption();

                        $SelectDepartamento->setStmt($tbDepartamento->getAllDepartamentos())
                                ->isRequire()
                                ->setClass('form-control')
                                ->setOptionEmpty('SELECIONE')
                                ->setSelectName('dep_responsavel_codigo')
                                ->listOption();
                        ?>

                        <br>
                    </div>
                        
                    <div class="col-xs-3">
                        <label class="text-info">OUTRAS OCORRÊNCIAS:</label>

                        <?php
                        $tbProblemas = new TbProblema();

                        //$tbDepartamento->getAllDepartamentos();

                        $SelectProblema = new SelectOption();

                        $SelectProblema->setStmt($tbProblemas->listarProblemaDepartamento())
                                ->isRequire()
                                ->setClass('form-control')
                                ->setOptionEmpty('SELECIONE')
                                ->setSelectName('pro.pro_codigo')
                                ->listOption();
                        ?>

                        <br>
                    </div>                     
                        
                    <div class="col-xs-9">
                        <label class="text-info">ANEXAR ARQUIVO:</label>
                        <input type="file" id="exampleInputFile">                                                
                    </div>    
                        
                    <div class="col-xs-12">
                        <label class="text-info">AÇÃO IMEDIATA:</label>
                        <textarea class="form-control" rows="3" name="nc_acao_imediata" placeholder="AÇÃO IMEDIATA"
                                  value="<?php echo($_SESSION['rnc']['nc_acao_imediata']); ?>"></textarea>
                        <br>
                    </div>
                                                
                    <div class="container-fluid"> 
                        <div class="col-xs-12 col-xs-offset-10">
                            <button type="submit" class="btn btn-primary"> Gerar</button>
                            <button type="reset" class="btn btn-primary"> Limpar</button>
                        </div>
                    </div>

                </form> 

            </div>
            <div class="panel-footer"></div>
        </div>      
    </div> 
</div>                                                                        
<!-- END QUALIDADE -->

<?php

Sessao::finalizarSessao();

include_once 'componentes/footerRnc.php';
?>