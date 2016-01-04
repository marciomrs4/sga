<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');
include_once 'plugin/MPDF54/mpdf.php';
?>

<link rel="stylesheet" href="./css/FormatacaoRelatorio.css">

<?php
if($_GET)
{

	$busca = new Busca();
		
	$busca->setValueGet($_GET,'at_codigo');
	
	$atividade = $busca->getRelatorioAtividadePDF();
	
	

try
{

ob_start();
	
try
{

?>


<div id="global">

	<img src="../sga/css/images/logoRelatorio.png">
	<span style="font-size: 24px;">Informa��es da Atividade</span>

		<div id="infoprojeto">
			<span>N�mero:</span> <?php echo($atividade['at_titulo']);?>
			- <span>Executor:</span> <?php echo($atividade['Usuario']);?>
			- <span>Previs�o de Inicio:</span> <?php echo($atividade['Inicio']);?>
			- <span>Previs�o de Fim:</span> <?php echo($atividade['Fim']);?>		
			- <span>Status:</span> <?php echo($atividade['Status']);?><br />						
			<span>Descri��o:</span> <?php echo($atividade['at_descricao']);?><br/>			
		</div>
	<div id="infocliente">
	<h3 style="color: #0000CD;">APONTAMENTOS</h3>
	<?php 

		$tbApontamento = new TbApontamento();
		$Apontamentos = $tbApontamento->listarApontamento($atividade['at_codigo']);
		foreach ($Apontamentos as $apontamento):
		?>
		<div id="apontamento">
			<span style="color: #00008B;">Apontamento:</span><br />
			<span>N�mero Apontamento:</span> <?php echo($apontamento['ap_codigo']);?>
			- <span>Usu�rio:</span> <?php echo($apontamento['Usuario']);?>
			- <span>Data do Apontamento:</span> <?php echo($apontamento['Data']);?>
			<br />
			<span>Descri��o:</span> <?php echo($apontamento['Descricao']);?>		
			<br />
		</div>
	
		<?php 
		endforeach;
		?>
		</div>	

	
	<div id="anotacoes">
		<h5>Anota��es:</h5>
	
	</div>
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

$mpdf = new mPDF('','', 0, '', 5, 5, 1, 1, 1, 1, 'P');

//$mpdf->_setPageSize('A4','L');

//$mpdf->SetHeader(utf8_encode('Emitido em: - '.date("d-m-Y")));


$mpdf->SetAuthor(utf8_encode("M�rcio Ramos"));
$css =  file_get_contents('../sga/css/FormatacaoRelatorio.css');


$mpdf->SetHeaderByName('PROJETOS');

$mpdf->WriteHTML($css,1);

$mpdf->setFooter(utf8_encode('Emitido por: '.$_SESSION['usu_nome'] .' '.$_SESSION['usu_sobrenome'].' - Em: '.date("d-m-Y")));



//$mpdf->AddPage('L'); #Na posi��o retrato

$mpdf->WriteHTML(utf8_encode($html),2);

$mpdf->Output();

exit();
*/
}
?>