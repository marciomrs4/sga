/**
 * maxlength( length ): M?ximo de caracteres
rangelength( range ): Faz com que o elemento requer um intervalo de valores dado
max( value ): Valor m?ximo permitido
url( ): URL v?lida
date( ): Data v?lida
dateISO( ): Data ISO v?lida
number( ): Campo num?rico
digits( ): S? aceita d?gitos
creditcard( ): Um n?mero de cart?o de cr?dito
equalTo( other ): igual ? um determinado valor
 */

var $valida = jQuery.noConflict();


function submitForm(form){			
	
	
	$valida("#botaoSave").hide();
	$valida("#loadprocessar").html('<img src="css/images/299.GIF" alt="">');

	form.submit();
	
}


$valida(document).ready( function() 
{

	$valida("#cadastrarrnc").validate({

		rules:{

			nc_acao_imediata:{
				required: true,
				minlength: 10
			}
		},
		/* DEFINI??O DAS MENSAGENS DE ERRO */
		messages:{

			nc_acao_imediata: {
				required: "O campo Ação Imediata, é obrigatório",
				minlength: "É necessário ao menos 10 caracteres"
			}
		},
		submitHandler: function(form){
			submitForm(form);
		}
	});


	$valida("#rncGestor").validate({

		rules:{

			nc_acao_melhoria:{
				required: true,
				minlength: 10
			}
		},
		/* DEFINI??O DAS MENSAGENS DE ERRO */
		messages:{

			nc_acao_melhoria: {
				required: "O campo Ação de melhoria, é obrigatório",
				minlength: "É necessário ao menos 10 caracteres"
			}
		},
		submitHandler: function(form){
			submitForm(form);
		}
	});


	$valida("#rncVerificacao").validate({

		rules:{

			ver_parecer_qualidade:{
				required: true,
				minlength: 10
			}
		},
		/* DEFINI??O DAS MENSAGENS DE ERRO */
		messages:{

			ver_parecer_qualidade: {
				required: "O campo Ação de melhoria, é obrigatório",
				minlength: "É necessário ao menos 10 caracteres"
			}
		},
		submitHandler: function(form){
			submitForm(form);
		}
	});

});