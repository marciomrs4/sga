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

                <span id="carregaratividade"></span>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<footer>
        <nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
            <p class="navbar-text"><b>..::  &copy CEADIS [Tecnologia da Informação] <?php echo date('Y'); ?> ::..</b></p>                                                           
	</nav>     
	<nav class="navbar"></nav>
</footer>

			<script src="jscript/jquery-2.1.4.js"></script>
			<script src="jscript/bootstrap.js"></script>
            <script src="jscript/my-alert.js"></script>

            <script src="jscript/highcharts.js"></script>
            <script src="jscript/highcharts-3d.js"></script>
            <script src="jscript/exporting.js"></script>
            <?php
            include_once $_SERVER['DOCUMENT_ROOT'].'/sga/jscript/getGraficoRncPorDepartamento.php';
            include_once $_SERVER['DOCUMENT_ROOT'].'/sga/jscript/getGraficoRncPorTipoOcorrencia.php';
            ?>

</body>
</html>
