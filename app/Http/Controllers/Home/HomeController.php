<?php
	namespace App\Http\Controllers\Home;

	use App\Http\Controllers\Controller;
	use App\models\TestAlumno;
	
	
	use Session;
	use Request;
	
	class HomeController extends Controller
	{

	    public function index(){

	        $rol 		= Session::get('rol');
	        $idalumno	= Session::get('idalumno');
	        $curso		= Session::get('curso');
	        switch ($rol) {

	        	case '31':

	        		$testAbiertoAlumno = TestAlumno::getTestActivosDelAlumno($idalumno,$curso);
					$testCerradoAlumno = TestAlumno::getTestCerradosDelAlumno($idalumno,$curso);

	        		return view('alumno/home')
			        		->with('testAbiertos', $testAbiertoAlumno)
			        		->with('testCerrados', $testCerradoAlumno);
	        	break;
	        	
	        }

	    }


	}
