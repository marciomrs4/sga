
var $chamado = jQuery.noConflict();

$chamado(document).ready(function(){

	$chamado("button.chamado").on('click',function(){

		$chamado("#myModal").show('clip');
		
		var codigo  = $chamado(this).val();
		
		$chamado.post('getChamadoSolucao.php', 
			{sol_codigo: codigo },
				function(data){		
					$chamado('#carregarchamado').html(data);
				},
		'html');
		return false;

	});

    $chamado(".panel-heading").click(
        function(){
            $chamado(this).next().toggle(1000);
        });

});