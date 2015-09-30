<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

$ControleAcesso = new ControleDeAcesso();
$ControleAcesso->permitirAcesso(array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico,$ControleAcesso::$Solicitante));

$tbDepartamento = new TbDepartamento();

$tbUsuario = new TbUsuario();
$DataUsers = $tbUsuario->getUsuario($_SESSION['usu_codigo']);

/*echo '<pre>';
print_r($_SESSION);
echo '</pre>';*/

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
                <form role="form-inline" id="formsolicitacaoacesso" method="post" action="action/solicitacaodeacesso.php" enctype="multipart/form-data">
                    <div class="row">

                        <div class="col-xs-3">
                            <label class="control-label" for="area">Área Solicitante:</label>
                            <input type="text" name="cargo_solicitante" value="<?php echo($tbDepartamento->getDepDescricao($_SESSION['dep_codigo'])); ?>"
                                   class="form-control" id="cargo_solicitante" placeholder="Cargo do solicitante" required>
                        </div>

                        <div class="col-xs-6">
                            <label class="control-label" for="nome_solicitante">Nome do Solicitante:</label>
                            <input type="text" name="nome_solicitante" minlength="3" value="<?php echo($DataUsers['usu_nome'] .' '.$DataUsers['usu_sobrenome'] ); ?>"
                                   class="form-control" id="nome_solicitante" placeholder="Nome do solicitante" required>
                        </div>

                        <div class="col-xs-3">
                            <label class="control-label" for="email">Ramal:</label>
                                <input type="text" name="ramal_solicitante" value="<?php echo($DataUsers['usu_ramal']); ?>"
                                       class="form-control" id="email_solicitante" placeholder="E-mail do solicitante" required>
                        </div>

                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-xs-6">
                            <label class="control-label" for="nome_usuario" name="">Nome completo (não abreviar):</label>
                            <input type="text" class="form-control" name="nome_usuario" id="nome_usuario" placeholder="Nome do Usuário (Não abreviar)"
                                text="Favor não abreviar o nome do Usuário"  required>
                        </div>

                        <div class="col-xs-3">
                            <label class="control-label" for="cargo_usuario">Cargo:</label>
                            <input type="text" class="form-control" name="cargo_usuario" id="cargo_usuario" placeholder="Cargo do Usuário"  required>
                        </div>
                        <div class="col-xs-3">
                            <label class="control-label" for="drt_usuario">DRT:</label>
                            <input type="number" class="form-control drt" name="drt_usuario" id="drt_usuario" placeholder="DRT do Usuário" required>
                            <br>
                        </div>

                        <div class="col-xs-3">
                            <label class="control-label" for="unidade_usuario">Unidade:</label>
                            <input type="text" class="form-control" name="unidade_usuario" id="unidade_usuario" placeholder="Unidade do Usuário" required>
                        </div>

                        <div class="col-xs-6">
                            <label class="control-label" for="email_usuario">E-mail:</label>
                            <input type="email" class="form-control" name="email_usuario" id="email_usuario" placeholder="E-mail do Usuário">
                        </div>

                        <div class="col-xs-3">
                            <label class="control-label" for="ramal_usuario">Ramal:</label>
                            <input type="text" class="form-control ramal"  name="ramal_usuario" id="ramal_usuario" placeholder="Ramal do Usuário"  >
                        </div>

                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-xs-6">
                            <label class="control-label" for="tipo_permissao"> Tipo: </label>
                            <?php
                            $tbTipoSolicitacao = new TbTipoSolicitacaoAcesso();

                            $select = new SelectOption();

                            $select->setStmt($tbTipoSolicitacao->select()->fetchAll(\PDO::FETCH_NUM))
                                   ->setSelectName('soc_codigo')
                                   ->setOptionEmpty('Selecione')
                                   ->setClass('form-control')
                                   ->isRequire(true)
                                   ->listOption();

                            ?>

                        </div>
                        <div class="col-xs-6">
                            <label class="control-label" for="tipo_permissao"> Área: </label>
                            <?php


                            $selectDepartamento = new SelectOption();
                            $selectDepartamento->setStmt($tbDepartamento->getAllDepartamentos()->fetchAll(\PDO::FETCH_NUM))
                                               ->setSelectName('dep_codigo')
                                               ->setOptionEmpty('Selecione')
                                               ->setClass('form-control')
                                               ->setSelectedItem($_SESSION['dep_codigo'])
                                               ->isRequire(true)
                                               ->listOption();

                            ?>

                        </div>
                    </div>

                    <hr/>

                    <div class="row">
                        <div class="col-xs-5">
                            <label class="control-label">Servico:</label>

                            <?php
                            $tbServico = new TbServico();

                            $selectServico = new SelectOption();

                            $selectServico->setStmt($tbServico->select()->fetchAll(\PDO::FETCH_NUM))
                                ->setSelectName('servico')
                                ->setOptionEmpty('Selecione')
                                ->setClass('form-control')
                                ->isRequire(true)
                                ->listOption();

                            ?>
                        </div>

                        <div class="col-xs-5">
                            <label class="control-label">Perfil:</label>
                            <select name="perfil" class="form-control" required>

                            </select>
                        </div>

                        <div class="col-xs-2">
                          <button type="button" class="btn btn-default" id="incluir" ><span class="glyphicon glyphicon-plus"></span> Adicionar</button>
                        </div>
                    </div>
                    <hr>

                    <div class="panel panel-default">
                        <div class="panel panel-heading">
                            <h3 class="panel-title">Permissões de Acessos</h3>
                        </div>
                        <div class="panel panel-body">
                            <div id="insercao">

                            </div>
                        </div>
                        <div class="panel-footer"></div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <label class="control-label" for="cargo">Observações: </label>
                            <textarea id="obs" name="observacao" class="form-control" rows="3"
                                      placeholder="Especifique (caso necessário) as permissões solicitadas, e/ou coloque neste campo um usuário modelo"></textarea>
                        </div>
                    </div>

                    <hr>

                <div class="row">
                    <div class="col-xs-5">
                        <button type="submit" onclick="validarPermissoes()" class="btn btn-primary" ><span class="glyphicon glyphicon-floppy-open"></span> Solicitar </button>
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
