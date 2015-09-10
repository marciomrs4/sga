<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

if($_POST)
{
	if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
	{

        try {

            $dados['pro_codigo'] = 513; //Codigo do problema usado na abertuda de chamado (Manutencao de usuarios
            $dados['dep_codigo'] = $_SESSION['dep_codigo']; //Departamento solicitado
            $dados['sol_descricao_solicitacao'] = 'Solicitação de Acesso'; //Descricao da solicitacao
            $dados['usu_codigo_solicitante'] = $_SESSION['usu_codigo']; //Codigo do usuarios que esta criando a solicitacao
            $dados['dep_codigo_solicitado'] = 5; //Departamento que recebera a solicitacao, no caso TI
            $dados['sta_codigo'] = 1; //Status Inicial do chamado.

            $tbSolicitacao = new TbSolicitacao();
            $dados['sol_codigo'] = $tbSolicitacao->insert($dados);

            #Grava a data de abertura da solicita??o
            $tbcalculoatendimento = new TbCalculoAtendimento();
            $tbcalculoatendimento->insertCalculoAtendimento($dados);


            $tbSolicitacaoAcesso = new TbSolicitacaoAcesso();

            $dados['sac_formulario'] = json_encode($_POST);

            $sac_codigo = $tbSolicitacaoAcesso->insert($dados);

            header('location: /sga/SolicitacaoAcessoCreated.php?id='.$sac_codigo);

        }catch (\PDOException $e){

            echo 'Deu muito ruim';

            throw new \PDOException($e);
        }


        //$email = new Email();
        //$email->aberturaChamado($dados);


	}else{

        header('location: '.$_SERVER['HTTP_REFERER']);

        Sessao::destroiSessao();
	}
}else {
	Sessao::destroiSessao();
}


?>
