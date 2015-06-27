<?php
	namespace App\Http\Controllers\Calendario;

	use App\Http\Controllers\Controller;


	use App\models\Usuario;
	use App\models\Colegio;
	use App\models\Alumno;
	use App\models\Sesion;

	use App\models\Pregunta;

	use Session;
	use Response;

	class EventosController extends Controller
	{


	    public function EventosJson(){

	    	$data['success'] = 1;

	    	$result = array();

	    	$evento['id'] 		= 293;
	    	$evento['title'] 	= "Event1";
	    	$evento['url'] 		= "http://example.com";
	    	$evento['class'] 	= "event-important";
	    	$evento['start'] 	= 1435345848140;
	    	$evento['end'] 		= 1435345848140;

	    	array_push($result, $evento);

	    	$evento['id'] 		= 293;
	    	$evento['title'] 	= "Event1";
	    	$evento['url'] 		= "http://example.com";
	    	$evento['class'] 	= "event-important";
	    	$evento['start'] 	= 1435345848140;
	    	$evento['end'] 		= 1435345848140;

	    	array_push($result, $evento);

	    	$data['result'] = $result;

			return Response::json($data);

	    }

	}
