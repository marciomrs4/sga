
function doPrinter(){
    var conteudo = document.getElementById('print').innerHTML;
    tela_impressao = window.open('about:blank');
    tela_impressao.document.write(conteudo);
    tela_impressao.window.print();
    tela_impressao.window.close();
}

$print = jQuery.noConflict();

$print(document).on('click','#doPrinter',function(){

    window.print();
    //alert('Print');
    //doPrinter();
});