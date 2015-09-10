<!DOCTYPE html>
<html id="print">
    <head>
        <meta charset="ISO-8859-1">
        <title>Solicitação de Acesso</title>
        <link rel="stylesheet" href="css/bootstrap/bootstrap.css">
    </head>
    <body>
        <nav class="navbar">
        </nav>
        <div class="container">
        <div class="col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title" title="Clique para realizar a impressão" id="doPrinter" style="cursor: pointer">
                    <span class="glyphicon glyphicon-print"></span>
                    Solicitação de Acesso: <?php echo '#',$chamado,' - ', $dados->data_cadastrado; ?></h3>
            </div>
            <div class="panel-body">
                <form role="form-inline" method="post" action="receberform.php" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xs-6">
                            <label class="control-label" for="nome_solicitante">Nome do Solicitante:</label>
                                <p>
                                    <?php echo($formulario->nome_solicitante); ?>
                                </p>
                        </div>

                        <div class="col-xs-3">
                            <label class="control-label" for="email">E-mail:</label>
                                <p>
                                    <?php echo($formulario->email_solicitante); ?>
                                </p>
                        </div>

                        <div class="col-xs-3">
                            <label class="control-label" for="area">Área do Solicitante:</label>
                            <p>
                                <?php echo($formulario->cargo_solicitante); ?>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-xs-3">
                            <label class="control-label" for="nome_usuario" name="">Nome do Usuário:</label>
                            <p>
                                <?php echo($formulario->nome_usuario); ?>
                            </p>
                        </div>
                        <div class="col-xs-3">
                            <label class="control-label" for="nome_usuario" name="">Sobre nome:</label>
                            <p>
                                <?php echo($formulario->sobre_nome_usuario); ?>
                            </p>
                        </div>
                        <div class="col-xs-3">
                            <label class="control-label" for="cargo_usuario">Cargo:</label>
                            <p>
                                <?php echo($formulario->email_usuario); ?>
                            </p>
                        </div>
                        <div class="col-xs-3">
                            <label class="control-label" for="drt_usuario">DRT:</label>
                            <p>
                                <?php echo($formulario->cargo_usuario); ?>
                            </p>
                            <br>
                        </div>

                        <div class="col-xs-6">
                            <label class="control-label" for="email_usuario">E-mail do Usuário:</label>
                            <p>
                                <?php echo($formulario->email_usuario); ?>
                            </p>
                        </div>
                        <div class="col-xs-3">
                            <label class="control-label" for="unidade_usuario">Unidade:</label>
                            <p>
                                <?php echo($formulario->unidade_usuario); ?>
                            </p>
                        </div>
                        <div class="col-xs-3">
                            <label class="control-label" for="ramal_usuario">Ramal do Usuário:</label>
                            <p>
                                <?php echo($formulario->ramal_usuario); ?>
                            </p>
                        </div>

                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-xs-5">
                            <label class="control-label" for="tipo_permissao"> Tipo: </label>
                            <p>
                                <?php echo($formulario->tipo); ?>
                            </p>
                        </div>
                        <div class="col-xs-5">
                            <label class="control-label" for="tipo_permissao"> Área: </label>
                            <p>
                                <?php echo($formulario->area); ?>
                            </p>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-xs-5">
                            <label class="control-label" for="tipo_permissao"> Servico: </label>
                            <p>
                                <?php

                                //print_r($formulario->servico);

                                foreach($formulario->servico as $valor){
                                    echo $valor, '<br>';
                                }

                                ?>
                            </p>
                        </div>
                        <div class="col-xs-5">
                            <label class="control-label" for="tipo_permissao"> Perfil: </label>
                            <p>
                                <?php

                                //print_r($formulario->perfil);

                                foreach($formulario->perfil as $valor){
                                    echo $valor, '<br>';
                                }

                                ?>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-xs-12">
                            <label class="control-label" for="cargo">Observação: </label>

                                <?php echo($formulario->observacao); ?>

                        </div>
                    </div>

                    <hr>

                   <div class="row">
                       <div class="col-xs-3">
                           
                            <div class="panel panel-primary">
                                <div class="panel-heading">Solicitante</div>
                                <div class="panel-body" rows="3">
                                    <br>
                                    <br>
                                </div>
                                <div class="panel-footer">
                                    Data: __/__/____
                                </div>
                            </div>
                           
                       </div>
                        
                        <div class="col-xs-3">
                            <div class="panel panel-primary">
                                <!-- Default panel contents -->
                                <div class="panel-heading">Ger Aprovadora</div>
                                <div class="panel-body">
                                  <br>
                                  <br>
                                </div>
                                <div class="panel-footer">
                                    Data: __/__/____
                                </div>
                              </div>
                        </div>
                         
                        <div class="col-xs-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">TI - INFRA</div>
                                <div class="panel-body" rows="3">
                                    <br>
                                    <br>
                                </div>
                                <div class="panel-footer">
                                    Data: __/__/____
                                </div>
                            </div>
                        </div>
                        
                       <div class="col-xs-3">                        
                            <div class="panel panel-primary">
                                <div class="panel-heading">TI - SISTEMAS</div>
                                <div class="panel-body" rows="3">
                                    <br>
                                    <br>
                                </div>
                                <div class="panel-footer">
                                    Data: __/__/____
                                </div>
                            </div>
                       </div>
                        
                       </div>
                </form>
            </div>


            <div class="panel-footer">
                RG.TI.04.001 ? CONTROLE DE ACESSO A SISTEMAS E REDES ? Rev.02 ? 10/08/15
            </div>

        </div>
        </div>
        </div> 

        <script src="jscript/jquery-1.11.1.min.js"></script>
        <script src="jscript/my-printer.js"></script>
    </body>
</html>