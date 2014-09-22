
var $listar = jQuery.noConflict();

$listar(document).ready(function(){

	$listar('select[name="dep_codigo_problema"]').change(function(){

		var codigo = $listar('select[name="dep_codigo_problema"]').val();
		$listar.post('minhaprioridade.php', 
				{codigo_departamento: codigo },
				function(data){		
					$listar('select[name="pri_codigo"]').html(data);
				},
		'html');
		return false;
	});

});