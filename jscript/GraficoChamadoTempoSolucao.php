
<script>
var $grafico = jQuery.noConflict();

$grafico(document).ready(function(){
	
	
	$grafico('#graficochamadotempodesolucao').highcharts({
	
			credits:{
			enabled: false
		},
	
	
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Quantidade',
            data: [
					<?php 
					
					echo "['Dentro do Prazo', {$chamadoDentro}]",',',
						 "['Fora do Prazo', {$chamadoFora}]";
						?>
					]
        		}]
    });
});
</script>