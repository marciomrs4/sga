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

<footer>
        <nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
            <p class="navbar-text"><b>..::  &copy CEADIS [Tecnologia da Informação] <?php echo date('Y'); ?> ::..</b></p>                                                           
	</nav>     
	<nav class="navbar"></nav>
</footer>

			<script src="jscript/jquery-2.1.4.js"></script>
			<script src="jscript/bootstrap.js"></script>
            <script src="jscript/chamadoTempoSolucao.js"></script>
            <script src="jscript/my-alert.js"></script>

<script type="text/javascript">
    var $timer = jQuery.noConflict();
    $timer(document).ready(function(){

        $timer("#tempo").css("color","red");

        var x = 0;
        for(x = 0; x <= 1; x++)
        {
            $timer(".panel-heading").fadeOut("slow");
            $timer('.panel-heading').fadeIn("slow");
        }

    });

    var count = 180; // O tempo para refresh em segundos

    function timer()
    {
        $timer("#timer").html(count);

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

<!--			<script src="jscript/timer.js"></script>-->
</body>
</html>
