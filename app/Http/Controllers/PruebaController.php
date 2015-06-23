<?php
	namespace App\Http\Controllers;

	use App\Http\Controllers\Controller;


	use App\models\Usuario;
	use App\models\Colegio;
	use App\models\Alumno;
	use App\models\Sesion;

	use Session;

	class PruebaController extends Controller
	{

		public $href;

	    public function index(){

	    	$this->generaLink();

	       
	        return "<a href='".$this->href."'>Prueba</a>";

	    }

	    public function generaLink(){

	    	$this->href = 'http://localhost/sistema/desarrollo/externo.php?idusuario='.Session::get('idusuario')."&modulo=alumno&token=".Session::token();

	    }

	}
