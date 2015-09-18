<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

if($_POST)
{
    if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
    {


                $cadastro = new Cadastro();

                try
                {
                    $cadastro->setDados($_POST);

                    $sac_codigo = base64_encode($cadastro->cadastrarSolicitacaoAcesso());

                    header('location: /sga/SolicitacaoAcessoCreated.php?id='.$sac_codigo);

                }catch (Exception $e)
                {
                    ClasseException::throwException($e,$_POST,'cadastrar/SolicitacaoAcesso');
                }

    }else
    {
        Sessao::destroiSessao();
    }
}else
{
    Sessao::destroiSessao();
}
?>
