<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');
?>

<?php
$n = rand(1,100)
?>

<!DOCTYPE HTML>
<html>

<head>
	<meta charset="ISO-8859-1">
	<title>SGA - PROJETOS</title>	
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel='shortcut icon' href='css/images/ceadisico.ico'>	
	<!-- css -->
	<link href="css/bootstrap/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="navbar-header">
	
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu-principal">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
            
	</div>	
	  
	<div class="container-fluid collapse navbar-collapse" id="menu-principal">
            <h4 class="navbar-text"><a href="PainelProjetoUsuarios.php" title="Voltar">SGA</a> - DETALHES DO PROJETO</h4>
            <h5 class="navbar-right navbar-text"><span class="estiloniver"> <?php echo (date('d-m-Y')); ?> <span id="timer"></span></span></h5><span class="navbar-right navbar-text"></span>
	</div>				
</nav>

<nav class="navbar"></nav>
