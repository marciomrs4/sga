<?php 
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/topo1.php");
?>

<script type="text/javascript" src="../<?php echo($_SESSION['projeto']);?>/jscript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../<?php echo($_SESSION['projeto']);?>/jscript/jquery.validate.js"></script>
<script type="text/javascript" src="../<?php echo($_SESSION['projeto']);?>/jscript/validador.js"></script>

<script type="text/javascript" src="../<?php echo($_SESSION['projeto']);?>/jscript/combodinamicoPrioridade.js"></script>


<link rel='shortcut icon' href='css/images/logoRS.ico'>

<?php 
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/topo2.php");
include($_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/componentes/menuprincipal.php");
?>