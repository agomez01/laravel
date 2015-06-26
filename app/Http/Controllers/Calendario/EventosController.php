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

	    	$data['success'] = true;

	    	$evento['id'] 	= 293;
	    	$evento['title'] 	= 'Event1';
	    	$evento['url'] 	= "http://example.com";
	    	$evento['class'] 	= "event-important";
	    	$evento['start'] 	= 12039485678000;
	    	$evento['end'] 	= 12039485678000;

	    	$data['result'] = $evento;

	    	


			return Response::json($data);

	    }

	    public function generaLink(){

	    	$this->href = 'http://localhost/sistema/desarrollo/externo.php?idusuario='.Session::get('idusuario')."&modulo=alumno&token=".Session::token();

	    }

	}
