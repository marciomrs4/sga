<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/SGA/componentes/config.php');

$tbProjeto = new TbProjeto();

$dados['dep_codigo'] =  $_SESSION['dep_codigo'];

$TotalProjetos = $tbProjeto->totalProjetosPainel($dados);

/*
 * Status dos projetos
1	Aprovação
2	Andamento
3	Cancelado
4	Concluído
5	Paralisado
*/

?>

<link rel="stylesheet" href="./css/StylePainelProjetos.css">
<link rel="stylesheet" href="./css/formatacao.css">


       <div id="page">
           <h1>Painel de Projetos</h1><h3> <?php echo(date("d-m-Y") .' Total: '.$TotalProjetos[0].' projetos');?></h3>
       </div>
       
 	   
	   <div id="aprovacao">
	       <p>Aprovação</p>
		<?php 
		
	       $dados['stp_codigo'] = 1;
	       
	       $dataGridAprovacao = new DataGrid();
	       $dataGridAprovacao->setDados($tbProjeto->listarProjetosPainel($dados));
	       //$dataGridAprovacao->setCabecalho(array(""));
	       $dataGridAprovacao->colunaoculta = 1;
	       $dataGridAprovacao->link = 'PainelAtividade';
	       $dataGridAprovacao->acao = 'Visualizar/Atividade';
	       $dataGridAprovacao->nomelink = '<img src="/SGA/css/images/search2.png" title="Visualizar" />';	
	       $dataGridAprovacao->mostrarDatagrid();
	       
	       
	       ?> 	   
	   </div>   
	   
	   <div id="andamento">
	   <p>Andamento</p>
	   <?php 
	   
       $dados['stp_codigo'] = 2;
	   
	   $dataGridAndamento = clone $dataGridAprovacao;
       $dataGridAndamento->setDados($tbProjeto->listarProjetosPainel($dados));
	   $dataGridAndamento->mostrarDatagrid();
	   
	   ?>
	   
	   </div>
	   
	   <div id="paralisado">
	   <p>Paralisado</p>
	   
	   <?php 
	   
       $dados['stp_codigo'] = 5;
	   
	   $dataGridParalisado = clone $dataGridAprovacao;
       $dataGridParalisado->setDados($tbProjeto->listarProjetosPainel($dados));
	   $dataGridParalisado->mostrarDatagrid();
	   
	   ?>
	   
	   
	   </div>
	   
	   <div id="concluido">
	   <p>Concluido</p>
	   <?php 
	   
       $dados['stp_codigo'] = 4;
	   
	   $dataGridConcluido = clone $dataGridAprovacao;
       $dataGridConcluido->setDados($tbProjeto->listarProjetosPainel($dados));
	   $dataGridConcluido->mostrarDatagrid();
	   
	   ?>
	   
	   
	   </div>
	   
	   <div id="cancelado">
	   <p>Cancelado</p>
	   	   <?php 
	   
       $dados['stp_codigo'] = 3;
	   
	   $dataGridCancelado = clone $dataGridAprovacao;
       $dataGridCancelado->setDados($tbProjeto->listarProjetosPainel($dados));
	   $dataGridCancelado->mostrarDatagrid();
	   
	   ?>
	   
	   </div>

       <div id="footer">		
	   &copy; 2014, Painel de Projetos [Tecnologia da Informação]
	   </div>
 