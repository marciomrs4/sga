<?php
/**
 * @example Funcao para carregar todas as classes model
 *
 */

function __autoload($class)
{
	$arquivo = $_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/model/{$class}.class.php";


	if(!file_exists($arquivo))
	{
		$arquivo = $_SERVER['DOCUMENT_ROOT']."/{$_SESSION['projeto']}/classes/{$class}.class.php";

	}

	include_once($arquivo);
}
?>