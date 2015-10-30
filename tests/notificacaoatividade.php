<?php
#Seto o time zone como s?o paulo
date_default_timezone_set('America/Sao_Paulo');

include_once '../model/Banco.class.php';
include_once '../model/TbAtividade.class.php';
include_once '../classes/SMTP.class.php';
include_once '../classes/PHPMailer.class.php';
include_once '../classes/Email.class.php';


$tbAtividade = new TbAtividade();

foreach($tbAtividade->listaNotificaoAtividade() as $notificao){


    $cabecalho = 'Notificação do projeto: ' . $notificao['pro_titulo'];

    $mensagem = '';

    $mensagem .= "<b>Caro usuário(a), </b>" . $notificao['usu_nome'] .' | '. $notificao['usu_email'] .'<br>';
    $mensagem .= "<b>A atividade de número: </b>" . $notificao['at_codigo'] .'<br>';
    $mensagem .= "<b>com status: </b>" . $notificao['sta_descricao'] . '<br>';
    $mensagem .= "<b>do projeto: </b>" . $notificao['pro_titulo'] . '<br>';



    if($notificao['dias'] >= 0){

        if($notificao['dias'] == 0){
            $mensagem .= 'Essa atividade expira hoje!';
        }else {

            $mensagem .= "Faltam  {$notificao['dias']} dias para o fim da atividade";
        }

    }else{
        $notificao['dias'] *= -1;

        $mensagem .= "Passou {$notificao['dias']} dias do fim da atividade";
    }


    $email = new Email();
    $email->cabecalho = $cabecalho;
    $email->mensagem = $mensagem;
    $email->AddAddress($notificao['usu_email']);
    $email->enviarEmail();

}

?>