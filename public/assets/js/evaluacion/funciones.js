$('document').ready(function(){

		$(document).on('click', '.eva-btnEnviar',  function(){
			
			var respuesta = new Array();

			var div 			 = $(this).parents('div'); //obtengo la data desde el contenedor de la pregunta
			var cadenaParametros = div.data('id'); //datos de pregunta que estoy respondiendo (test, pregunta, tipo)
			var parametrosArray  = cadenaParametros.split('_'); //datos de la pregunta en un arreglo.

			var test 			 = parametrosArray[0];
			var pregunta 		 = parametrosArray[1];
			var tipoPregunta     = parametrosArray[2];

			
			switch(tipoPregunta){

				case '1':

						var name = 'vof_'+test+pregunta;
						var resp = $('input:radio[name='+name+']:checked').val();
						
						if (resp === "" || typeof resp === "undefined"){

							if (confirm("¿Estás seguro que deseas enviar sin responder la pregunta?")){

								var respuestaAlumno = 0;

							}else{

								return;

							}

						}else{

							respuestaAlumno = resp;

						}

					break;
				case '2':
						//emparejamiento

					break;
				case '3':
						//Desarrollo
					break;	
				case '4':
						//respuesta alternativa
					break;		
				case '5':
						//Respuesta corta
					break;	
			}
			
			var form 			 = $('#resp_'+pregunta); //form para llamada ajax
			
			var token = $('#resp_'+pregunta+' input').val();

			var dataForm 		 = form.serialize(); //datos del form para llamada ajas serializados.
			
			var urlPost = form.attr('action');


			$.ajax({

				      url: urlPost,
				      type: "post",
				      data: {'_token': token, 'test':test, 'pregunta': pregunta, 'tipoPregunta':tipoPregunta, 'respuestaAlumno':respuestaAlumno },
				      success: function(resp){
				        alert(resp);
				      }

		    });


/*
			console.log(respuesta);

			respuestaJSON = JSON.stringify(respuesta);

			console.log(respuestaJSON);

			var form 			 = $('#resp_'+pregunta); //form para llamada ajax
			var dataForm 		 = form.serialize(); //datos del form para llamada ajas serializados.
			
			var url = form.attr('action').replace(':RESPDATA', respuesta);
			
			$.post(url, dataForm, function(response){
				alert(response);
			});	
					
					
			*/		
		});

});

