<?php
include_once($_SERVER['DOCUMENT_ROOT']."/sga/componentes/config.php");
?>

var $grafico = jQuery.noConflict();

$grafico(document).ready(function(){
	
	
	$grafico('#quantidadedechamadoporarea').highcharts({
	
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
        	style: {
   				fontWeight: 'bold'
				},
            text: 'Top 10: Quantidade de Chamado por Area - Periodo: 01/2014 a 12/2014'
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
                    format: '<b>{point.y}</b> | {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                },
                showInLegend: true
            }

            
        },
        series: [{
            type: 'pie',
            name: 'Quantidade',
            data: [
					<?php 
						$tbDepartamento = new TbDepartamento();
												
						$tbDepartamento->graficoChamadoPorArea();
						?>
            	  ]
        		}]
    });
})(jQuery);
