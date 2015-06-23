<?php
	namespace App\Http\Controllers;

	use App\Http\Controllers\Controller;


	use App\models\Usuario;
	use App\models\Colegio;
	use App\models\Alumno;
	use App\models\Sesion;
	use App\models\Curso;

	use Session;
	use DB;

	class PruebaController extends Controller
	{

		public $href;

	    public function index(){


	    	$curso = DB::table('usuario')
	    				->join('alumno', 'usuario.id', '=', 'alumno.alumno')
	    				->join('curso', 'curso.id', '=', 'alumno.curso')
	    				->where('alumno.habilitado', 1)
	    				->where('alumno.estado', 1)
	    				->orderBy('curso.ano', 'DESC')
	    				->first();

	    	dd($curso);

	    	
	    	/*

	    	$this->generaLink();

	       
	        return "<a href='".$this->href."'>Prueba</a>";*/

	    }

	    public function generaLink(){

	    	$this->href = 'http://localhost/sistema/desarrollo/externo.php?idusuario='.Session::get('idusuario')."&modulo=alumno&token=".Session::token();

	    }

	}
