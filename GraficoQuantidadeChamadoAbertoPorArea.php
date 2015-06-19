<?php
include_once($_SERVER['DOCUMENT_ROOT']."/sga/componentes/config.php");

ControleDeAcesso::permitirAcesso(array(ControleDeAcesso::$TecnicoADM,ControleDeAcesso::$Tecnico));

include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/componentes/script.php");


?>
<div>
	<?php include_once 'GraficoQuantidadeChamadoAbertoPorAreaInclude.php'; ?>
</div>
<?php 




Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/menurelatorio.php");
include($_SERVER['DOCUMENT_ROOT']."/{$Projeto}/componentes/rodape.php");

?>