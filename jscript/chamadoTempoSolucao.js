
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


    $chamado("#docRelatorioTempoTerceiro").on('click',function(){

        $chamado("#myModal").show('clip');

        var codigo  = $chamado(this).val();

        $chamado.post('services/DocRelatorioTempoSolucaoTerceiro.php',
            {sol_codigo: codigo },
            function(data){
                $chamado('#carregarchamado').html(data);
            },
            'html');
        return false;

    });

    $chamado('body').on('keyup',function(e){
        //alert(e.which);

        if(e.which == '119') {
            $chamado("#myModal").show('clip');

            var codigo = $chamado(this).val();

            $chamado.post('services/DocRelatorioTempoSolucaoTerceiro.php',
                {sol_codigo: codigo},
                function (data) {
                    $chamado('#carregarchamado').html(data);
                },
                'html');
            return false;
        }
    });


    $chamado(".panel-heading").click(
        function(){
            $chamado(this).next().toggle(1000);
        });

});