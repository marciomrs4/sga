<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO-8859-1">
        <title>Solicitação de Acesso</title>
        <link rel="stylesheet" href="css/bootstrap/bootstrap.css">
    </head>
    <body>
        <div class="container">
        <div class="col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title" align="center">Solicitação de Acesso</h3>
            </div>
            <div class="panel-body">
                <form role="form-inline" id="formsolicitacaoacesso" method="post" action="SolicitacaoAcessoCreate.php" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xs-6">
                            <label class="control-label" for="nome_solicitante">Nome do Solicitante:</label>
                            <input type="text" name="nome_solicitante" class="form-control" id="nome_solicitante" placeholder="Nome do solicitante">
                        </div>

                        <div class="col-xs-3">
                            <label class="control-label" for="email">E-mail do Solicitante:</label>
                                <input type="text" name="email_solicitante" class="form-control" id="email_solicitante" placeholder="E-mail do solicitante">
                        </div>

                        <div class="col-xs-3">
                            <label class="control-label" for="area">Área do Solicitante:</label>
                            <input type="text" name="cargo_solicitante" class="form-control" id="cargo_solicitante" placeholder="Cargo do solicitante" >
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-xs-3">
                            <label class="control-label" for="nome_usuario" name="">Nome do Usuário:</label>
                            <input type="text" class="form-control" name="nome_usuario" id="nome_usuario" placeholder="Nome do Usuário (Não abreviar)"
                                text="Favor não abreviar o nome do Usuário"  >
                        </div>
                        <div class="col-xs-3">
                            <label class="control-label" for="nome_usuario" name="">Sobre nome:</label>
                            <input type="text" class="form-control" name="sobre_nome_usuario" id="nome_usuario" placeholder="Nome do Usuário (Não abreviar)"
                                   text="Favor não abreviar o nome do Usuário"  >
                        </div>
                        <div class="col-xs-3">
                            <label class="control-label" for="cargo_usuario">Cargo:</label>
                            <input type="text" class="form-control" name="email_usuario" id="email_usuario" placeholder="Cargo do Usuário"  >
                        </div>
                        <div class="col-xs-3">
                            <label class="control-label" for="drt_usuario">DRT:</label>
                            <input type="text" class="form-control drt" name="cargo_usuario" id="cargo_usuario" placeholder="DRT do Usuário">
                            <br>
                        </div>

                        <div class="col-xs-6">
                            <label class="control-label" for="email_usuario">E-mail do Usuário:</label>
                            <input type="email" class="form-control" name="email_usuario" id="email_usuario" placeholder="E-mail do Usuário">
                        </div>
                        <div class="col-xs-3">
                            <label class="control-label" for="unidade_usuario">Unidade:</label>
                            <input type="text" class="form-control" name="unidade_usuario" id="unidade_usuario" placeholder="Unidade do Usuário">
                        </div>
                        <div class="col-xs-3">
                            <label class="control-label" for="ramal_usuario">Ramal do Usuário:</label>
                            <input type="text" class="form-control ramal"  name="ramal_usuario" id="ramal_usuario" placeholder="Ramal do Usuário"  >
                        </div>

                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-xs-6">
                            <label class="control-label" for="tipo_permissao"> Tipo de acesso: </label>
                            <?php
                            $tbTipoSolicitacao = new TbTipoSolicitacaoAcesso();

                            $select = new SelectOption();

                            $select->setStmt($tbTipoSolicitacao->select()->fetchAll(\PDO::FETCH_NUM))
                                   ->setSelectName('soc_codigo')
                                   ->setOptionEmpty('Selecione')
                                   ->setClass('form-control')
                                   ->listOption();

                            ?>

                        </div>
                        <div class="col-xs-6">
                            <label class="control-label" for="tipo_permissao"> Área: </label>
                            <?php
                            $tbDepartamento = new TbDepartamento();

                            $selectDepartamento = new SelectOption();
                            $selectDepartamento->setStmt($tbDepartamento->getAllDepartamentos()->fetchAll(\PDO::FETCH_NUM))
                                               ->setSelectName('soc_codigo')
                                               ->setOptionEmpty('Selecione')
                                               ->setClass('form-control')
                                               ->setSelectedItem($_SESSION['dep_codigo'])
                                               ->listOption();

                            ?>

                        </div>
                    </div>

                    <hr/>

                    <div class="row">
                        <div class="col-xs-5">

                            <select class="form-control"  name="servico[]">
                                <option disabled selected>SELECIONE SERVIÇO...</option>
                                <option value="alterar" >Alteração</option>
                                <option value="bloquear">Bloqueio</option>
                                <option value="desbloquear">Desbloqueio</option>
                                <option value="incluir">Inclusão</option>
                            </select>
                        </div>

                        <div class="col-xs-5">

                            <select class="form-control"  name="perfil[]">
                                <option disabled selected>SELECIONE PERFIL...</option>
                                <option value="alterar" >Alteração</option>
                                <option value="bloquear">Bloqueio</option>
                                <option value="desbloquear">Desbloqueio</option>
                                <option value="incluir">Inclusão</option>
                            </select>
                        </div>

                        <div class="col-xs-2">
                          <button type="button" class="btn btn-default" id="incluir" >Incluir</button>
                        </div>
                    </div>

                    <div id="insercao">

                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-xs-12">
                            <label class="control-label" for="cargo">Observação: </label>
                            <textarea id="obs" name="observacao" class="form-control" rows="3"
                                      placeholder="Especifique (caso necessário) as permissões solicitadas, e/ou coloque neste campo um usuário modelo"></textarea>
                        </div>
                    </div>

                    <hr>

                <div class="row">
                    <div class="col-xs-5">
                        <button type="submit" class="btn btn-primary" > Solicitar </button>
                    </div>
                </div>

            </div>

                </form>
            </div>

            <div class="row">
                <div id="loadform">

                </div>
            </div>

            <div class="panel-footer">..::  &copy CEADIS [Tecnologia da Informação] <?php 
                echo date('Y');?> ::..
            </div>
        </div>
        </div>
        </div> 

        <script src="jscript/jquery-1.11.1.min.js"></script>
        <script src="jscript/my-add-field.js"></script>
<!--        <script src="js/jquery.mask.js"></script>
        <script src="js/validator.js"></script>-->

    </body>
</html>
