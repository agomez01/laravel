<?php
	namespace App\Http\Controllers\Alumno;

	use App\Http\Controllers\Controller;
	use App\models\Alumno;

	class AlumnoController extends Controller
	{

	    public function index(){

	        $alumnos = Alumno::paginate(15);
	        dd($alumnos);
	        //return view('home', ['alumnos', $alumnos]);

	    }

	    public function getPrueba(){

	    	return "Esto es una prueba";
	    }

	}
