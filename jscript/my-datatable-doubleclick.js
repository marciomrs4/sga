var $table = jQuery.noConflict();

$table(document).ready(function(){

/*    $table(".panel-heading").click(
        function(){
            $table(this).next().toggle(1000);
        });*/

});

$table(document).on('click','.glyphicon-filter',function(){

    $table('#table-bootstrap').dataTable({
        "oLanguage": {
            "oPaginate":{
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

$table(document).on('click','.removefiltro',function(){
  $table('#table-bootstrap').off();
});