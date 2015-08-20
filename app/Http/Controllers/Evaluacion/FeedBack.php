<?php

namespace App\Http\Controllers\Evaluacion;
use App\Http\Controllers\Controller;


use App\models\Test;
use App\models\TestAlumno;

use App\models\TestPregunta;
use App\models\Pregunta;

use App\models\PreguntaAlternativa;
use App\models\PreguntaEmparejamiento;
use App\models\PreguntaEmparejamientoVinculo;
use App\models\PreguntaCorta;
use App\models\PreguntaVof;


use App\models\RespuestaAlternativa;
use App\models\RespuestaAlternativaAlumno;
use App\models\RespuestaCortaAlumno;
use App\models\RespuestaDesarrolloAlumno;
use App\models\RespuestaEmparejaAlumno;
use App\models\RespuestaVofAlumno;
use App\models\Resultado;


use App\models\Usuario;
use Session;
use Input;
use DB;
use Request;
use Response;


class FeedBack extends Controller
{

	/**
     * Obtenemos el feedback de la pregunta AL RESPONDERLA
     *
     * @param  int  $pregunta
     * @param  varchar  $test
     * @return Response JSON
     */

	public function getFeed($test, $pregunta, $tipo){

		$data 	= array();
		$alumno = Session::get('idalumno');

		# Comprobamos que esté logeado como alumno
		if(empty($alumno)){
			$data['estado'] = false;
			$data['error'] 	= "No se encuentra variable 'idalumno' !";
			return Response::json($data);
		}else{
			$data['div']	= $test."_".$pregunta."_".$tipo;
		}

		$eval = Test::find($test);

		$feed = $this->decimal_a_binario($eval->modulos);

		$preg = Pregunta::find($pregunta);

		if(count($feed)>0){
			for($i=0;$i<count($feed);$i++){

				# al obtener el feed de pregunta respondida solo recorremos hasta la quinta posición

				switch ($i) {
					case 0: #RESPUESTAS - respuesta del alumno [al responder se oculta el div de la pregunta y e muestra solo la respuesta]
						if($feed[$i]){
							$data['respuesta'] = $this->getRespuestaAlumno($test, $pregunta, $preg->tipo);
						}	
					break;

					case 1: #SOLUCIONES   - corrección
						if($feed[$i]){
							$data['correccion']	= $preg->correccion;
						}	
					break;

					case 2: #COMENTARIO
						/*if($feed[$i]){
							$data['comentario'] = $this->getComentarioRespuesta($pregunta, $preg->tipo);
						}*/
					break;

					case 3: #RETROALIMENTACIÓN GENERAL
						if($feed[$i]){
							$data['retro']	=	$preg->retroalimentacion;
						}	
					break;
					
					case 4: #PUNTUACIONES
						if($feed[$i]){
							$data['puntuacion']	=	$this->getPuntuacion($test, $pregunta);
						}	
					break;
				}

				$data['estado'] = true;

			}
		}else{
			$data['estado'] = false;
		}

			

		

		return Response::json($data);
	}

	public function getRespuestaAlumno($test, $pregunta, $tipo){

		switch ($tipo) {
			case 1:
				$respuesta = RespuestaVofAlumno::where('idpregunta', $pregunta)
												->where('idtest', $test)
												->where('idalumno', Session::get('idalumno'))
												->first();


				if($respuesta->respuesta){
					$r = "Verdadera - ".$respuesta->justificacion;
				}else{
					$r = "Falsa - ".$respuesta->justificacion;
				}

				return $r;
			break;

			case 2:
				$respuesta = RespuestaEmparejaAlumno::where('idpregunta', $pregunta)
													->where('idtest', $test)
													->where('idalumno', Session::get('idalumno'))
													->get();

				$r = '';

				foreach ($respuesta as $resp) {
					$rutaA = $resp->rordena->texto;
					$rutaB = $resp->rordenb->texto;

					$r .= "<div class='rempareja'>$rutaA<div class='union'>-></div>$rutaB </div><br>";
				}

				return $r;

			break;

			case 3:
				$respuesta = RespuestaDesarrolloAlumno::where('idpregunta', $pregunta)
														->where('idtest', $test)
														->where('idalumno', Session::get('idalumno'))
														->first();

				return $respuesta->respuesta;


			break;

			case 4:
				$respuesta = RespuestaAlternativaAlumno::where('idpregunta', $pregunta)
														->where('idtest', $test)
														->where('idalumno', Session::get('idalumno'))
														->first();

				return $respuesta->ralternativa->texto;

			break;

			case 5:
				$respuesta = RespuestaCortaAlumno::where('idpregunta', $pregunta)
														->where('idtest', $test)
														->where('idalumno', Session::get('idalumno'))
														->first();

				return $respuesta->respuesta;
			break;
		}
	}

	public function getPuntuacion($test, $pregunta){

		$resultado = Resultado::where('pregunta', $pregunta)
								->where('test', $test)
								->where('alumno', Session::get('idalumno'))
								->first();

		$puntaje_obtenido = $resultado->puntaje;

		$pregunta = TestPregunta::where('pregunta', $pregunta)
								->where('test', $test)
								->first();

		$puntaje_total = $pregunta->puntaje;

		return $puntaje_obtenido."/".$puntaje_total;
		
	}

	public function decimal_a_binario($decimal){

 		$cuociente = (int)$decimal;
 		$binario = array();
		while($cuociente >= 1)	
		{
			$resto =  $cuociente % 2; 
			$cuociente = (int)($cuociente / 2); 				 
			$binario[] = $resto;
		}
		//return array_reverse($binario);
		return $binario;
	}
}