/**
 * maxlength( length ): Máximo de caracteres
rangelength( range ): Faz com que o elemento requer um intervalo de valores dado
max( value ): Valor máximo permitido
url( ): URL válida
date( ): Data válida
dateISO( ): Data ISO válida
number( ): Campo numérico
digits( ): Só aceita dígitos
creditcard( ): Um número de cartão de crédito
equalTo( other ): igual à um determinado valor
 */

var $valida = jQuery.noConflict();

/*
var usuario  = 'Utilizador';
var problema = 'Serviço';
var ramal = 'Extensão';
var senha = 'Palavra-passe';
*/


var usuario  = 'Usuário';
var problema = 'Problema';
var ramal = 'Ramal';
var senha = 'Senha';

function submitForm(form){			
	
	$valida("#botaoSave").hide();
	$valida(".botaoSave").css("visibility","visible");

	form.submit();
	
	}


$valida(document).ready( function() 
{
	
	$valida("#meuproblema").validate({
		/* REGRAS DE VALIDAÇÃO DO FORMULÁRIO */
		rules:{
			pro_descricao:{
				required: true, /* Campo obrigatório */
				minlength: 5    /* No mínimo 5 caracteres */
			},
			dep_codigo_problema:{
				required: true
			}
		},
		/* DEFINIÇÃO DAS MENSAGENS DE ERRO */
		messages:{
			pro_descricao:{
				required: "Preencha o campo <u>" +problema+ "</u>",
				minlength: "O campo <u>" +problema+ "</u> deve conter no mínimo 5 caracteres"
			},
			dep_codigo_problema:{
				required: "Campo Departamento é Obrigadorio"
			}
		}
	});

	$valida("#projeto").validate({

		rules:{
			pro_titulo:{
				required: true, /* Campo obrigatório */
				minlength: 5    /* No mínimo 5 caracteres */
			},
			pro_descricao:{
				required: true
			}
		},
		messages:{
			pro_titulo:{
				required: "Preencha o campo <u>Titulo</u>",
				minlength: "O campo <u>Projeto</u> deve conter no mínimo 5 caracteres"
			},
			pro_descricao:{
				required: "Campo Descrição do projeto é Obrigadorio"
			}
		},
		
		submitHandler: function(form){
			submitForm(form);
		}
	});
	
		/*Inicio de validação do formulário de solicitacao*/
		$valida("#solicitacao").validate({
			/* REGRAS DE VALIDAÇÃO DO FORMULÁRIO */
			rules:{
				dep_codigo:{
					required: true
				},
				pro_codigo:{
					required: true
				},
				sol_descricao_solicitacao:{
					required: true,
					minlength: 20
				}
			},
			/* DEFINIÇÃO DAS MENSAGENS DE ERRO */
			messages:{
				dep_codigo:{
					required: "O campo departamento é obrigatório"
				},
				pro_codigo:{
					required: "O campo " +problema+ " é obrigatório"
				},
				sol_descricao_solicitacao:{
					required: "O Campo Descrição é obrigatório",
					minlength: "O Campo Descrição deve possuir no minimo 20 caracteres"
				}
				
			},
			
			submitHandler: function(form){			
				submitForm(form);
			}
			});
		/*Fim de validação do formulário de solicitacao*/
	
		/*Inicio de validação do formulário de assentamento*/
		$valida("#Assentamento").validate({
			/* REGRAS DE VALIDAÇÃO DO FORMULÁRIO */
			rules:{
				
				ass_descricao:{
					required: true,
					minlength: 10
				}
			},
			/* DEFINIÇÃO DAS MENSAGENS DE ERRO */
			messages:{
				ass_descricao:{
					required: "O campo Descrição do Assentamento é obrigatório",
					minlength: "O campo Descrição do Assentamento precisa de ao menos 10 caracteres"
				}
			},
			submitHandler: function(form){
				submitForm(form);	
			}
		});
		/*Fim de validação do formulário de assentamento*/	
		
		/*Inicio de validação do formulário de Atividade*/
		$valida("#atividade").validate({
			/* REGRAS DE VALIDAÇÃO DO FORMULÁRIO */
			rules:{
				
				at_previsao_inicio:{
					required: true
				},
				
				at_previsao_fim:{
					required: true
				},
				
				usu_codigo_responsavel:{
					required: true
				},
				pro_codigo:{
					required: true
				},
				at_descricao:{
					required: true,
					minlength: 10
				}
			},
			/* DEFINIÇÃO DAS MENSAGENS DE ERRO */
			messages:{
				
				at_previsao_inicio:{
					required: "O campo Previsão de Inicio é obrigatório"
				},
				
				at_previsao_fim:{
					required: "O campo Previsão de Fim é obrigatório"
				},
				
				usu_codigo_responsavel:{
					required: "O campo Usuário Executor é obrigatório"
				},
				pro_codigo:{
					required: "O campo Projeto é obrigatório"
				},
				at_descricao:{
					required: "O campo Descrição da atividade é obrigatório",
					minlength: "O campo Descrição da atividade precisa de ao menos 10 caracteres"
				}
			}
		});
		/*Fim de validação do formulário de Atividade*/	
	
});