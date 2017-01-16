<?php 
#Seto o time zone como s?o paulo
date_default_timezone_set('America/Sao_Paulo');

include_once '../model/Banco.class.php';
include_once '../model/TbAniversariante.class.php';
include_once '../classes/SMTP.class.php';
include_once '../classes/PHPMailer.class.php';
include_once '../classes/Email.class.php';

try
{

    $tbAniversariante = new TbAniversariante();
    $dados = $tbAniversariante->createListEmailToDay();

	if(count($dados) == 0)
	{
		echo 'Vazio';
		
	}else
	{

		$html = '';
		
		$html .= '<h1 style="color: #1C86EE" >BOM DIA!</h1>
					<br />
				  <h2>
				  	<span style="color: #000">Hoje é aniversário de nosso(s) colega(s):</span>
					<br /><br />
				  </h2> 
				  <br /><br />';

		$html .= '<table border="0">
					<thead>
					   <th align="left" style="color: #1C86EE">NOME</th>
   					   <th>
   					   &nbsp;
   					   </th>
					   <th align="left" style="color: #1C86EE">SETOR</th>
				   </thead>';
		
		foreach($dados as $valor):
			
			$html .=  '<tr style="color: #000; font-weight: bold;">
						   <td>'.$valor['ani_nome'] .'</td>
						   <td>
							&nbsp; &rArr; &nbsp; 
						   </td>
						   <td>'.$valor['ani_setor'].'</td>
				   	   </tr>';
		
		endforeach;
				
		$html .= "<tr>
					<td colspan='3'>
					&nbsp;
					</td>
					</tr>
				</table>";
		
		$html .= '<h2>
				  	<span style="color: #1C86EE">Desejamos um feliz aniversário, muita saúde e felicidades!</span>
					<br /><br />
				  </h2>';
		
		$html .= '<h4>
				  	<span style="color: #000">CEADIS<br/>
				  	Centro Estadual de Armazenamento e Distribuição de Insumos de Saúde
				  	</span>
					<br /><br />
				  </h4>';


     $email = new Email();

     $cabecalho = date('d/m').' Aniversariante(s) do dia';

     $email->setCabecalho($cabecalho)
           ->setMensagem($html)
           ->AddAddress('sistemas@ceadis.org.br');

     $email->enviarEmail();

	}
	
	
}catch (\PDOException $e)
{
	echo $e->getMessage();
}

?>