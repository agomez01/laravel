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

	        	case '12':
	        		return redirect(URL_PLATAFORMA.'/home/portada_utp.php');
	        	break;

	        	case '13':
	        		return redirect(URL_PLATAFORMA.'/home/portada_profesor.php');
	        	break;

	        	case '21':
	        		return redirect(URL_PLATAFORMA.'/home/portada_apoderado.php');
	        	break;

	        	case '2':
	        		return redirect(URL_PLATAFORMA.'/home/portada_admin_colegio.php');
	        	break;

	        	case '31':
	        		$testAbiertoAlumno = TestAlumno::getTestActivosDelAlumno($idalumno,$curso);
					$testCerradoAlumno = TestAlumno::getTestCerradosDelAlumno($idalumno,$curso);

	        		return view('alumno/home')
			        		->with('testAbiertos', $testAbiertoAlumno)
			        		->with('testCerrados', $testCerradoAlumno);
	        	break;
	        	
	        	default:
	        		return redirect(URL_PLATAFORMA);
	        		//abort(403, 'Unauthorized action.');
	        	break;
	        }

	    }


	}
