/**
 * Created by marcio on 21/08/15.
 */

$(document).ready(function(){

    //alert('Carregou');
});


$(document).on('click','#criaracesso',function(event){

    //event.preventDefault();
    //alert('Teste');

    var dados = $('#formsolicitacaoacesso').serialize();

   /* $.post('receberform.php',{data: dados },function(data){
        $('#loadform').html(data);
    });
*/
    $.ajax({
        type: "POST",
        url: "receberform.php",
        data: dados,

        beforeSend: function()
        {

            $("#criaracesso").hide();

        },

        complete: function()
        {
            //alert('Complete');

        },

        success: function(data)
        {
            //alert('Sucess');
            $('#loadform').html(data);
            $("#criaracesso").show();

        },

        error: function(){
            alert("Houve um erro na Requisicao");
        }
    });

    return false;

});

var x = 0;

$(document).on('click','#incluir',function(event){

    event.preventDefault();

    if(x >=5){
        alert('Amigão, não tem biscoito!!!');
    }else {

        $.get('forms/solicitacaoacessoservicos.php', function (data) {
            $('#insercao').append(data);
        });

        x++;
    }
});

$(document).on('click','.remover',function(event){

    x--;
    event.preventDefault();
    $(this).parent().parent().remove();
});


$(document).on('change','select[name="service[]"]',function(){
    var valor = $(this).val();

    //alert(valor);

    $('select[name="perfil[]"]').html(valor);

});