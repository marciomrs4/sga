var $alert = jQuery.noConflict();

$alert(document).ready(function(){

	$alert('.close').click(function(){
		$alert("#myModal").hide(1000);
	});

	$alert(".panel-heading").click(
		function(){
			$alert(this).next().toggle(1000);
		});

});