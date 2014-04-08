<?php 
#Seto o time zone como são paulo
date_default_timezone_set('America/Sao_Paulo');

#Crio um objeto de conexão PDO
$conexao = new PDO('mysql:host=localhost;dbname=sga','root','q1w2e3mrs',array(PDO::ATTR_PERSISTENT => true));
$conexao->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

try
{
	#Obtenho o Dia e Mês atuais
	$mes = date('m');
	$dia = date('d');
	
	#Faço uma query buscando o mes, dia e unidade CEADIS
	$query = ("SELECT ani_nome, ani_setor 
				FROM tb_aniversariante 
				WHERE ani_mes = ?  
				AND ani_dia = ?
				AND ani_unidade = 1");
	/* 
				#Unidade CEADIS = 1 | UDTP = 2
				AND ani_unidade = 1");
*/	
	$stmt = $conexao->prepare($query);
	
	$stmt->bindParam(1,$mes,PDO::PARAM_INT);
	$stmt->bindParam(2,$dia,PDO::PARAM_INT);	
	
	$stmt->execute();
	#Retorno o resultado da busca
	$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
	#Verifico de houve algum resultado, se não houve
	#não envio nada, caso contrario 
	if(count($dados) == 0)
	{
		echo 'Vazio';
		
	}else
	{

		$html = null;
		
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
		
	//echo $html;

		//'infra@ceadis.org.br'; 'marcio.santos@ceadis.org.br';
		
		$para = 'eventos@ceadis.org.br';
		$cabecalho = date('d/m').' Aniversariante(s) do dia';
		$emaildominio = 'sga@ceadis.org.br';
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From: $emaildominio\r\n";
		$headers .= "Return-Path: $emaildominio\r\n";
	
		$erro = mail($para,$cabecalho,$html,$headers);
		
		if($erro)
		{
			echo('E-mail Enviado com sucesso!');	
		}else
		{
			echo('Houve algum problema ao enviar o e-mail');

		}

	}
	
	
}catch (PDOException $e)
{
	echo $e->getMessage();
}

?>