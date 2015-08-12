$(document).ready(function(){

	var infinito	= false;
	var pausa 		= false;
	var tiempor		= 0;
	var trm;

	var evaluacion = $("#idevaluacion").val();
	
	obtener_tiempo(evaluacion);

	


	$(document).on('click', '#btn_continuar', function(){

		$("#pausa").trigger('click');

	});

	$(document).on('click', '#pausa', function(){

		if(!pausa){
			clearInterval(trm);
			$(this).text('Continuar');

			$(".cortina_pause").show();
			
			pausa = true;

			pausarEvaluacion();
		}else{
			trm = iniciar();
			$(this).text('Pausa');
			$(".cortina_pause").hide();
			pausa = false;
		}

	});

	function iniciar(){

		if(!infinito){
			return setInterval(function(){
				timer.actualizar();			

				var tiempo = timer.imprimir();

				$("#cronometro").text(tiempo);

				if(timer.terminar){
					$("#eva-membretePrueba").hide();
					clearInterval(trm);
					alert("termino la prueba!");

					guardarTerminar();
				}
			},1000);
		}
	}

	function guardarTerminar(){

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

	function pausarEvaluacion(){

		var test = $("#idevaluacion").val();

		$.ajax({
			url: '/evaluacion/'+test+"/5",
			async: true,
			type: "get",
			data: {'test': test },
			dataType: 'json',
			success: function(data){
				
				console.log(data);

			}
		});
	}

	function obtener_tiempo(ev){

		$.ajax({

			url: '/evaluacion/'+ev+"/2",
			async: false,
			type: "get",
			dataType: 'json',
			success: function(data){

				console.log(data);

				if(data.estado){

					if(!data.infinito){

						timer.horas 	= data.horas;
						timer.minutos	= data.minutos;
						timer.segundos  = data.segundos;
						trm = iniciar();
						infinito = false;
							
					}else{

						$("#cronometro").text('Sin tiempo.');
						infinito = true;
					}
				}else{
					if(data.agotado){
						console.log("tiempo agotado");
						$("#cronometro").text('Tiempo agotado.');
						finalizarLaEvaluacion();
					}
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

});


var timer = {

	horas: 0,
	minutos: 0,
	segundos: 0,
	terminar: false,

	actualizar: function(){

		var estado_s = false;
		var estado_m = false;
		var terminar = false;

		if(!timer.terminar){

			if(timer.segundos == 0){
				estado_s = true;
			}else{
				estado_s = false;
			}

			if(timer.minutos == 0){
				estado_m = true;
			}else{
				estado_m = false;
			}

			if(estado_s){
				timer.segundos = 59;
				timer.minutos--;
			}else{
				timer.segundos--;
			}

			if(estado_m){
				if(timer.horas != 0){
					timer.minutos = 59;
					timer.horas--;
				}			
			}

			if(timer.horas == 0 && timer.minutos == 0 && timer.segundos == 0){
				timer.terminar = true;
				return false;
			}
		}else{
			return false;
		}		
	},

	imprimir: function(){

		var h = timer.horas;
		var m = timer.minutos;
		var s = timer.segundos;

		if(h < 10)	{	h 	= '0'+h;	}
		if(m < 10)	{	m 	= '0'+m;	}
		if(s < 10)	{	s 	= '0'+s;	}
	
		var tiempo = h+":"+m+":"+s;
		
		return tiempo;
	}

}