<?php
include_once 'componentes/TopoRnc.php';
?> 

<div class="container-fluid">   
    <div class="col-xs-12">    
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-check"></span> VERIFICAÇÃO</h3>
            </div>
            <div class="panel-body">
                
                <form name="rncVerificacao" method="post" action="action/cadastrarRnc.php">

                <div class="col-xs-12">    
                    <p class="text-primary">EFICAZ ?</p>
                    <div class="col-xs-3">
                        
                        <?php
                        $tbRncEficaz = new TbRncEficaz();

                        $selectDescricao = new SelectOption();

                        $selectDescricao->setStmt($tbRncEficaz->listRncEficaz())
                                ->isRequire()
                                ->setClass('form-control')
                                ->setOptionEmpty('SELECIONE')
                                ->setSelectName('efi_codigo')
                                ->listOption();
                        ?> 
                        
                        <br>
                    </div>                                       
                </div>    

                <div class="col-xs-12">    
                    <p class="text-primary">ENCERRAR NC ?</p>
                    <div class="col-xs-3">
                        
                    
                        <?php
                        $array = array(array(1,'SIM'),
                                       array(2,'NÃO'));
                        
                        $SelectEncerrarNC = new SelectOption();
                        
                        $SelectEncerrarNC->setOptionEmpty('SELECIONE')
                                ->setSelectName('ver_encerrado')
                                ->setStmt($array)
                                ->isRequire(true)
                                ->setClass('form-control')
                                ->listOption();
                        
                        ?>
                        
                        
                    </div>                                       
                </div>                                        
                <div class="col-xs-12">
                    <hr>
                    <label class="text-info">PARECER DA QUALIDADE:</label>
                    <textarea class="form-control" rows="2" name="ver_parecer_qualidade" placeholder="PARECER QUALIDADE"></textarea>                                           
                    <br>
                </div>
                <div class="col-xs-3 col-xs-offset-9">
                    <input class="form-control" id="disabledInput" type="text" name="ver_data_resposta" placeholder="<?php echo date("d-m-Y"); ?>" disabled>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-offset-9 col-sm-10">
                        <br>
                        <button type="submit" class="btn btn-primary"> Finalizar</button>
                        <button type="submit" class="btn btn-primary"> Cancelar</button>
                    </div>
                </div>
                
                </form>    
            </div>
            <div class="panel-footer"></div>
        </div>
    </div>
</div>

<?php
include_once 'componentes/footerRnc.php';
?>