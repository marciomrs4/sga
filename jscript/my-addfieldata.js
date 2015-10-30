var $ata = jQuery.noConflict();


$ata(document).on('click','#adcionarparticipante',function(){

	$campo = "<tr><th>Participantes:<span id='removerparticipante'>Remover</span></th><td><input name='ata_participantes[]' type='text' size='40' maxlength='255' /></td></tr>";

	$ata("#inserirparticipante").appendTo($campo);

	//alert('Alert');

});


$ata(document).on('click','#mostrarpauta',function(){

	//alert('asdada');
	$ata("#pautadereuniao").show();

});