
var $atividade = jQuery.noConflict();

$atividade(document).on('click','#atividade',function(){

    var codigo = $atividade(this).val();

    $atividade.post('forms/getAtividadeDetalheProjeto.php',
        {at_codigo: codigo}, function (data) {
            $atividade('#carregaratividade').html(data);
        });
});


$atividade(document).on('click','#DocinformacaoCoresPrazo',function(){

    var codigo = $atividade(this).val();

    $atividade.post('services/DocInformacaoCoresPrazo.php',
        {at_codigo: codigo}, function (data) {
            $atividade('#carregaratividade').html(data);
        });
});