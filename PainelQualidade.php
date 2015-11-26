<?php
include_once 'componentes/TopoPainelQualidade.php';

$busca = new Busca();

$busca->validarPost($_POST);

$dados['data1'] = $busca->getDados('data_inicial');
$dados['data2'] = $busca->getDados('data_final');

try{

	ValidarDatas::validateDatePeriodo($dados['data1'],$dados['data2']);

}catch(\Exception $e){
	$erro = $e->getMessage();
}

?>

	<div class="container-fluid">
		<div class="col-sm-12">

			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">
						<span class="glyphicon glyphicon-calendar"></span> Filtros
					</h3>
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

						<button type="submit" class="btn btn-default">Pesquisar</button>
					</form>

					<?php
					if($erro){
						?>
						<div class="alert alert-danger" role="alert">
							<?php echo $erro; ?>
						</div>
						<?php
					}
					?>



				</div>
				<div class="panel-footer">
				</div>
			</div>


			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">
						<span class="glyphicon glyphicon-picture"></span>
					</h3>
				</div>
				<div class="panel-body">

					<div class="col-xs-6">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">
									<span class="glyphicon glyphicon-picture"></span>
									Quantidade de RNCs Por Departamento.
								</h3>
							</div>
							<div class="panel-body">
								<div id="graficoRncByDepartamento"></div>
							</div>
							<div class="panel-footer">
							</div>
						</div>
					</div>

					<div class="col-xs-6">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">
									<span class="glyphicon glyphicon-picture"></span>
									Quantidade de RNCs Por Tipo de Ocorrência.
								</h3>
							</div>
							<div class="panel-body">
								<div id="graficoRncByTipoOcorrencia"></div>
							</div>
							<div class="panel-footer">
							</div>
						</div>
					</div>

				</div>
				<div class="panel-footer">
				</div>
			</div>



		</div>
	</div>

<?php
include_once 'componentes/footerPainelQualidade.php';
?>