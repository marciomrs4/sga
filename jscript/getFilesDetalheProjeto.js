
var $files = jQuery.noConflict();

$files(document).on('click','#files',function(){

    var codigo = $files(this).val();

    $files.post('forms/getFilesDetalheProjeto.php',
        {pro_codigo: codigo}, function (data) {
            $files('#carregaratividade').html(data);
        });
});