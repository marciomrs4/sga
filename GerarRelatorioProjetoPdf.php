<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');
include_once 'plugin/MPDF54/mpdf.php';
?>

<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet'>
<link rel="stylesheet" href="./css/FormatacaoRelatorio.css">

<?php
if($_GET)
{

	$busca = new Busca();
		
	$busca->setValueGet($_GET,'pro_codigo');

	//echo $busca->getValueGet('pro_codigo');
	
	$dados = $busca->getRelatorioProjetoPDF();
	
	$tbUsuario = new TbUsuario();
	$User = $tbUsuario->getUsuario($dados['usu_codigo_solicitante']);


try
{

ob_start();
	
try
{

?>
<div id="container">
<img src="../sga/css/images/logoRelatorio.png"> 
<hr>
<div id="global">

<h3 style="margin-left: 5px;">Projeto: <?php echo($dados['pro_titulo']); ?></h3>


		<div id="infoprojeto">
			<h3>Informações do Projeto</h3>
			<span>Solicitante:</span> <?php echo($User['usu_nome'].' '.$User['usu_sobrenome']);?>
			- <span>Previsão de Inicio:</span> <?php echo(ValidarDatas::dataCliente($dados['pro_previsao_inicio']));?><br />
			<span>Descrição:</span> <?php echo($dados['pro_descricao']);?><br/>			
		</div>
	<div id="infocliente">
	<h3 style="color: white; text-align: center; background-color: #43acd7; padding: 10px;">ATIVIDADES</h3>
	<?php 
		$tbAtividade = new TbAtividade();
		
		$Atividades = $tbAtividade->listarAtividadeProjeto($dados['pro_codigo']);
		
		foreach ($Atividades as $atividade):
	?>	
	<div id="atividade">
		<span style="color: ff4500;">Número Atividade:</span> <?php echo($atividade['at_codigo']);?>
		- <span>Usuário:</span> <?php echo($atividade['Usuario']);?>
		- <span>Data de Incio:</span> <?php echo($atividade['Inicio']);?>
		- <span>Data de Conclusão:</span> <?php echo($atividade['Fim']);?>		
		- <span>Status:</span> <?php echo($atividade['Status']);?><br />		
		<span>Descrição:</span> <?php echo($atividade['at_descricao']);?>						
		
		<?php 
		$tbApontamento = new TbApontamento();
		$Apontamentos = $tbApontamento->listarApontamento($atividade['at_codigo']);
		foreach ($Apontamentos as $apontamento):
		?>
		<div id="apontamento">
			<span style="color: #43acd7; text-decoration: underline;">Apontamento:</span><br />
			<span>Número Apontamento:</span> <?php echo($apontamento['ap_codigo']);?>
			- <span>Usuário:</span> <?php echo($apontamento['Usuario']);?>
			- <span>Data do Apontamento:</span> <?php echo($apontamento['Data']);?>
			<br />
			<span>Descrição:</span> <?php echo($apontamento['Descricao']);?>		
			<br />
		</div>
	
		<?php 
		endforeach;
		?>
		</div>	
		<br />
<?php endforeach; ?>
	</div>
	
	
	<div id="anotacoes">
		<h4>Anotações:</h4>	
	</div>
	
</div>
<br>
<?php 
include 'componentes/rodape.php';
?>
</div>

<?php 	  	
  	}catch (Exception $e)
  	{
  		echo $e->getMessage();
  	}

	
}catch (Exception $e)
{
	echo Texto::erro($e->getMessage());
}


$html = ob_get_clean();



echo $html;

/*
//$mode='',$format='A4',$default_font_size=0,$default_font='',$mgl=15,$mgr=15,$mgt=16,$mgb=16,$mgh=9,$mgf=9, $orientation='P'

$mpdf = new mPDF();

//$mpdf = new mPDF('','', 0, '', 5, 5, 1, 1, 1, 1, 'P');

//$mpdf->_setPageSize('A4','L');

//$mpdf->SetHeader(utf8_encode('Emitido em: - '.date("d-m-Y")));


$mpdf->SetAuthor(utf8_encode("Márcio Ramos"));
$css =  file_get_contents('../sga/css/FormatacaoRelatorio.css');


$mpdf->SetHeaderByName('PROJETOS');

$mpdf->WriteHTML($css,1);

$mpdf->setFooter(utf8_encode('Emitido por: '.$_SESSION['usu_nome'] .' '.$_SESSION['usu_sobrenome'].' - Em: '.date("d-m-Y")));



//$mpdf->AddPage('L'); #Na posição retrato

$mpdf->WriteHTML(utf8_encode($html),2);

$mpdf->Output();

exit();
*/
}



?>

















