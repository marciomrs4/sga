<script src="../<?php echo($_SESSION['projeto']);?>/jscript/jquery-1.11.1.min.js"></script>

<script src="../<?php echo($_SESSION['projeto']);?>/jscript/highcharts.js"></script>
<script src="../<?php echo($_SESSION['projeto']);?>/jscript/highcharts-3d.js"></script>
<script src="../<?php echo($_SESSION['projeto']);?>/jscript/exporting.js"></script>

<script src="../<?php echo($_SESSION['projeto']);?>/jscript/jquery.dataTables.js"></script>
<script src="../<?php echo($_SESSION['projeto']);?>/jscript/tableTools.js"></script>
<script src="../<?php echo($_SESSION['projeto']);?>/jscript/my-data-table.js"></script>

<script src="../<?php echo($_SESSION['projeto']);?>/jscript/maskedinput.js"></script>
<script src="../<?php echo($_SESSION['projeto']);?>/jscript/mascaras.js"></script>

<script src="../<?php echo($_SESSION['projeto']);?>/jscript/jquery.validate.js"></script>
<script src="../<?php echo($_SESSION['projeto']);?>/jscript/validador.js"></script>



<?php 

include $_SERVER['DOCUMENT_ROOT']."/sga/jscript/GraficoChamadoTempoSolucao.php";

?>

</div>


<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Chamados Dentro e Fora do Prazo</h3>
  </div>
  <div class="panel-body">
 	<?php 
	echo '<br><br> Fora do Prazo:', $chamadoFora,'<br>',
		 'Dentro do prazo: ',$chamadoDentro,'<br>',
	     'Total de chamados no período: ',$totalChamado,'<br>';
	?>
	<div id="graficochamadotempodesolucao" style="width:100%; height:400px;"></div>
  </div>
  <div class="panel-footer">..: SGA - Sistema de Gestão de Atividades [Tecnologia da Informação] :..</div>
</div>

</body>
</html>