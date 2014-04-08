//Cria o evendo datepicker

//{prefillDate:false} : Serve para que a data 
//não seja preenchida ao carregar a pagina

window.addEvent('domready', function() 
		{

					new vlaDatePicker('data-id',{prefillDate:false});
					new vlaDatePicker('data',{prefillDate:false});
					new vlaDatePicker('data2-id',{prefillDate:false});
					
});