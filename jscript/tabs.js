var $mas = jQuery.noConflict();

$mas(document).ready(function(){
	$mas("#telausuarioatividade").css('background','#E0FFFF');
	
$mas("#usuarioatividade").toggle(
		function(){
	          
		       $mas("#esconder").hide('fast');
		       $mas("#usuarioatividade").html('<a href="#">Informações da Atividade [Mostrar]</a>').css("color","#06C");
		       
	        },
	    function(){
		       $mas("#esconder").show('slow');
		       $mas("#usuarioatividade").html('<a href="#">Informações da Atividade [Ocultar]</a>').css("color","#06C");
		       
	        });
});