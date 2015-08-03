<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.1//EN' 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='application/xhtml+xml; charset=ISO-8859-1' />
<title>..:: Painel Diário ::..</title>
<link rel='stylesheet' type='text/css' href='../sga/css/PainelChamados.css' />
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet'>
<script	language="JavaScript" src="../sga/jscript/jquery-1.11.1.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){

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

<div id="topo">
<a href="Relatorio.php">Voltar</a>
	<h2>Painel de Chamados  | <?php echo(date('d-m-Y H:i:s'));?></h2>
</div>

<div id="topo2">
	<?php
	
		$dados['dep_codigo'] = ($_SESSION['dep_codigo'] == '') ? $_GET['dep_codigo'] : $_SESSION['dep_codigo'];

		$tbSolicitacao = new TbSolicitacao();
		$dados['sta_codigo'] = 1;
		$TotalEmAberto = $tbSolicitacao->totalChamadoStatusAreaPainel($dados);

		$dados['sta_codigo'] = 2;
		$TotalEmAtendimento = $tbSolicitacao->totalChamadoStatusAreaPainel($dados);
		
		$dados['data1'] = date('Y-m-d').' 00:00:01';
		$dados['data2'] = date('Y-m-d').' 23:59:59';		
		$dados['sta_codigo'] = 3;
		$_SESSION['dep_codigo'] = $dados['dep_codigo']; 
		$TotalConcluidos = $tbSolicitacao->totalChamadoFechadosDoDia($dados);
		
		?>	

	<h3 id="emrecebimento">Total de Chamado(s): <?php echo($TotalEmAberto[0]); ?> Em Aberto, 
		<?php echo($TotalEmAtendimento[0]); ?> Em Atendimento e <?php echo($TotalConcluidos); ?> Concluídos hoje</h3>
</div>

<div id="painelcentral">

<div id="painel1">

<?php 

$tbUsuario = new TbUsuario();
$dados['sta_codigo'] = 2;

$nomelink = '&raquo;';


foreach ($tbUsuario->listarUsuariosPainel($dados) as $valores):

echo("<fieldset id='completo'>
		<legend id='nome'>$valores[2]</legend>");

		$tbAtendenteSolicitacao = new TbAtendenteSolicitacao();
		
		$dados['usu_codigo_atendente'] = $valores[0];
		
		
		$DataGrid = new DataGrid();
		
		$DataGrid->setDados($tbAtendenteSolicitacao->listarSolicitacaoPainel($dados));
		$DataGrid->setCabecalho(array('Número','Usúario','Dias','SLA'));
		$DataGrid->nomelink = $nomelink;
        $DataGrid->link = './GerarRelatorioPdf.php';
        $DataGrid->acao = 'sol_codigo';
		$DataGrid->colunaoculta = 0;

		$DataGrid->mostrarDatagrid(1);
		
		echo("</fieldset>");
		
endforeach;
?>
	
</div>


<!-- 
<div id="painel3">
	<fieldset id="emrecebimento">
		<legend>Total em Atendimento</legend>
		</fieldset>
	<fieldset id="chamadoaberto">
		<legend>Total em Aberto</legend>
		<?php 
		$tbSolicitacao = new TbSolicitacao();
		$dados['sta_codigo'] = 1;
		$Total = $tbSolicitacao->totalChamadoStatusAreaPainel($dados);
		echo('<h2>'.$Total[0].' Chamado(s)</h2>');
		?>
	</fieldset>	
</div>
 -->

</div>
</body>
</html>