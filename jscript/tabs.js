var $mas = jQuery.noConflict();

$mas(document).ready(function(){
	$mas("#telausuarioatividade").css('background','#E0FFFF');
	
$mas("#usuarioatividade").on('click',function(){
        $mas('#esconder').toggle();
    });
});
