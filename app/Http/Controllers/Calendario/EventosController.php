<?php
	namespace App\Http\Controllers\Calendario;

	use App\Http\Controllers\Controller;


	use App\models\Evento;
	use App\models\UsuarioDetalle;

	use Session;
	use Response;

	class EventosController extends Controller
	{


	    public function EventosJson(){

	    	$result = array();

	    	# Eventos personales
		    	$e = Self::getEventosPersonales(Session::get('idusuario'));

		    # Eventos Generales
		    # Eventos UTP


	    	$data['success'] = 1;
	    	$data['result'] = $e;

	    	return Response::json($data);

	    }

	    public function getEvento($id){

	    	// el formato de respuesta corresponde al plugin Bootstrap Calendar que es "html"

	    	$evento = Evento::find($id);

	    	$data['titulo']	=	'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
	    	$data['titulo'] .= "<h3>".$evento->nombre."</h3>";
	    	$data['descripcion'] 	= "<p>".$evento->descripcion."</p>";

	    	return Response::json($data);
	    }

	    static function getEventosPersonales($usuario){

	    	$eventos_personales = Evento::where('visible', 1)
	    								->where('usuario', $usuario)->get();

	    	$lista_eventos = array();


	    	foreach ($eventos_personales as $evento) {

	    		$event['id'] 		= $evento->id;
		    	$event['title'] 	= $evento->nombre;
		    	$event['url'] 		= '';
		    	$event['class'] 	= "evento-".$evento->evento_tipo->nombre;
		    	$event['start'] 	= strtotime($evento->fecha_inicio)."000";
		    	$event['end'] 		= strtotime($evento->fecha_termino)."000";

				array_push($lista_eventos, $event);
	    	}




	    	return $lista_eventos;
	    }



	}
