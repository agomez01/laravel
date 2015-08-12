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


	    public function index(){

	    	$duracion = round(30.650000000001, 2);

	    	$seg = explode('.', $duracion);
	    	$seg = $seg[1];

	    	echo $horas  = $duracion / 60;
	    	echo "<br>";

            $horas  = explode('.', $horas);


            echo "Horas:". $horas  = intval($horas[0]);
            echo "<br>";
            echo "Minutos: ".$minutos = $duracion % 60;
            echo "<br>";
            echo "Segundos: ".$seg ."% de un minuto";
            echo "<br>";
            echo "Segundos: ".round(($seg*60)/100, 0);

            /*if($seg>0){
                $x = (60*$seg)/100;
                $datos['segundos']  = round($x,0);
            }else{
                $datos['segundos']  = 0;
            }*/

	    }


	}
