
var $apontamento = jQuery.noConflict();

$apontamento(document).on('click','#apontamento',function(){

    var codigo = $apontamento(this).val();

    $apontamento.post('forms/getApontamentoDetalheProjeto.php',
        {ap_codigo: codigo}, function (data) {
            $apontamento('#carregaratividade').html(data);
        });
});