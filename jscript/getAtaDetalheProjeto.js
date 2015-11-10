
var $ata = jQuery.noConflict();

$ata(document).on('click','#ata',function(){

    var codigo = $ata(this).val();

    $ata.post('forms/getAtaDetalheProjeto.php',
        {ata_codigo: codigo}, function (data) {
            $ata('#carregaratividade').html(data);
        });
});