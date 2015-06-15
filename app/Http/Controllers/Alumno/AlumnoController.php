<?php
	namespace App\Http\Controllers\Alumno;

	use App\Http\Controllers\Controller;


	class AlumnoController extends Controller
	{

	    public function getIndex(){

	        $return = \DB::table('noticias')
	        	->select(['id', 'titulo', 'mensaje'])
	        	->where('visible', '!=' ,1)
	        	->orderBy('id', 'ASC')
	        	#->join('tabla', 'alumno.id', '=', 'tabla.idalumno')
	        	->get();

	        dd($return);

	        return $return;
	        
	    }

	}
