
var $a = jQuery.noConflict();

$a(document).ready(function(){

	$a(".real").maskMoney({showSymbol:true,symbol:"", decimal:",", thousands:".", allowZero:true});
	$a(".valor").maskMoney({showSymbol:true,symbol:"", decimal:",", thousands:".", allowZero:true});
	
});