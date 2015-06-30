<?php
	namespace App\Http\Controllers;

	use App\Http\Controllers\Controller;


	use App\models\Usuario;
	use App\models\Colegio;
	use App\models\Alumno;
	use App\models\Sesion;

	use App\models\Pregunta;

	use Session;

	class PruebaController extends Controller
	{

		public $href;

	    public function index(){

	    	dd(Session::all());

	    	/*$data = Pregunta::find(148573);
	    	foreach($data->misAlternativas as $alt){
	    		echo $alt->visible;
	    	}*/

	    }


	}
