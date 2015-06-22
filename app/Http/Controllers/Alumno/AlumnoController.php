<?php
	namespace App\Http\Controllers\Alumno;

	use App\Http\Controllers\Controller;
	use App\models\Alumno;
	use Session;
	use Request;
	use Response;
	
	class AlumnoController extends Controller
	{

	    public function index(){

	        $alumnos = Alumno::paginate(10);
	       


	        if (Request::ajax()) {
	            return Response::json( view('home')->with('alumnos', $alumnos) );
	        }

	        return view('home')->with('alumnos', $alumnos);

	    }

	    public function getPrueba(){

	    	return "Esto es una prueba";
	    }

	}
