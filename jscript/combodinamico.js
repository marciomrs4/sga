
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
	
	//Criado para listar problemas dos tecnicos para abertura do chamado
	$listar('select[name="dep_codigo_tecnico"]').change(function() {

		var item = $listar('select[name="dep_codigo_tecnico"]').val();
		$listar.post('listarProblemaTecnico.php', 
				{dep_codigo: item },
				function(data){		
					$listar('select[name="pro_codigo"]').html(data);
				},
		'html');
		return false;
	});

	//Criado para listar as fases do projeto dentro do cadastro de atividade
	$listar('select[name="pro_codigo"]').change(function() {

		var item = $listar(this).val();

		$listar.post('listarFaseProjeto.php',
			{pro_codigo: item },
			function(data){
				$listar('select[name="fas_codigo"]').html(data);
			},
			'html');
		return false;
	});

	//Criado para listar as fases do projeto dentro do cadastro de atividade
	$listar('select[name="pro_codigo"]').change(function() {

		var item = $listar(this).val();
		var at_codigo = $listar('input[name=at_codigo]').val();


		$listar.post('listarAtividadeProjeto.php',
			{pro_codigo: item, at_codigo: at_codigo },
			function(data){
				$listar('select[name="at_codigo_dependente"]').html(data);
			},
			'html');
		return false;
	});

	//Criado para colocar o nome do usuario selecionado com a frase dentro o campo de assentamento.
	$listar('.usu_codigo_atendente').change(function() {

		var usuario = $listar('.usu_codigo_atendente option:selected').text();

		usuario = usuario.split(' ');

		$listar('textarea[name="ass_descricao"]').html(usuario[0] + ' por favor verificar.');

		return false;
	});


});