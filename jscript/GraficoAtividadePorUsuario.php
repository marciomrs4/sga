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
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
		
        title: {
            text: 'Quantidade de Atividades (Em Andamento e Pendente) por Usuário'
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
						$tbAtividade = new TbAtividade();
						$dados['dep_codigo'] = $_SESSION['dep_codigo'];
						#$dados['sta_codigo'] = 2,1;
						$tbAtividade->graficoAtividadePorUsuario($dados);
						?>
            	  ]
        		}]
    });
})(jQuery);
