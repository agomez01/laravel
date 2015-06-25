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

	    	$data = Pregunta::find(148573);
	    	foreach($data->misAlternativas as $alt){
	    		echo $alt->visible;
	    	}

	    }

	    public function generaLink(){

	    	$this->href = 'http://localhost/sistema/desarrollo/externo.php?idusuario='.Session::get('idusuario')."&modulo=alumno&token=".Session::token();

	    }

	}
