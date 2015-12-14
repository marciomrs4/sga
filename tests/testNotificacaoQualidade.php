<?php
date_default_timezone_set('America/Sao_Paulo');

include_once '../model/Banco.class.php';
include_once '../model/TbCadastroRnc.class.php';
include_once '../classes/SMTP.class.php';
include_once '../classes/PHPMailer.class.php';
include_once '../classes/Email.class.php';
include_once '../classes/DataGrid.class.php';

try
{

    $tbRnc = new TbCadastroRnc();

    //print_r($tbRnc->listRncToVerificacao()->fetchAll(\PDO::FETCH_NAMED));

    $table = '';

    $table .= '<table border="1">
                    <thead>
                        <tr>
                         <td>RNC número</td>
                         <td>Tipo de Ocorrência</td>
                         <td>Previsão de Encerramento</td>
                        </tr>
                    </thead>
                 ';


    foreach($tbRnc->listRncToVerificacao() as $campo):
        $table .= "<tbody>
                      <tr>
                        <td>{$campo['numero_rnc']}</td>
                        <td>{$campo['pro_codigo_tecnico_rnc']}</td>
                        <td>{$campo['nc_previsao_encerramento']}</td>
                      </tr>
                   </tbody>";

    endforeach;

$table .= '</table>';

    //echo $table;


    $emal = new Email();

    //wellington.junior@ceadis.org.br

    $emal->AddAddress('marcio.santos@ceadis.org.br');

    $emal->setCabecalho('TESTE - Notificação para verificação de RNCs');

    $emal->setMensagem($table);

    $emal->enviarEmail();

}catch (\PDOException $e)
{
    echo $e->getMessage();
}

?>