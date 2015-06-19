
var $grafico = jQuery.noConflict();

$grafico(document).ready(function(){
	
	
	$grafico('#containerAqueleDoGrafico').highcharts({
		
		credits:{
			enabled: false
		},
		
        chart: {
            type: 'column'
        },
        title: {
            text: 'Atividade'
        },
        xAxis: {
            categories: ['Aberto', 'Atendimento', 'Concluido']
        },
        yAxis: {
            title: {
                text: 'Quantidade de Atividades'
            }
        },
        series: [{
            name: 'Jane',
            data: [1, 0, 4]
        }, {
            name: 'John',
            data: [5, 7, 3]
        }]
    });
})(jQuery);