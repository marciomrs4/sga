
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
            pointFormat: '<span style="font-size: 18px">{series.name}:<span> <b>{point.y}</b>',
            style: {
				fontSize: '18px'
                }
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
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                        "fontSize":"18px"
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