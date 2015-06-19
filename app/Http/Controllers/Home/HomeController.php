<?php
	namespace App\Http\Controllers\Home;

	use App\Http\Controllers\Controller;
	use App\models\Alumno;
	use Session;
	use Request;
	
	class HomeController extends Controller
	{

	    public function index(){

	        $rol = Session::get('rol');

	        switch ($rol) {
	        	case '1':

	        		$alumno ='Seba';


	        		return view('alumno/home')->with('alumno', $alumno)
	        								->with('alumno', $alumno);
	        	break;
	        }

	    }

	    public function getPrueba(){

	    	return "Esto es una prueba";
	    }

	}
