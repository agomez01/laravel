$('document').ready(function(){

		 $("#menu-toggle,#close-toggle").click(function(e) {
	        e.preventDefault();
	        $("#wrapper").toggleClass("toggled");
	    });


		obtenerEstadotest($("#idevaluacion").val());

		paginar_preguntas();


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

			if (confirm("¿Estás seguro que deseas enviar todo y terminar?")){
				
				$("#eva-lanzaLoader").click(); //debe mostrar el loader

				var cantPreg = 0;

				$.each($('.eva-boxPregunta'), function (){
					cantPreg++;
				});

				var test = $(this).attr('data-test');

				var cant = 0;

				$.each($('.eva-boxPregunta'), function (){

						var cadenaParametros = $(this).data('id'); //datos de pregunta que estoy respondiendo (test, pregunta, tipo)
						var parametrosArray  = cadenaParametros.split('_'); //datos de la pregunta en un arreglo.

						//var test 			 = parametrosArray[0];
						var pregunta 		 = parametrosArray[1];
						var tipoPregunta     = parametrosArray[2];

						
						//console.log (test, pregunta, tipoPregunta);
						respuestaAlumno = obtenerRespuestaPregunta(test, pregunta, tipoPregunta, '1');
						enviarRespuesta(test, pregunta, tipoPregunta, respuestaAlumno);

						cant++;

						//console.log(cantPreg, cant);
						console.log(respuestaAlumno);
				});

				finalizarLaEvaluacion();
			}
		});


		$(document).on('click', '#btn_pausar_salir', function(){

			if (confirm("¿Estás seguro que pausar la evaluación?")){
				
				$("#eva-lanzaLoader").click(); //debe mostrar el loader

				var cantPreg = 0;

				$.each($('.eva-boxPregunta'), function (){
					cantPreg++;
				});

				var test = $(this).attr('data-test');

				var cant = 0;

				$.each($('.eva-boxPregunta'), function (){

						var cadenaParametros = $(this).data('id'); //datos de pregunta que estoy respondiendo (test, pregunta, tipo)
						var parametrosArray  = cadenaParametros.split('_'); //datos de la pregunta en un arreglo.

						//var test 			 = parametrosArray[0];
						var pregunta 		 = parametrosArray[1];
						var tipoPregunta     = parametrosArray[2];

						
						//console.log (test, pregunta, tipoPregunta);
						respuestaAlumno = obtenerRespuestaPregunta(test, pregunta, tipoPregunta, '1');
						enviarRespuesta(test, pregunta, tipoPregunta, respuestaAlumno);

						cant++;

						//console.log(cantPreg, cant);
						console.log(respuestaAlumno);
				});

				transcurrido();
			}

		});


	$(document).on('click', '#btn_continuar', function(){

		var test = $("#idevaluacion").val();

		$.ajax({
			url: '/evaluacion/'+test+"/7",
			async: true,
			type: "get",
			data: {'test': test },
			dataType: 'json',
			success: function(data){
				
				if (data.estado){
					console.log("continuar...");
				}			

			}
		});

	});


});


function transcurrido(){

	var test = $("#idevaluacion").val();

	$.ajax({
		url: '/evaluacion/'+test+"/6",
		async: true,
		type: "get",
		data: {'test': test },
		dataType: 'json',
		success: function(data){
			
			if (data.estado){
				location.href = "/home";
			}			

		}
	});
}



function finalizarLaEvaluacion(){

	var test = $("#idevaluacion").val();

	$.ajax({
		url: '/evaluacion/'+test+"/4",
		async: true,
		type: "get",
		data: {'test': test },
		dataType: 'json',
		success: function(data){
			
			if (data.estado){
				location.href = "/home";
			}			

		}
	});
}

function enviarRespuesta(test, pregunta, tipoPregunta, respuestaAlumno){

		var form 		= $('#resp_'+pregunta); //form para llamada ajax
		var token 		= $('#resp_'+pregunta+' input').val();
		var dataForm 	= form.serialize(); //datos del form para llamada ajas serializados.
		var urlPost 	= form.attr('action');

		$.ajax({
			url: urlPost,
			async: false,
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




function obtenerEstadotest(test){// variable 'test' en Base64

	var token = $("#tokenEvaluacion").val();

	$.ajax({
		url: '/evaluacion/'+test+"/3",
		async: true,
		type: "get",
		data: {'test': test },
		dataType: 'json',
		success: function(data){
			
			console.log(data);

		}
	});

}

	function comenzar_evaluacion(test){// variable 'test' en Base64

	}


	// lo creamos como variable global !!!
	var preg 	= new Array();				// array multidimencional
	var paginas;




	function paginar_preguntas(){

		var num 	= $("#porpagina").val();	// cantidad de pregutas por página

		if(num != 0){

			var cont 	= 0;						// contador de preguntas
			var pag 	= 1;						// número de página 

			// obtenemos la cantidad de preguntas
			var nump = $(".div_pregunta").length;


			// Calculamos la cantidad de páginas
			paginas = nump / num;
			if( (nump%num) > 0 ){
				paginas = paginas+1;
			}

			// creamos la matriz con los array dependiendo de la cantidad de paginas
			for (var i = 1; i <= paginas; i++) {
				preg[i] = new Array();
			};


			// creamos un array multidimencional, separando las preguntas por página
			$.each($(".div_pregunta"), function(){
				preg[pag][cont] = $(this).attr('data-id');
				cont++;

				if(cont == num ){
					cont = 0;
					pag ++;
				}

			});

			// mostramos la pagina actual y la cantidad total Ejem: 1/6
			$("#num_pag").text("1/"+paginas);

			paginar();

		}else{
			$("#navegacion").hide();
		}


	}

	function paginar(num){

		var num 	= $("#porpagina").val();	// cantidad de pregutas por págin
		
		var pagina_actual	= $("#pag").val();

		// ocultamos todas las prgeuntas
		$(".div_pregunta").hide();

		// luego mostramos solo las preguntas correspondientes
		// a la página seleccionada
		$.each(preg[pagina_actual], function(i,v){
			$(".div_pregunta[data-id='"+v+"']").show();
		});

		console.log(preg[pagina_actual]);

	}

	$(document).on('click', '#pag_ant', function(){

		//obtenemos la página actual
		var pag = parseInt($("#pag").val());

		pag--;

		$("#num_pag").text(pag+"/"+paginas);
		$("#pag").val(pag);

		// ejecutamos la paginación
		paginar();

		// si alcanzamos el mínimo de paginas deshabilitamos el botón
		if(pag == 1){
			$(this).attr('disabled', true);
		}

		// al restar una página nos aseguramos siempre de habilitar el botón siguiente !
		$('#pag_sig').attr('disabled', false);

	});

	$(document).on('click', '#pag_sig', function(){

		//obtenemos la página actual
		var pag = parseInt($("#pag").val());

		pag++;
		
		$("#num_pag").text(pag+"/"+paginas);
		$("#pag").val(pag);

		// ejecutamos la paginación
		paginar();

		// si alcanzamos el tope de paginas deshabilitamos el botón
		if(pag == paginas){
			$(this).attr('disabled', true);
		}

		// al sumar una página nos aseguramos siempre de habilitar el botón anterior !
		$('#pag_ant').attr('disabled', false);

	});	

