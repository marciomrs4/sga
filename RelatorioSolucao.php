<?php
include_once($_SERVER['DOCUMENT_ROOT']."/SGA/componentes/config.php");


ControleDeAcesso::permitirAcesso(array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico));

include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/componentes/bootstrap.php");
 
echo '<div class="jumbotron">';




$busca = new Busca();

$busca->validarPost($_POST);


$cabecalho = array('','Número','Data Inicio','Data Fim','Tempo','Departamento',$_SESSION['config']['usuario'] .' Solicitante',
				   'Problema Tecnico','SLA Tecnico','Status','Prioridade','SLA Atendimento','Atendente',
				   'DIFF - Tecnico','Tempo Util',' SLA ','Status');

?>

<form action="" method="post" id="relatoriosolucao">
<fieldset>
	<legend>Pesquisar Chamado</legend>
<table border="0">
	<tr>	
		<td>
			Status:
			<?php 
		    $tbStatus = new TbStatus();
		    FormComponente::$name = 'TODOS';
		    FormComponente::selectOption('sta_codigo',$tbStatus->selectStatus(),true,$busca->getDados('sta_codigo'));
		    ?>
		    
		    Prioridade: 
		    <?php 
		    
		    $tbPrioridade = new TbPrioridade();
		    FormComponente::$name = 'TODOS';
		    $prioridade['pri_codigo'] = $busca->getDados('pri_codigo');
		    FormComponente::selectOption('pri_codigo',$tbPrioridade->selectPrioridadesDepartamento($_SESSION['dep_codigo']),true,$prioridade);
		    
		    ?>
		    
		    Usuário:
		    <?php 
		    $tbUsuario = new TbUsuario();
		    FormComponente::$name = 'TODOS';
		    $codigo_atendente['usu_codigo_atendente'] = $busca->getDados('usu_codigo_atendente');
		    FormComponente::selectOption('usu_codigo_atendente',$tbUsuario->selectUsuarioPorDepartamento($_SESSION['dep_codigo']),true,$codigo_atendente);		    
		    
		    ?>
		    	
		Período: De <input type="text" name="data1" class="data" id="data-id" size="10" value="<?php echo($busca->getDados('data1'));?>">
		à 			<input type="text" name="data2" class="data" id="data" size="10" value="<?php echo($busca->getDados('data2'));?>">
		</td>				
		
	</tr>
	<tr>
		
		<td>
		 Horário de trabalho Inicio:
		 		  <input type="text" name="hora_ini" class="doisdigitos" size="3" value="<?php echo($busca->getDados('hora_ini'));?>">
		 		à <input type="text" name="hora_fim" class="doisdigitos" size="3" value="<?php echo($busca->getDados('hora_fim'));?>">

		Almoço: <input type="text" name="meio_dia" class="doisdigitos" size="3" value="<?php echo($busca->getDados('meio_dia'));?>">

		Carga horária de Sábado: <input type="text" name="sabado" class="doisdigitos" size="3" value="<?php echo($busca->getDados('sabado'));?>">		
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
	

	$diaUtil = new dateOpers();
	
	$grid = new Grid();
	
	//$grid->id = null;
	
	$grid->setCabecalho($cabecalho);
	
	$grid->setDados($busca->listarChamadoPorTempoDeSolucao());
	
	
	$grid->addFunctionColumn(function ($var) use ($diaUtil, $busca)
	{
		$data = explode('|', $var);
		
		$data1 = trim($data['0']);
		$data2 = trim($data['1']);
		
		#Hora Inicial
		$hora_ini = $busca->getDados('hora_ini');
		#Hora Final
		$hora_fim = $busca->getDados('hora_fim');
		
		#Até o esse horario do almoço
		$meio_dia = $busca->getDados('meio_dia');
		#Horas de sabados
		$sabado   = $busca->getDados('sabado');
		
		#Tipo de Saida em horas
		$saida    = 'H';
		
		return $diaUtil->tempo_valido($data1, $data2, $hora_ini, $hora_fim, $meio_dia, $sabado, $saida);
		
		
	}, 13);

$option = new GridOption();
$option->setIco('edit')->setName('Ver chamado')->setUrl('?sol_codigo');

$grid->addOption($option);


function getHourToSecunds($hora)
{
	$horaParte = explode(':', $hora);

	$horasEmSegundo = ($horaParte['0'] * 3600) + ($horaParte['1'] * 60) + $horaParte['2'];

	return $horasEmSegundo;
}



$grid->addFunctionColumn(function($var) use ($diaUtil, $busca){

	global $totalChamado, $chamadoDentro, $chamadoFora;
	
	$chamadoDentro = ($chamadoDentro == 0) ? 0 : $chamadoDentro;
	$chamadoFora = ($chamadoFora == 0) ? 0 : $chamadoFora;
	
	$tempo =explode('|', $var);
	
	$data1 = trim($tempo['0']);
	$data2 = trim($tempo['1']);
	
	$tempoProblema = trim($tempo['2']);
	
	#Hora Inicial
	$hora_ini = $busca->getDados('hora_ini');
	#Hora Final
	$hora_fim = $busca->getDados('hora_fim');
		
	#Até o esse horario do almoço
	$meio_dia = $busca->getDados('meio_dia');
	#Horas de sabados
	$sabado   = $busca->getDados('sabado');
		
	#Tipo de Saida em horas
	$saida    = 'H';
	
	$horaUtil = $diaUtil->tempo_valido($data1, $data2, $hora_ini, $hora_fim, $meio_dia, $sabado, $saida);
	
	#Converte para secundos as horas 
	$horaUtil = getHourToSecunds($horaUtil);
	$tempoProblema = getHourToSecunds($tempoProblema);
	
 	if($horaUtil <= $tempoProblema){
		
		$totalChamado++;
		$chamadoDentro++;
		
		return 'Chamado Dentro <td><img src="css/images/status/face.png"></td>';

	}else {
		$totalChamado++;
		$chamadoFora++;
		return 'Chamado Fora <td><img src="css/images/status/face2.png"></td>';
}
	
	
}, 14);


$grid->id = null;


$grid->show(); 

			
} catch (Exception $e) 
{
	echo $e->getMessage();
}


include_once "GraficoTempoSolucaoMontagem.php";

Sessao::finalizarSessao();

?>