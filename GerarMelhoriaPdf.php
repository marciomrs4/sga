<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');
include_once 'plugin/MPDF54/mpdf.php';

if($_GET)
{

	$busca = new Busca();

	$busca->setValueGet($_GET,'som_codigo');

	$tbMelhoria = new TbSolicitacaoMelhoria();

	$dadosMelhoria = $tbMelhoria->getForm($busca->getValueGet('som_codigo'));


	try
	{

		ob_start();


		?>
		<fieldset>
		<legend><img src="css/images/logoRelatorio.jpeg"></legend>
		<hr />

		<fieldset>
			<legend>Número da Melhoria: <?php echo $busca->getValueGet('som_codigo'); ?> </legend>

			<hr/>

			<table border="0" cellspacing="5">

				<tr>
					<td colspan="2" align="center">
						<?php Texto::mostrarMensagem($_SESSION['erro']); ?>
					</td>
				</tr>

				<tr>
					<th nowrap="nowrap">
						Aberto por:
					</th>
					<td>
						<?php
						$tbusuario = new TbUsuario();
						$tbdepartamento = new TbDepartamento();
						$Usuario = $tbusuario->getUsuario($dadosMelhoria['usu_codigo_solicitante']);

						echo $Usuario['usu_email'];

						?>
					</td>
				</tr>

				<tr>
					<th>
					</th>
					<td nowrap="nowrap">
						<?php echo 'Ramal: '.$Usuario['usu_ramal'].' / '.$tbdepartamento->getDepDescricao($Usuario['dep_codigo']);?>
					</td>
				</tr>


				<tr>
					<th width="119" align="left" nowrap="nowrap">Data de Abertura:</th>
					<td>
						<?php

						echo $dadosMelhoria['som_data_solicitacao'];
						?>
					</td>
				</tr>


<!--				<tr>
					<td colspan="2">
						&emsp;
					</td>
				</tr>-->

				<tr>
					<th width="119" align="left" nowrap="nowrap">Sistema:</th>
					<td>
						<?php
						$tbsistemas = new TbSistemas();
						$dadosSistema = $tbsistemas->getForm($dadosMelhoria['sis_codigo']);
						echo $dadosSistema['sis_descricao'];
						?>
					</td>
				</tr>

				<tr>
					<th align="left" nowrap="nowrap">Descrição do <?php echo($_SESSION['config']['problema']); ?>:</th>
					<td>
						<?php echo($dadosMelhoria['som_descricao']); ?>
					</td>
				</tr>

				<tr>
					<td colspan="2">
						&emsp;
					</td>
				</tr>

				<tr>
					<td>
					</td>
					</td>
				</tr>

			</table>

			<?php

			try
			{
				$tbApontamento = new TbApontamentoMelhoria();

				$tabela = $tbApontamento->listarApontamentoMelhoria($busca->getValueGet('som_codigo'));

				$cabecalho = array('Descrição','Status','Data','Editor');

				$grid = new DataGrid($cabecalho, $tabela);

				$grid->titulofield = 'Apontamento(s)';
				$grid->islink = false;
				$grid->colunaoculta = 1;
				$grid->mostrarDatagrid(1);

			}catch (Exception $e)
			{
				echo $e->getMessage();
			}
			?>

		</fieldset>

		<?php

	}catch (Exception $e)
	{
		echo Texto::erro($e->getMessage());
	}

	$html = ob_get_clean();

	$mpdf = new mPDF();

	$mpdf->SetHeader(utf8_encode('Emitido em: - '.date("d-m-Y")));


	$mpdf->SetAuthor(utf8_encode("M?rcio Ramos"));
	$css =  file_get_contents('../sga/css/formatacao.css');


	$mpdf->WriteHTML($css,1);

	$mpdf->setFooter(utf8_encode('Emitido por: '.$_SESSION['usu_nome'] .' '.$_SESSION['usu_sobrenome'].' - Em: '.date("d-m-Y")));

	$mpdf->WriteHTML(utf8_encode($html),2);

	$mpdf->Output();

	exit();

}
?>