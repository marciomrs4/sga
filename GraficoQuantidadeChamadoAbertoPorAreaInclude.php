<script src="../<?php echo($_SESSION['projeto']);?>/jscript/highcharts.js">></script>
<script src="../<?php echo($_SESSION['projeto']);?>/jscript/highcharts-3d.js">></script>
<script src="../<?php echo($_SESSION['projeto']);?>/jscript/exporting.js">></script>

<?php include_once 'jscript/GraficoQuantidadeChamadoAbertoPorArea.php'; ?>


<div id="quantidadedechamadoporarea" style="width:100%; height:400px;"></div>
