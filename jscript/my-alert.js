var $alert = jQuery.noConflict();
$alert(document).ready(function(){
	$alert('.close').click(function(){
		$alert("#myModal").hide(1000);
	});

});