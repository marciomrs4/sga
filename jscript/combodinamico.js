
var $listar = jQuery.noConflict();

$listar(document).ready(function(){
	
	$listar('select[name="dep_codigo"]').change(function() {

		var item = $listar('select[name="dep_codigo"]').val();
		$listar.post('meusproblemas.php', 
				{dep_codigo: item },
				function(data){		
					$listar('select[name="pro_codigo"]').html(data);
				},
		'html');
		return false;
	});	
	
	$listar('select[name="dep_codigo_busca"]').change(function() {

		var item = $listar('select[name="dep_codigo_busca"]').val();
		$listar.post('meusproblemasBusca.php', 
				{dep_codigo: item },
				function(data){		
					$listar('select[name="pro_codigo_busca"]').html(data);
				},
		'html');
		return false;
	});		

})(jQuery);