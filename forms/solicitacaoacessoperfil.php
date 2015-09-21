<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/sga/componentes/config.php');

header('Content-Type: text/html; charset=ISO-8859-1');

$ser_codigo = filter_var($_POST['post_service'],FILTER_VALIDATE_INT);

$tbServico = new TbPerfil();

print_r($tbServico->selectByServico($ser_codigo)->fetchAll(\PDO::FETCH_ASSOC));

?>


<select class="form-control" name="perfil">
<?php
foreach($tbServico->selectByServico($ser_codigo)->fetchAll(\PDO::FETCH_ASSOC) as $linha){
?>
    <option value="<?php echo $linha['per_codigo'] ?>"><?php echo $linha['per_descricao'] ?></option>
<?php
}

?>
</select>
