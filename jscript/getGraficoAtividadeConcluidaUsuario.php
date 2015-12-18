<?php
include_once($_SERVER['DOCUMENT_ROOT']."/sga/componentes/config.php");
?>

<script>
    var $grafico = jQuery.noConflict();

    $grafico('#atividadeconcluido').highcharts({

        credits:{
            enabled: false
        },

        chart: {
            type: 'column'
        },
        title: {
            text: 'Atividades Fechadas (6 meses)'
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Quantidade de Atividade Fechadas'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Atividades Fechadas: <b>{point.y: .0f} </b>'
        },
        series: [{
            name: 'Population',
            data: [
                <?php
                    $tbAtividade = new TbAtividade();
                    $dados['usu_codigo_responsavel'] = $busca->getValueGet('usu_codigo');
                    $dados['data'] = ValidarDatas::dataBanco(ValidarDatas::dataAnterior(date('d-m-Y'),-180)). ' 00:00:01';
                    $tbAtividade->graficAtividadeConcludidoByUser($dados);
                ?>
            ],
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                format: '{point.y:.0f}', // one decimal
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });
</script>