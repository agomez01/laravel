$('document').ready(function(){

		$(document).on('click', '.eva-btnEnviar',  function(){
			
			var respuesta = new Array();

			var div 			 = $(this).parents('div'); //obtengo la data desde el contenedor de la pregunta
			var cadenaParametros = div.data('id'); //datos de pregunta que estoy respondiendo (test, pregunta, tipo)
			var parametrosArray  = cadenaParametros.split('_'); //datos de la pregunta en un arreglo.

			var test 			 = parametrosArray[0];
			var pregunta 		 = parametrosArray[1];
			var tipoPregunta     = parametrosArray[2];

			
			respuestaAlumno = obtenerRespuestaPregunta(test, pregunta, tipoPregunta,'0');

			enviarRespuesta(test, pregunta, tipoPregunta, respuestaAlumno);
			
			
	
		});

		$(document).on('click', '#eva-btnEnviarTodo',  function(){

			$("#eva-lanzaLoader").click(); //debe mostrar el loader

			if (confirm("¿Estás seguro que deseas enviar todo y terminar?")){


				var cantPreg = 0;
				$.each($('.eva-boxPregunta'), function (){

					cantPreg++;

				});

				var cant = 0;
				$.each($('.eva-boxPregunta'), function (){
						var cadenaParametros = $(this).data('id'); //datos de pregunta que estoy respondiendo (test, pregunta, tipo)
						var parametrosArray  = cadenaParametros.split('_'); //datos de la pregunta en un arreglo.

						var test 			 = parametrosArray[0];
						var pregunta 		 = parametrosArray[1];
						var tipoPregunta     = parametrosArray[2];

						
						//console.log (test, pregunta, tipoPregunta);
						respuestaAlumno = obtenerRespuestaPregunta(test, pregunta, tipoPregunta, '1');
						enviarRespuesta(test, pregunta, tipoPregunta, respuestaAlumno);

						cant++;

						//console.log(cantPreg, cant);
						
						setTimeout(
						   function(){
						      finalizarLaEvaluacion(test);
					    }, 10000);

						
				});

			}

		});


});

function finalizarLaEvaluacion(test)
{

	
	location.href = "/home";

}

function enviarRespuesta(test, pregunta, tipoPregunta, respuestaAlumno){

		var form 			 = $('#resp_'+pregunta); //form para llamada ajax
				
		var token = $('#resp_'+pregunta+' input').val();

		var dataForm 		 = form.serialize(); //datos del form para llamada ajas serializados.
		
		var urlPost = form.attr('action');

		

		$.ajax({

			      url: urlPost,
			      async: true,
			      type: "post",
			      data: {'_token': token, 'test':test, 'pregunta': pregunta, 'tipoPregunta':tipoPregunta, 'respuestaAlumno':respuestaAlumno },
			      success: function(resp){
			      		sendResposeMessenge(resp,pregunta, test, tipoPregunta);
			      }

	    });

}

function sendResposeMessenge(resp, idpregunta, test, tipoPregunta){
	//console.log(resp,idpregunta);
	idResp = resp.last_insert_id;
	if (idResp > 0){
		//alert("enviada"+idResp);
		$("#"+test+"_"+idpregunta+"_"+tipoPregunta).removeClass("eva-boxPregunta").addClass("eva-boxPreguntaResp");

		$("#respMessege"+idpregunta).html(resp.messege);
		$("#eva-minPregNum"+idpregunta).css(  'background-color', '#0BE409');
	}else{
		alert(resp.messege);
	}
}

function obtenerRespuestaPregunta(test, pregunta, tipoPregunta, todo){
		
		switch(tipoPregunta){

				case '1':

						var name = 'vof_'+test+pregunta;
						var resp = $('input:radio[name='+name+']:checked').val();
						
						if (resp === "" || typeof resp === "undefined")
						{
								if (todo === '1'){

										var respuestaAlumno = 2;

								}else{

										if (confirm("¿Estás seguro que deseas enviar sin responder la pregunta?")){

											var respuestaAlumno = 2;

										}else{

											return;

										}
								}

						}else{

								respuestaAlumno = resp;

						}

					break;
				case '2':
						//emparejamiento
						var clase = 'eva-RespEmpareja'+pregunta;
						var todasSinResp = true;
						var algunaSinResp = false;
						//alert(clase);
						var parejasArray = new Array();
						var x=0;
						$.each( $("."+clase), function (){

							var pareja = new Array();

						    var col1 = $(this).attr('id');
						    var col2 = $('#'+col1+' option:selected').val();

						    pareja[0] = col1;
						    pareja[1] = col2;

						    if(col2 != 0){
						    	todasSinResp = false;
						    }

						    if (col2 == 0){
						    	algunaSinResp = true;
						    }

						    
						    parejasArray[x] = JSON.stringify(pareja);
						    x++;
						});
							
							if(todasSinResp)
							{

								if (todo === '1'){

										respuestaAlumno = JSON.stringify(parejasArray);

								}else{

										if (confirm("¿Estás seguro que deseas enviar sin responder la pregunta?")){

											respuestaAlumno = JSON.stringify(parejasArray);

										}else{

											return;

										}
								}

							}else{

								if(algunaSinResp){

									if (todo === '1'){

											respuestaAlumno = JSON.stringify(parejasArray);

									}else{

											if (confirm("Falta una o más parejas que vincular. ¿Seguro deseas enviar la repuesta?")){

												respuestaAlumno = JSON.stringify(parejasArray);

											}else{

												return;

											}
									}


								}else{

									respuestaAlumno = JSON.stringify(parejasArray);
									
								}
							}

					break;
				case '3':
						
						respuestaAlumno = $("#des_"+test+pregunta).val();

						if (respuestaAlumno === ""){

							if (todo === '0'){

									if (!confirm("¿Estás seguro que deseas enviar sin responder la pregunta?")){

										return;
										
									}

							}

						}
						
					break;	
				case '4':
						//respuesta alternativa
						var name = 'respAlt_'+test+pregunta;
						var resp = $('input:radio[name='+name+']:checked').val();
						
						if (resp === "" || typeof resp === "undefined"){

							if (todo === '1'){

									var respuestaAlumno = 0;

							}else{

									if (confirm("¿Estás seguro que deseas enviar sin responder la pregunta?")){

										var respuestaAlumno = 0;

									}else{

										return;

									}
							}

						}else{

							respuestaAlumno = resp;

						}
					break;		
				case '5':
						
						respuestaAlumno = $("#cor_"+test+pregunta).val();

						if (respuestaAlumno === ""){

							if (todo === '0'){

									if (!confirm("¿Estás seguro que deseas enviar sin responder la pregunta?")){

										return;

									}

							}

							

						}

					break;	
			}

			return respuestaAlumno;

}




