<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');
include_once 'componentes/TopoPainelChamados.php';

$dados['dep_codigo'] = ($_SESSION['dep_codigo'] == '') ? $_GET['dep_codigo'] : $_SESSION['dep_codigo'];

$tbSolicitacao = new TbSolicitacao();
$dados['sta_codigo'] = 1;
$TotalEmAberto = $tbSolicitacao->totalChamadoStatusAreaPainel($dados);

$dados['sta_codigo'] = 2;
$TotalEmAtendimento = $tbSolicitacao->totalChamadoStatusAreaPainel($dados);

$dados['data1'] = date('Y-m-d').' 00:00:01';
$dados['data2'] = date('Y-m-d').' 23:59:59';
$dados['sta_codigo'] = 3;
$_SESSION['dep_codigo'] = $dados['dep_codigo'];
$TotalConcluidos = $tbSolicitacao->totalChamadoFechadosDoDia($dados);

$tbUsuario = new TbUsuario();

?>
	
	<div class="container-fluid">
	<!-- Div Principal -->
	
	<div class="panel panel-default">
  		<div class="panel-heading">
            <h4>Total de Chamado(s):
                <?php echo $TotalEmAberto[0]; ?> Em aberto,
                <?php echo $TotalEmAtendimento[0];?> Em atendimento  e
                <?php echo $TotalConcluidos;?> concluídos hoje.
            </h4>
        </div>
	</div>			
		
		<?php

        function getHourToSecunds($hora)
        {
            $horaParte = explode(':', $hora);

            $horasEmSegundo = ($horaParte['0'] * 3600) + ($horaParte['1'] * 60) + $horaParte['2'];

            return $horasEmSegundo;
        }

        function getPercent($horaTecnica, $tempoChamado)
        {

            $percent = ($tempoChamado / $horaTecnica) * 100;

            if($percent > 100){
                return '<img src="css/images/status/face2.png">';
            }else{

                $valor = sprintf('%.2f',$percent).'%';

                if($percent <= 50){
                    $style = 'progress-bar progress-bar-success progress-bar-striped';
                }elseif($percent > 50 and $percent <= 90){
                    $style = 'progress-bar progress-bar-warning progress-bar-striped';
                }elseif($percent > 90){
                    $style = 'progress-bar progress-bar-danger progress-bar-striped';
                }

                $retorno = '<div class="progress">
              <div class="'.$style.'"
                   role="progressbar"
                   aria-valuenow="'.$valor.'"
                   aria-valuemin="0"
                   aria-valuemax="100"
                   style="width: '.$valor.';">
                        <span style="color: #000000">'.$valor.'</span>
              </div>
             </div>';

                return $retorno;
            }
        }

        $dataOper = new dateOpers();

        $TbDepartamento = new TbDepartamento();
        $TempoDepartamento = $TbDepartamento->getAllHours($_SESSION['dep_codigo']);

        //Hora inicio do Departamento
        $hora_ini = ($hora_ini == '') ? $TempoDepartamento['dep_hora_inicio']  : $hora_ini;
        //Hora Fim do departamento
        $hora_fim = ($hora_fim == '') ? $TempoDepartamento['dep_hora_fim']     : $hora_fim;
        //Hora de almoco departamento
        $meio_dia = ($meio_dia == '') ? $TempoDepartamento['dep_hora_almoco']  : $meio_dia;
        //Carga horaria de sabado departamento
        $sabado =   ($sabado == '')   ? $TempoDepartamento['dep_carga_sabado'] : $sabado;

        $dados['sta_codigo'] = 2;


        foreach ($tbUsuario->listarUsuariosPainel($dados) as $valores):

            $tbAtendenteSolicitacao = new TbAtendenteSolicitacao();
            $dados['usu_codigo_atendente'] = $valores[0];

            //Chamada o metodo que pega as informacoes do banco e retorna um stmt
            $dadosUsuario = $tbAtendenteSolicitacao->listarSolicitacaoPainel($dados);

            //Com os dados do usuário faz um fetch
            $UsuarioInfo = $dadosUsuario->fetchAll(\PDO::FETCH_ASSOC);

            //Com dados do usuário conto quantos retornos do banco
            $QtdChamadoUsuario = $dadosUsuario->rowCount();

		?>			
				
		<div class="container col-sm-3">

            <?php

                $botton = new GridOption();
                $botton->setIco('search')->setName('Visualizar');

                $Grid = new Grid();
                $Grid->setCabecalho(array('','Número','Usuário','Dias','SLA'))
                     ->setDados($UsuarioInfo)->addOption($botton);


            $Grid->addFunctionColumn(function($var)use($dataOper,$TempoDepartamento){


            $tempo =explode('|', $var);

            $data1 = trim($tempo['0']);
            $data2 = trim($tempo['1']);

            $tempoProblema = trim($tempo['2']);

            #Hora Inicial
            $hora_ini = $TempoDepartamento['dep_hora_inicio'];
            #Hora Final
            $hora_fim = $TempoDepartamento['dep_hora_fim'];

            #At? o esse horario do almo?o
            $meio_dia = $TempoDepartamento['dep_hora_almoco'] ;
            #Horas de sabados
            $sabado   = $TempoDepartamento['dep_carga_sabado'];

            #Tipo de Saida em horas
            $saida = 'H';

            $horaUtil = $dataOper->tempo_valido($data1, $data2, $hora_ini, $hora_fim, $meio_dia, $sabado, $saida);

            #Converte para secundos as horas
            $horaUtil = getHourToSecunds($horaUtil);
            $tempoProblema = getHourToSecunds($tempoProblema);


            return getPercent($tempoProblema,$horaUtil);

             },3);

                $Grid->id = null;


                $Painel = new Painel();
                $Painel->addGrid($Grid)
                       ->setPainelTitle('<span class="glyphicon glyphicon-user"> '.$valores['usu_nome'].' </span>
                                         | <span class="glyphicon glyphicon-phone-alt"> '.$QtdChamadoUsuario.'</span>')
                       ->setPainelColor('primary')
                       ->show();

            ?>
        </div>

		<?php
        endforeach;
        ?>
					
	</div>
	<!-- Fim Div Principal -->
	
<?php 
	include_once 'componentes/footerPainel.php'; 
?>
