<?php
include_once($_SERVER['DOCUMENT_ROOT']."/sga/componentes/config.php");


ControleDeAcesso::permitirAcesso(array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico));

include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/componentes/bootstrap.php");

echo '<div class="jumbotron">';


$busca = new Busca();

$busca->validarPost($_POST);

?>

	<form action="" method="post" id="relatoriosolucao">
		<fieldset>
			<legend>Avaliação de chamados</legend>

			<table border="0">
				<tr>
					<td>
						Período de finalização: de <input type="date" name="data1" class="input-sm" value="<?php echo($busca->getDados('data1'));?>">
						à 			<input type="date" name="data2" class="input-sm" value="<?php echo($busca->getDados('data2'));?>">
					</td>
				</tr>
				<tr>
					<td>
						Problema técnico:
						<?php
						$TbProblema = new TbProblema();

						$FormProblema = new SelectOption();
						$FormProblema->setStmt($TbProblema->listarProblemasTecnicos($_SESSION['dep_codigo']))
							->setOptionEmpty('TODOS')
							->setSelectName('pro_codigo_tecnico')
							->setSelectedItem($busca->getDados('pro_codigo_tecnico'))
							->listOption();

						?>

					</td>

					<td>
						Departamento Solicitante:
						<?php
						$TbDepartamento = new TbDepartamento();

						$FormProblema = new SelectOption();
						$FormProblema->setStmt($TbDepartamento->getAllDepartamentos())
							->setOptionEmpty('TODOS')
							->setSelectName('dep_codigo')
							->setSelectedItem($busca->getDados('dep_codigo'))
							->listOption();

						?>

					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" class="button-tela" id="botaoSave" value="Pesquisar" name="Pesquisar" />
						<span class="botaoSave" style="visibility: hidden"><img src="./css/images/299.GIF"></span>
					</td>
				</tr>

			</table>
		</fieldset>
	</form>
	<br />
<?php
try
{


	$grid = new Grid();

	$cabecalho = array('','Número','Data Inicio','Data Fim','Solicitante','Departamento Solicitante','Problema','Problema Tecnico','','Avaliação','Justificativa');

	$grid->setCabecalho($cabecalho);

	$grid->setDados($busca->listarChamadoRelatorioAvaliacao()->fetchAll(\PDO::FETCH_NUM));

	function convertDate($date)
	{
		$date = new DateTime($date);
		return $date->format('d-m-Y H:i:s');
	}

	$grid->addFunctionColumn('convertDate',1);
	$grid->addFunctionColumn('convertDate',2);


	function formatResult($avaliacao)
	{
		switch ($avaliacao)
		{

			case 1:
				return '<span class="label label-success">&nbsp &nbsp &nbsp &nbsp &nbsp</span>';
				break;

			case 2:
				return '<span class="label label-warning">&nbsp &nbsp &nbsp &nbsp &nbsp</span>';
				break;

			case 3:
				return '<span class="label label-danger">&nbsp &nbsp &nbsp &nbsp &nbsp</span>';
				break;

			case 4:
				return '<span class="label label-default">&nbsp &nbsp &nbsp &nbsp &nbsp</span>';
				break;

			default:
				return '<span class="">ERROR</span>';
				break;
		}




	}

	$grid->addFunctionColumn('formatResult',7);

	$option = new GridOption();
	$option->setIco('edit')->setName('Ver chamado');

	$grid->addOption($option);


	$grid->id = null;


	$Painel = new Painel();
	$Painel->addGrid($grid)
		->setPainelTitle('<a href="#">Resultado <span id="painel-resultado" class="glyphicon glyphicon-resize-small"></span></a>')
		->setPainelColor('default')
		->show();


} catch (Exception $e)
{
	echo $e->getMessage();
}


include_once "GraficoAvaliacaoChamados.php";

Sessao::finalizarSessao();

?>