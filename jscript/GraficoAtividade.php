<?php
include_once($_SERVER['DOCUMENT_ROOT']."/SGA/componentes/config.php");
?>

var $grafico = jQuery.noConflict();

$grafico(document).ready(function(){
	
	
	$grafico('#containerAqueleDoGrafico').highcharts({
	
			credits:{
			enabled: false
		},
	
	
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 1,//null,
            plotShadow: false
        },
        title: {
            text: 'Quantidade de Atividades por Status'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
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
            name: 'Porcentagem',
            data: [
					<?php 
						$tbAtividade = new TbAtividade();
						$tbAtividade->graficoAtividade();
						?>
            	  ]
        		}]
    });
})(jQuery);
