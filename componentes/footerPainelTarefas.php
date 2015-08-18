<!-- Modal -->

<div class="modal fade in bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
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
            <p class="navbar-text">
                <b>..::  &copy CEADIS [Tecnologia da Informação] <?php echo date('Y'); ?> ::..
                </b>
            </p>
	    </nav>
	<nav class="navbar">

    </nav>
</footer>

			<script src="jscript/jquery-2.1.4.js"></script>
			<script src="jscript/bootstrap.js"></script>
            <script src="jscript/jquery.dataTables.js"></script>

<script>
var $alert = jQuery.noConflict();

function enviarAjax($alert,tarefa)
{
    $alert.ajax({
        type: "POST",
        url: "registrartarefa.php",
        data: {post_tarefa : tarefa},

        beforeSend: function()
        {
            //alert('Teste');
            $alert(".btn-primary").hide();
        },

        complete: function()
        {

        },

        success: function(data)
        {
            $alert(".btn-primary").show();
            $alert("#listartarefa").html(data);

        },

        error: function(){
            alert('Invalida argument exception');
        }
    });

    return false;
}

$alert(document).ready(function(){
    //Encolhe os paineis do sistema de forma padrao
    $alert(".panel-heading").click(
    function(){
    $alert(this).next().toggle('slow');
    });

    $alert('body').on('keyup',function(e){
        //alert(e.which);

        if(e.which == '13') {

            var tarefa = $alert('.addtarefa').prev().val();

            if(tarefa == '') {

                alert('Você deve inserir um valor!');

            }else {

                enviarAjax($alert, tarefa);

                $alert('.addtarefa').prev().val('');
            }

            return false;
        }
    });

    $alert(".addtarefa").on({
        click: function(){


        var tarefa = $alert(this).prev().val();

        if(tarefa == '') {

            alert('Você deve inserir um valor!');

        }else {

            enviarAjax($alert, tarefa);

            $alert(this).prev().val('');
        }
    }});

    $alert(document).on('click','li.list-group-item',function(){

        var tarefa = $alert(this).html();

        enviarAjax($alert, tarefa);

    });

    $alert(document).on('dblclick','#table-bootstrap',function(){
        $alert(this).dataTable({
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": "<span style='cursor: pointer'> Anterior </span>",
                    "sNext": "<span style='cursor: pointer'> Proximo </span>"
                },
                "sLengthMenu": "Mostrar _MENU_ resultado(s)",
                "sSearch": "Pesquisar: ",
                "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ resultado(s)",
                "sInfoFiltered": "(Total: _MAX_ )",
                "sZeroRecords": "Resultado nao encontrado",
                "sInfoEmpty": "Sem resultados"
            }
        });
    });


});
</script>

<script>
    var $load = jQuery.noConflict();
    var count = 1;

    function checkTime(i){
        if (i<10) {
            i="0" + i;
        }
        return i;
    }


    function mostrarTempo()
    {
        date = new Date();

        dataAtual = date.getDate() +'/0'+ (date.getMonth()+parseInt(1)) +'/'+ date.getFullYear() + ' ' +
                    date.getHours() +':'+ checkTime(date.getMinutes())+':'+checkTime(date.getSeconds());

        $load("#tempo").html(dataAtual);

        setTimeout('mostrarTempo()',1000);

    }



function loadPaineis() {

    if (count > 1)
        count--;
    else

        setTimeout("loadPaineis();", 6000);

    $load.post('LoadAtividadesPainelTarefas.php',
        function (data) {
            $load("#listaratividade").html(data);
        }, 'html');


     $load.post('LoadChamadosPainelTarefas.php',
     function (data) {
     $load("#listarchamado").html(data);
     }, 'html');

}

</script>


<script>
    loadPaineis();
    mostrarTempo();
</script>


</body>
</html>