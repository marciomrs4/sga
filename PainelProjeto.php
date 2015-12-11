<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');
$ControleAcesso = new ControleDeAcesso();
$ControleAcesso->permitirAcesso(array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico));
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.1//EN' 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='application/xhtml+xml; charset=ISO-8859-1' />
<title>..:: Painel Diário ::..</title>
<link rel='stylesheet' type='text/css' href='../sga/css/PainelChamados.css' />
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet'>
<script	language="JavaScript" src="../ticontrole/jscript/jquery-1.5.js"></script>
<script language="JavaScript" src="../ticontrole/jscript/jquery.tablesorter.js"></script>
	
<script type="text/javascript">
$(document).ready(function(){

	 $(".tabela").tablesorter(); 
	
	$("#tempo").css("color","red");
	
var x = 0;
	for(x = 0; x <= 1; x++)
	{
		$("#emrecebimento").fadeOut("slow");
		$("#emrecebimento").fadeIn("slow");
	}

});

var count = 60; // O tempo para refresh em segundos

function timer()
{
	$("#tempo").html(count);
	
	if(count > 1)

count--;

else
	
	window.location.href = "<?php echo($_SERVER['REQUEST_URI']);?>"; 

	setTimeout("timer();", 1000);
}


</script>

<script>
timer();
</script>
</head>	
<body>

<div id="container">

<div id="topo">
<a href="Relatorio.php">Voltar</a>
	<h2>Painel de Projetos | <?php echo(date('d-m-Y H:i:s'));?></h2>
</div>

<div id="topo2">
	<?php
		#Obetem o departamento do usu?rio 
		$dados['dep_codigo'] = ($_SESSION['dep_codigo'] == '') ? $_GET['dep_codigo'] : $_SESSION['dep_codigo'];

		$tbProjeto = new TbProjeto();

		$dados['stp_codigo'] = '%';
		$ProjetosTotal = $tbProjeto->totalProjetosStatusPainel($dados);
		
		$dados['stp_codigo'] = 2;
		$ProjetosEmAndamento = $tbProjeto->totalProjetosStatusPainel($dados);
		
		?>	

	<h3 id="emrecebimento">Total de Projeto(s): <?php echo($ProjetosTotal[0]); ?> e <?php echo($ProjetosEmAndamento[0]); ?> Em Andamento</h3>
</div>

<div id="painelcentral">

<div id="painel1">

<?php 

$nomelink = '&raquo;';
$link = 'GerarRelatorioProjetoPdf.php?codigo';
$cabecalho = array('Projeto','Atividade','<a href="#">Data</a>','<a href="#">Dias</a>');

echo("<fieldset id='completo'>
		<legend id='nome'>Aprova??o</legend>");
		
		
		$DataGrid = new DataGrid();
		
		#status Aprovacao 1
		$dados['stp_codigo'] = 1;
		$DataGrid->setDados($tbProjeto->listarProjetosPainel($dados));
		$DataGrid->setCabecalho($cabecalho);
		$DataGrid->nomelink = $nomelink;
		$DataGrid->link = $link;
		$DataGrid->colunaoculta = 1;
		$DataGrid->mostrarDatagrid(1);
		
		echo("</fieldset>");
		
echo("<fieldset id='completo'>
		<legend id='nome'>Em Andamento</legend>");
		
		$DataGrid = new DataGrid();
		
		$dados['stp_codigo'] = 2;
		$DataGrid->setDados($tbProjeto->listarProjetosPainel($dados));
		$DataGrid->setCabecalho($cabecalho);
		$DataGrid->nomelink = $nomelink;
		$DataGrid->link = $link;
		$DataGrid->colunaoculta = 1;
		$DataGrid->mostrarDatagrid(1);
		
		echo("</fieldset>");
		
echo("<fieldset id='completo'>
		<legend id='nome'>Paralizado</legend>");
		
		$DataGrid = new DataGrid();
		
		$dados['stp_codigo'] = 5;
		$DataGrid->setDados($tbProjeto->listarProjetosPainel($dados));
		$DataGrid->setCabecalho($cabecalho);
		$DataGrid->nomelink = $nomelink;
		$DataGrid->link = $link;
		$DataGrid->colunaoculta = 1;
		$DataGrid->mostrarDatagrid(1);
		
		echo("</fieldset>");		
		
?>
	
	
	
</div>

</div>
</div>
</body>
</html>