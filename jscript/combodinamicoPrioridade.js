/*
 * Utilizado no cadastro de Prioridade, formulario dinamico de prioridade
 */
var $listar = jQuery.noConflict();

$listar(document).ready(function(){

	$listar('select[name="dep_codigo_prioridade"]').change(function(){

		var codigo = $listar('select[name="dep_codigo_prioridade"]').val();
		$listar.post('meutempoatendimento.php', 
				{departamento_codigo: codigo },
				function(data){		
					$listar('select[name="tat_codigo"]').html(data);
				},
		'html');
		return false;
	});

})(jQuery);