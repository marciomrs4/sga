<?php 
/*

include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

$Mail = new PHPMailer();

$Mail->IsSMTP();


$Mail->Host = 'mail.staycorp.com.br';

$Mail->Port = 587;
$Mail->SMTPAuth = true;


$Mail->From = 'marcio@staycorp.com.br';

$Mail->FromName = 'Márcio Ramos';

$Mail->AddAddress('marcio@staycorp.com.br');
$Mail->AddAddress('marciomrs4@gmail.com');
$Mail->AddAddress('marciomrs4@hotmail.com');

//$Mail->CharSet # Padrão ISO-8859-1

$Mail->IsHTML(true);

$Mail->Subject = 'E-mail de TESTE';
$Mail->Body = 'Este é um envio de teste que deve ser testado';

$erro = $Mail->Send();

$Mail->ClearAllRecipients();

if($erro)
{
	echo 'Enviado com sucesso!';
}else {
	echo 'Não foi possivel enviar';
	echo $Mail->ErrorInfo;
}

*/
