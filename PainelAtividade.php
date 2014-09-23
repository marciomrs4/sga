<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.1//EN' 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='application/xhtml+xml; charset=ISO-8859-1' />
<title>..:: Painel Diário ::..</title>
<link rel='stylesheet' type='text/css' href='../sga/css/PainelChamados.css' />
<script	language="JavaScript" src="../ticontrole/jscript/jquery-1.5.js"></script>
<script language="JavaScript" src="../ticontrole/jscript/jquery.tablesorter.js"></script>
	
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
	<h2>Painel de Atividades de Projetos | <?php echo(date('d-m-Y H:i:s'));?></h2>
</div>

<div id="topo2">
	<?php
		#Obetem o departamento do usuário 
		$dados['dep_codigo'] = ($_SESSION['dep_codigo'] == '') ? $_GET['dep_codigo'] : $_SESSION['dep_codigo'];

		$tbAtividade = new TbAtividade();

		$dados['sta_codigo'] = 1;
		$AtividadePendente = $tbAtividade->totalAtividadePainel($dados);
		
		$dados['sta_codigo'] = 2;
		$AtividadeEmAtendimento = $tbAtividade->totalAtividadePainel($dados);
		
		?>	

	<h3 id="emrecebimento">Total de Atividade(s): <?php echo($AtividadePendente[0]); ?> Pendente e <?php echo($AtividadeEmAtendimento[0]); ?> Em Andamento</h3>
</div>

<div id="painelcentral">

<div id="painel1">

<?php 

$tbUsuario = new TbUsuario();

foreach ($tbUsuario->listarUsuariosPainelAtividade($dados) as $valores):

echo("<fieldset id='completo'>
		<legend id='nome'>$valores[2]</legend>");
		
		$dados['usu_codigo_responsavel'] = $valores[0];
		$dados['sta_codigo'] = 2;
		
		$DataGrid = new DataGrid();
		
		$DataGrid->setDados($tbAtividade->listarAtividadePainel($dados));
		$DataGrid->setCabecalho(array("Projeto","Atividade","Dias"));
		$DataGrid->nomelink = '';
		$DataGrid->colunaoculta = 1;
		$DataGrid->mostrarDatagrid(1);
		
		echo("</fieldset>");
		
endforeach;
?>
	
</div>

</div>
</body>
</html>