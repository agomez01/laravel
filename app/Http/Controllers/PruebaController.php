<?php
	namespace App\Http\Controllers;

	use App\Http\Controllers\Controller;


	use App\models\Usuario;
	use App\models\Colegio;
	use App\models\Alumno;

	use Session;

	class PruebaController extends Controller
	{

	    public function index(){
	       
	        dd(Session::all());

	    }

	}
