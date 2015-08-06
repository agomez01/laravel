$(document).ready(function(){

	
	var pausa 	= false;
	var tiempor	= 0;


	var evaluacion = $("#idevaluacion").val();
	obtener_tiempo(evaluacion);

	var trm 	= iniciar();


	$(document).on('click', '#btn_continuar', function(){

		$("#pausa").trigger('click');

	});

	$(document).on('click', '#pausa', function(){

		if(!pausa){
			clearInterval(trm);
			$(this).text('Continuar');

			$(".cortina_pause").show();
			
			pausa = true;
		}else{
			trm = iniciar();
			$(this).text('Pausa');
			$(".cortina_pause").hide();
			pausa = false;
		}

	});

	function iniciar(){
		return setInterval(function(){
			timer.actualizar();			

			var tiempo = timer.imprimir();

			$("#cronometro").text(tiempo);

			if(timer.terminar){
				$("#eva-membretePrueba").hide();
				clearInterval(trm);
				alert("termino la prueba!");
			}
		},1000);
	}

	function obtener_tiempo(ev){

		$.ajax({

			url: '/evaluacion/'+ev+"/2",
			async: false,
			type: "get",
			dataType: 'json',
			success: function(data){
				if(data.estado){
					timer.horas 	= data.horas;
					timer.minutos	= data.minutos;
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