
var $submit = jQuery.noConflict();

$submit(function() 
{
	$submit(".pesquisando").click(

		function()
		{

			$submit(".pesquisando").hide("slow");
			
			$submit(".pesquisando").val("Pesquisando");
			
			$submit(".pesquisando").css("color","red");
			
			$submit(".pesquisando").show("slow");

		}
	)
	
});