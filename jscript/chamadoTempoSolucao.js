
var $chamado = jQuery.noConflict();

$chamado(document).ready(function(){

	$chamado("button.chamado").click(function(){

		$chamado("#myModal").show(1000);
		
		var codigo  = $chamado(this).val();
		
		$chamado.post('getChamadoSolucao.php', 
			{sol_codigo: codigo },
				function(data){		
					$chamado('#teste').html(data);
				},
		'html');
		return false;

		

	});

});