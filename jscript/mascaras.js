// JavaScript Document

var $b = jQuery.noConflict();

(function($) {
$b(function() {
$b('.data').mask('99/99/9999'); //DATA
$b('.cep').mask('99999-999'); //CEP
$b('.tel').mask('99-9999-9999'); //TELEFONE
$b('.cel').mask('99-9999-9999'); //CELULAR
$b('.cpf').mask('999.999.999-99'); //CNPJ
$b('.cnpj').mask('99.999.999/9999-99'); //CNPJ
$b('.ie').mask('999.999.999.999'); //IE
$b('.mask-ag').mask('9999-9'); //Agencia
$b('.mask-ag').mask('9.999-9'); //Conta
$b('.hora').mask('99:99:99'); //hora
$b('.rg').mask('99.999.999-9'); //hora
$b('.ramal').mask('99'); //hora
$b('.drt').mask('99999999'); //hora
});
});