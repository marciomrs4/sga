<?php

$QL = (php_sapi_name() == 'cli') ? PHP_EOL : '<br>';

echo '__DIR__',__DIR__,$QL,$QL;

echo 'dirname(__DIR__)',dirname(__DIR__),$QL,$QL;

echo 'realpath(__DIR__)',realpath(__DIR__),$QL,$QL;


echo '__FILE__',__FILE__,$QL,$QL;

echo 'dirname(__FILE__)',dirname(__FILE__),$QL,$QL;

echo 'realpath(__FILE__)',realpath(__FILE__),$QL,$QL;

echo '$_SERVER[DOCUMENT_ROOT]',$_SERVER['DOCUMENT_ROOT'],$QL, $QL;


print_r(pathinfo(__DIR__));
?>