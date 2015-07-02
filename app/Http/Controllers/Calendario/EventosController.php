<?php
	namespace App\Http\Controllers\Calendario;

	use App\Http\Controllers\Controller;


	use App\models\Evento;
	use App\models\UsuarioDetalle;

	use Session;
	use Response;
	use Request;

	class EventosController extends Controller
	{

		public $eventos = array();


	    public function EventosJson(){


	    	$eventos = Request::get('eventos');

	    	$eventos = explode(',', $eventos);

	    	if($eventos[0]){# Global
	    		Self::getEventosGlobales(Session::get('colegio'));
	    	}

	    	if($eventos[1]){# Curso
				Self::getEventosCurso(Session::get('curso'));
	    	}

	    	if($eventos[2]){# Personal
	    		Self::getEventosPersonales(Session::get('idusuario'));
	    	}

	    	
	    	
	    	

	    	$data['success'] = 1;
	    	$data['result'] = $this->eventos;

	    	return Response::json($data);
	    }


	    public function getEventosPersonales($usuario){

	    	$eventos = Evento::where('visible', 1)
	    						->where('tipo', 1)
	    						->where('usuario', $usuario)->get();

	    	$this->generaArrayEventos($eventos);
	    }

	    public function getEventosGlobales($colegio){

	    	$eventos = Evento::where('visible', 1)
	    						->where('tipo', 2)
	    						->where('colegio', $colegio)->get();

	    	$this->generaArrayEventos($eventos);
	    }

	    public function getEventosCurso($curso){

	    	$eventos = Evento::where('visible', 1)
	    						->where('tipo', 3)
	    						->where('curso', $curso)->get();

	    	$this->generaArrayEventos($eventos);
	    }


	    public function getEvento($id){
	    	// el formato de respuesta corresponde al plugin Bootstrap Calendar que es "html"

	    	$evento = Evento::find($id);

	    	$data['titulo']	=	'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
	    	$data['titulo'] .= "<h3>".$evento->nombre."</h3>";
	    	$data['descripcion'] 	= "<p>".$evento->descripcion."</p>";

	    	return Response::json($data);
	    }

	    public function generaArrayEventos($eventos){

	    	$lista_eventos = array();

	    	foreach ($eventos as $evento) {

	    		$event['id'] 		= $evento->id;
		    	$event['title'] 	= $evento->nombre;
		    	$event['url'] 		= '';
		    	$event['class'] 	= "evento-".$evento->evento_tipo->nombre;
		    	$event['start'] 	= strtotime($evento->fecha_inicio)."000";
		    	$event['end'] 		= strtotime($evento->fecha_termino)."000";

		    	array_push($this->eventos, $event);
				array_push($lista_eventos, $event);
	    	}

	    	return $lista_eventos;
	    }



	}
