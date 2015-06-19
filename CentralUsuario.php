<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

ControleDeAcesso::acessoComun();

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/script.php");

Texto::criarTitulo("Minhas Informações");

?>

<a href="../<?php echo $_SESSION['projeto'] ?>/action/formcontroler.php?<?php echo base64_encode('alterar/MinhaSenha')?>">Alterar <?php echo($_SESSION['config']['senha'].' do '.$_SESSION['config']['usuario']);?></a>

<a href="../<?php echo $_SESSION['projeto'] ?>/action/formcontroler.php?<?php echo base64_encode('alterar/MeuPerfilCor')?>">Alterar Perfil</a>
<hr />
<?php 
Arquivo::includeForm();

Sessao::finalizarSessao();

include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/menusecundario.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/rodape.php");

?>