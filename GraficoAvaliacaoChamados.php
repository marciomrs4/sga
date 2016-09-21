<script src="../<?php echo($_SESSION['projeto']);?>/jscript/jquery-2.1.4.js"></script>
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

<script src="../<?php echo($_SESSION['projeto']);?>/jscript/mootools-1.2-core.js"></script>
<script src="../<?php echo($_SESSION['projeto']);?>/jscript/vlaCal-v2.1.js"></script>
<script src="../<?php echo($_SESSION['projeto']);?>/jscript/calendar.js"></script>

<?php
include $_SERVER['DOCUMENT_ROOT']."/sga/jscript/GraficoAvaliacaoChamado.php";
?>

</div>

<!-- Modal -->

<div class="modal fade in bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <p></p>
                </h4>
            </div>
            <div class="modal-body">
                <span id="carregarchamado"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Avaliação de chamados</h3>
  </div>
  <div class="panel-body">
	<div id="graficochamadotempodesolucao" style="width:100%; height:400px;"></div>
  </div>
  <div class="panel-footer">..: SGA - Sistema de Gestão de Atividades [Tecnologia da Informação] :..</div>
</div>

</div>

</body>
</html>