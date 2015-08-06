$(document).ready(function(){


	/*
		se parsearan las imagenes que no contengan una dirección completa a recursos
	*/
	var url_recursos = $("#url_recursos").val();
	$("img").each(function(i){

		var url = $(this).attr('src');
		var c = url.search(/http/i);

		if(c < 0){
			$(this).attr('src', url_recursos+url);
		}

	});

});