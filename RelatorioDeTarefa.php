<?php
include_once($_SERVER['DOCUMENT_ROOT']."/sga/componentes/config.php");

ControleDeAcesso::permitirAcesso(array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico));

include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/componentes/bootstrap.php");

$busca = new Busca();

$busca->validarPost($_POST);

$cabecalho = array('Tarefa','Data','Usuário');

?>
<div class="jumbotron">

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Pesquisar Lista de Tarefas</h3>
    </div>
    <div class="panel-body">

    <form class="form-inline" action="" method="post">
        <div class="form-group">
            <label for="exampleInputEmail3">Data Inicial:</label>
            <input type="date" name="data_inicial" class="form-control" id="exampleInputEmail3" value="<?php echo $busca->getDados('data_inicial'); ?>" required>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword3">Data Final:</label>
            <input type="date" name="data_final" class="form-control" id="exampleInputPassword3" value="<?php echo $busca->getDados('data_final'); ?>" required>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword3">Usuário:</label>
                <?php
                $selectOption = new SelectOption();
                $usuario = new TbUsuario();
                $selectOption->setClass('form-control')
                             ->setOptionEmpty('Todos...')
                             ->setSelectedItem($busca->getDados('usu_codigo'))
                             ->setSelectName('usu_codigo')
                             ->setStmt($usuario->selectUsuarioPorDepartamento($_SESSION['dep_codigo']))
                             ->listOption();

                ?>
        </div>
        <button type="submit" class="btn btn-default">Pesquisar</button>
        <?php
        $dataExporta = new DataGrid();
        $dataExporta->setCabecalho($cabecalho);
        $dataExporta->exportarExcel('ListaDeTarefa','getRelatorioTarefa');

        $export = ($busca->getDados('Metodo') == 'getRelatorioTarefa') ? '
        <a href="GerarExcel.php" title="Clique para exportar"><span class="glyphicon glyphicon-save">Exportar </span></a> |' : '';

        ?>
    </form>
    </div>
    <div class="panel-footer">
        <?php
            echo $export;
        ?>
        <a href="#" title="Clique para inserir filtros" class="filter"><span class="glyphicon glyphicon-filter">Filtrar</span><a/>
    </div>
</div>


<?php
try
{

    $grid = new Grid();

    $grid->setCabecalho($cabecalho);

    $grid->setDados($busca->getRelatorioTarefa()->fetchAll(\PDO::FETCH_NUM));



    $Painel = new Painel();
    $Painel->addGrid($grid)
        ->setPainelTitle('Resultado')
        ->setPainelColor('default')
        ->show();


} catch (\Exception $e)
{
    echo $e->getMessage();
}


Sessao::finalizarSessao();

?>
</div>
<footer>
    <nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
        <p class="navbar-text"><b>..::  &copy CEADIS [Tecnologia da Informação] 2015 ::..</b></p>

        <div class="nav navbar-right collapse navbar-collapse">

        </div>

    </nav>
    <nav class="navbar"></nav>
</footer>

<script src="jscript/jquery-2.1.4.js"></script>
<script src="jscript/bootstrap.js"></script>
<script src="jscript/jquery.dataTables.js"></script>
<script src="jscript/my-datatable-doubleclick.js"></script>

</body>
</html>