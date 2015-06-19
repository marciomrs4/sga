/*
var $submit = jQuery.noConflict();

$submit(document).ready(function(){

	$submit("#botaoSave").click(function(){
		
		
			var dados = $submit("#formlogin").serialize();
		 
			var icone = $submit('<img src="../../../sga/css/images/validador.gif">');


			$submit.ajax({
					type: "POST",
					 url: "login.php",
					data: dados,
					
					beforeSend: function()
					{
						//alert('Teste');
						$submit("#botaoSave").hide();
						$submit(".botaoSave").html(icone);
						//alert('Teste');
					},
					
					complete: function()
					{
						//alert('Complete');
				
					},
					
					success: function(data)
					{
						alert('Sucess');
						/*
						$submit(icone).remove();
						$submit(".btn-primary").show();
						$submit("#dadosform").html(data);
						
						$submit("#botaoSave").show();
						$submit(".botaoSave").html(icone);
	
					}
				});
			
			
	});
	

})(jQuery);

*/