<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');
include_once 'plugin/MPDF54/mpdf.php';
?>

<link rel='stylesheet' type='text/css' href='../SGA/css/formatacao-niver.css' />


<?php 


/*
$mpdf=new mPDF('', 'Legal');
$mpdf->WriteHTML('<p>Hallo World</p>');
$mpdf->AddPage('L'); // Adds a new page in Landscape orientation
$mpdf->WriteHTML('<p>Hallo World</p>');
$mpdf->Output();
*/


if($_GET)
{

	$busca = new Busca();
	
	$dados['ani_unidade'] = base64_decode($_GET['Unidade']);
	$dados['ani_mes'] = base64_decode($_GET['Mes']); 
	
	$busca->setDados($dados);


try
{

ob_start();
	
  	try
  	{

?>

<div style='margin: 0 auto;'>
	<div class="esquerda">
		<img src="./css/images/baloes.png"><img alt="" src="./css/images/baloes.png">
				<br />
			<span class="niver">Aniversariantes do mês de <?php echo(TbConfigAniversario::checkMes($dados['ani_mes']));?></span>	
			<hr />
	</div>
<?php
  		$grid = new DataGridAniversariantes();

  		$cabecalho = array('DIA','NOME','SETOR');
  		$grid->setCabecalho($cabecalho);

  		$grid->setDados($busca->listarAniversariantePDF());
	  	
		  	
	  	$grid->titulofield = 'Aniversariante(s)';

	  	$grid->islink = false;
	  	$grid->colunaoculta = 1;
	  	$grid->mostrarDatagrid();
	  	
?>


	<div style='float: right;'>			
			<img src="./css/images/bolo.png">			
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

//$mode='',$format='A4',$default_font_size=0,$default_font='',$mgl=15,$mgr=15,$mgt=16,$mgb=16,$mgh=9,$mgf=9, $orientation='P'

///$mpdf = new mPDF('','Legal');

/*

$mpdf = new mPDF('','', 0, '', 5, 5, 1, 1, 1, 1, 'L');

//$mpdf->_setPageSize('A4','L');

//$mpdf->SetHeader(utf8_encode('Emitido em: - '.date("d-m-Y")));


$mpdf->SetAuthor(utf8_encode("Márcio Ramos"));
$css =  file_get_contents('../chamado/css/formatacao-niver.css');


$mpdf->SetHeaderByName('Aniversaritantes do mês');

$mpdf->WriteHTML($css,1);

//$mpdf->setFooter(utf8_encode('Emitido por: '.$_SESSION['usu_nome'] .' '.$_SESSION['usu_sobrenome'].' - Em: '.date("d-m-Y")));



$mpdf->AddPage('L'); #Na posição retrato
$mpdf->WriteHTML(utf8_encode($html),2);

$mpdf->Output();

exit();

*/
}


?>