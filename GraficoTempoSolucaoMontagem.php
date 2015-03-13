<script src="../<?php echo($_SESSION['projeto']);?>/jscript/jquery-1.11.1.min.js"></script>
<script src="../<?php echo($_SESSION['projeto']);?>/jscript/bootstrap.js"></script>
<script src="../<?php echo($_SESSION['projeto']);?>/jscript/my-alert.js"></script>

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

<script src="../<?php echo($_SESSION['projeto']);?>/jscript/chamadoTempoSolucao.js"></script>



<?php 

include $_SERVER['DOCUMENT_ROOT']."/sga/jscript/GraficoChamadoTempoSolucao.php";

?>

</div>

<!-- Modal -->

<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: hidden">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Informações do Chamado</h4>
      </div>
      <div class="modal-body">
			<span id="teste"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default close" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
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