<!DOCTYPE html>
<html id="print">
    <head>
        <meta charset="ISO-8859-1">
        <title>Solicitação de Acesso</title>
        <link rel="stylesheet" href="css/bootstrap/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap/style-solicitacao-acesso.css">
    </head>
    <body class="size-text">
        <div class="container">
        <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title" title="Clique para realizar a impressão" id="doPrinter" style="cursor: pointer">

                    <div class="panel panel-default">
                        <div class="panel-heading"><span class="glyphicon glyphicon-print"></span> Controle de Acesso à Sistemas e Redes</div>
                        <div class="panel-body">
                            <img src="css/images/solicitacaoacesso.jpg">
                            Chamado: <?php echo $dados->sol_codigo,'
                            | Data de Emissão: ', $dados->sac_datacadastro; ?>
                        </div>
                    </div>

                </h6>

            </div>
            <div class="panel-body">
                <form role="form-inline" method="post" action="receberform.php" enctype="multipart/form-data">
                    <div class="row">

                        <div class="col-xs-4">
                            <label class="control-label" for="area">Área Solicitante:</label>
                            <p>
                                <?php echo($formulario['cargo_solicitante']); ?>
                            </p>
                        </div>

                        <div class="col-xs-4">
                            <label class="control-label" for="nome_solicitante">Nome do Solicitante:</label>
                                <p>
                                    <?php echo($formulario['nome_solicitante']); ?>
                                </p>
                        </div>

                        <div class="col-xs-4">
                            <label class="control-label" for="email">Ramal:</label>
                                <p>
                                    <?php echo($formulario['ramal_solicitante']); ?>
                                </p>
                        </div>


                    </div>

                     <hr class="hr-style">

                    <div class="row">
                        <div class="col-xs-6">
                            <label class="control-label" for="nome_usuario" name="">Nome completo (não abreviar):</label>
                            <p>
                                <?php echo($formulario['nome_usuario']); ?>
                            </p>
                        </div>
                        <div class="col-xs-3">
                            <label class="control-label" for="cargo_usuario">Cargo:</label>
                            <p>
                                <?php echo($formulario['cargo_usuario']); ?>
                            </p>
                        </div>
                        <div class="col-xs-3">
                            <label class="control-label" for="drt_usuario">DRT:</label>
                            <p>
                                <?php echo($formulario['drt_usuario']); ?>
                            </p>
                            <br>
                        </div>

                        <div class="col-xs-3">
                            <label class="control-label" for="unidade_usuario">Unidade:</label>
                            <p>
                                <?php echo($formulario['unidade_usuario']); ?>
                            </p>
                        </div>

                        <div class="col-xs-6">
                            <label class="control-label" for="email_usuario">E-mail:</label>
                            <p>
                                <?php echo($formulario['email_usuario']); ?>
                            </p>
                        </div>

                        <div class="col-xs-3">
                            <label class="control-label" for="ramal_usuario">Ramal:</label>
                            <p>
                                <?php echo($formulario['ramal_usuario']); ?>
                            </p>
                        </div>

                    </div>

                    <hr class="hr-style">

                    <div class="row">
                        <div class="col-xs-5">
                            <label class="control-label" for="tipo_permissao"> Tipo: </label>
                            <p>
                                <?php
                                echo ($tbTipoSolicitacaAcesso->getDescription($formulario['soc_codigo'])); ?>
                            </p>
                        </div>
                        <div class="col-xs-5">
                            <label class="control-label" for="tipo_permissao"> Área: </label>
                            <p>
                                <?php echo($tbDepartamento->getDepDescricao($formulario['dep_codigo'])); ?>
                            </p>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-xs-5">
                            <label class="control-label" for="tipo_permissao"> Servico: </label>
                            <p>
                                <?php

                                //print_r($formulario->servico);

                                foreach($formulario['servico'] as $valor){
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

                                foreach($formulario['perfil'] as $valor){
                                    echo $valor, '<br>';
                                }

                                ?>
                            </p>
                        </div>
                    </div>

                    <hr class="hr-style">

                    <div class="row">
                        <div class="col-xs-12">
                            <label class="control-label" for="cargo">Observações: </label>

                                <?php echo($formulario['observacao']); ?>

                        </div>
                    </div>

                    <hr class="hr-style">

                   <div class="row">
                       <div class="col-xs-3">
                           
                            <div class="panel panel-default">
                                <div class="panel-heading">Solicitante</div>
                                <div class="panel-body">
                                    <br>
                                    <br>
                                </div>
                                <div class="panel-footer">
                                    Data: ___/____/____
                                </div>
                            </div>
                           
                       </div>
                        
                        <div class="col-xs-3">
                            <div class="panel panel-default">
                                <!-- Default panel contents -->
                                <div class="panel-heading">Ger Aprovadora</div>
                                <div class="panel-body">
                                  <br>
                                  <br>
                                </div>
                                <div class="panel-footer">
                                    Data: ___/____/____
                                </div>
                              </div>
                        </div>
                         
                        <div class="col-xs-3">
                            <div class="panel panel-default">
                                <div class="panel-heading">TI - INFRA</div>
                                <div class="panel-body">
                                    <br>
                                    <br>
                                </div>
                                <div class="panel-footer">
                                    Data: ___/____/____
                                </div>
                            </div>
                        </div>
                        
                       <div class="col-xs-3">                        
                            <div class="panel panel-default">
                                <div class="panel-heading">TI - SISTEMAS</div>
                                <div class="panel-body">
                                    <br>
                                    <br>
                                </div>
                                <div class="panel-footer">
                                    Data: ___/____/____
                                </div>
                            </div>
                       </div>
                        
                       </div>
                </form>
            </div>


            <div class="panel-footer" align="center">
                RG.TI.04.001 - CONTROLE DE ACESSO A SISTEMAS E REDES - Rev.03 - 05/08/16
            </div>

        </div>
        </div>
        </div> 

        <script src="jscript/jquery-1.11.1.min.js"></script>
        <script src="jscript/my-printer.js"></script>
    </body>
</html>