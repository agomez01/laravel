<?php

namespace App\Http\Controllers\Evaluacion;



use App\models\Test;
use App\models\TestAlumno;
use App\models\TestPregunta;
use App\models\Prueba;
use App\models\Pregunta;
use App\models\PreguntaAlternativa;
use App\models\PreguntaEmparejamiento;
use App\models\PreguntaEmparejamientoVinculo;
use App\models\PreguntaCorta;
use App\models\PreguntaVof;



use App\models\RespuestaAlternativaAlumno;
use App\models\RespuestaCortaAlumno;
use App\models\RespuestaDesarrolloAlumno;
use App\models\RespuestaEmparejaAlumno;
use App\models\RespuestaVofAlumno;
use App\models\Resultado;


use App\models\Usuario;
use StdClass;
use Session;
use Input;
use DB;
use Request;
use Response;
use App\Http\Controllers\Controller;

class EvaluacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
        public function index($data,$action)
        {

             $data = base64_decode($data);

            switch($action){
                case 0:
                        $dataTest = Test::find($data);
                                            
                        $test["id"]      = $dataTest->id;
                        $test["nombre"]      = $dataTest->miPrueba->titulo;
                        $test["nivel"]       = $dataTest->miPrueba->miSector->miNivel->nombre;
                        $test["asignatura"]  = $dataTest->miPrueba->miSector->nombre;
                        $test["duracion"]    = $dataTest->duracion;
                 
                        return view('evaluacion/portadaEvaluacion')->with('test', $test);
                break;

                case 1:
                        $dataTest       = Test::find($data);

                        $dataPrueba     = Prueba::find($dataTest->prueba);

                        //$preguntasTest  = TestPregunta::where('test', $dataTest->id)->orderBy('orden', 'desc')->get(); //Esta es la tabla vinculante entre test y las preguntas.
                        
                        
                        if ($dataTest->barajar === 1){

                                $preguntasTest  = TestPregunta::where('test', $dataTest->id)->orderBy(DB::raw('RAND()'))->get(); //Esta es la tabla vinculante entre test y las preguntas.
                        }
                        else{
                                $preguntasTest  = TestPregunta::where('test', $dataTest->id)->orderBy('orden', 'asc')->get(); //Esta es la tabla vinculante entre test y las preguntas.
                        }
                        

                        
                        $preguntas      = EvaluacionController::obternerContenidoDePreguntasDelTest($preguntasTest, $dataTest->id, $dataTest->barajar_resp); //Este es un arreglo que contiene todas las preguntas de la prueba y su contenido.
                        
                        $dataAutor = Usuario::find($dataTest->profesor);
                        
                        $test["id"]          = $dataTest->id;
                        $test["autor"]       = $dataAutor->usuario_detalle->full_name;
                        $test["instrucciones"] = $dataPrueba->instrucciones;
                        $test["prueba"]      = $dataTest->miPrueba->id;
                        $test["nombre"]      = $dataTest->miPrueba->titulo;
                        $test["nivel"]       = $dataTest->miPrueba->miSector->miNivel->nombre;
                        $test["asignatura"]  = $dataTest->miPrueba->miSector->nombre;
                        $test["duracion"]    = $dataTest->duracion;
                        $test["porpagina"]    = $dataTest->preg_por_pag;

                        //dd($test);
                        //dd($preguntas);
                        return view('evaluacion/rendirEvaluacion')->with('test', $test)->with('preguntas', $preguntas);
                break;

                case 2:

                    $dataTest = Test::find($data);

                    $testAlumno = TestAlumno::where('test', $dataTest->id)
                                            ->where('alumno', Session::get('idalumno'))->first();
                    

                    if(count($dataTest)>0){
                        
                        if (!$dataTest->tiempo_infinito) {

                            if($testAlumno->minutos < $dataTest->duracion){

                                if($testAlumno->minutos > 0){
                                    $datos['duracion']  = round(($dataTest->duracion - $testAlumno->minutos),2);
                                }else{
                                    $datos['duracion']  = round($dataTest->duracion, 2);
                                }

                                // obtenemos la hora de este modo ya que no funcionó el round y PHP_ROUND_HALF_DOWN !


                                $horas  = $datos['duracion'] / 60;


                                # comprobamos que hayan segundos (decimales)
                                if(strrpos($horas, '.') !== false){
                                    $horas  = explode('.', $horas);
                                    $horas  = intval($horas[0]);
                                    $seg    = explode('.', $datos['duracion']);
                                    $seg = $seg[1];
                                }else{
                                    $seg = 0;
                                }                            

                                if($seg>0){
                                    $datos['segundos']  = round(($seg*60)/100, 0);
                                }else{
                                    $datos['segundos']  = $seg;
                                }

                                $datos['estado']    = true;
                                $datos['horas']     = $horas;
                                $datos['minutos']   = $datos['duracion'] % 60;
                                $datos['infinito']  = false;

                            }else{
                                $datos['error']     = 'tiempo agotado';
                                $datos['agotado']   = true;
                                $datos['estado']    = false;
                            }                                

                        }else{
                            $datos['estado']    = true;
                            $datos['infinito']  = true;
                        }
                        
                    }else{
                        $datos['error']     = 'no existe la evaluación.';
                        $datos['estado']    = false;
                    }

                    echo json_encode($datos);

                break;

                case 3:
                    # OBTENER ESTADO DE EVALUACION

                    $test = TestAlumno::where('test', $data)
                                        ->where('alumno', Session::get('idalumno'))->first();

                    $data = array();

                    if($test->realizado == 0){

                        if($test->t_inicio == 0){

                            $test->t_inicio = time();
                            $test->t_pausa = $test->t_inicio;
                            $test->save();

                            $data['inicio'] = true;

                        }else{

                            $now = time();

                            $pausa = $now - $test->t_pausa;
                            //echo "\n";
                            $pausa = $pausa/60;

                            $test->t_pausa = $now;
                            $test->minutos += $pausa;
                            $test->save();
                        }

                        $data['realizado'] = false;
                    }else{
                        $data['realizado'] = true;
                    }


                    echo json_encode($data);

                break;

                case 4:
                    # FINALIZAR EVALUACION
                    
                    $datos = array();
                    
                    $test = TestAlumno::where('test', $data)
                                        ->where('alumno', Session::get('idalumno'))->first();

                    if($test->realizado != 1){

                        $test->realizado = 1;
                        $test->t_termino = time();

                        if($test->save()){
                            $datos['estado'] = true;
                        }else{
                            $datos['error'] = 'Error al finalizar test.';
                            $datos['estado'] = false;
                        }

                    }else{
                        $datos['error'] = 'Test ya se encuentra cerrado.';
                        $datos['estado'] = false;
                    }
                    
                    echo json_encode($datos);

                break;

                case 5:
                    # PAUSAR EVALUACION

                    $datos = array();

                    $test = TestAlumno::where('test', $data)
                                        ->where('alumno', Session::get('idalumno'))->first();



                    if($test->realizado == 1){

                        $datos['error'] = 'Test ya se encuentra cerrado.';
                        $datos['estado'] = false;

                    }else{

                        $now = time();
                        $pausa = $now - $test->t_pausa;
                        $pausa = $pausa/60;
                        $test->t_pausa = $now;
                        $test->minutos += $pausa;

                        if($test->save()){
                            $datos['estado'] = true;
                        }else{
                            $datos['error'] = 'Error al pausar test.';
                            $datos['estado'] = false;
                        }
                    }

                    echo json_encode($datos);
                break;
                
                case 6:
                    # REGISTRA TIEMPO TRANSCURRIDO

                    $datos = array();

                    $test = TestAlumno::where('test', $data)
                                        ->where('alumno', Session::get('idalumno'))->first();



                    if($test->realizado == 1){

                        $datos['error'] = 'Test ya se encuentra cerrado.';
                        $datos['estado'] = false;

                    }else{

                        $now = time();
                        $test->t_transcurrido = $now;

                        if($test->save()){
                            $datos['estado'] = true;
                        }else{
                            $datos['error'] = 'Error al registrar tiempo transcurrido.';
                            $datos['estado'] = false;
                        }
                    }

                    echo json_encode($datos);
                break;

                case 7:
                    # CONTINUAR PAUSA
                    # solo actualiza la variable t_pausa

                    $datos = array();

                    $test = TestAlumno::where('test', $data)
                                        ->where('alumno', Session::get('idalumno'))->first();



                    if($test->realizado == 1){

                        $datos['error'] = 'Test ya se encuentra cerrado.';
                        $datos['estado'] = false;

                    }else{

                        $test->t_pausa = time();

                        if($test->save()){
                            $datos['estado'] = true;
                        }else{
                            $datos['error'] = 'Error al pausar test.';
                            $datos['estado'] = false;
                        }
                    }

                    echo json_encode($datos);
                break;

            }
            
        }

    public static function corregirLaPregunta($tipoPregunta, $registro){

        switch ($tipoPregunta) {
            case 1:
                //VERDADERO O FALSO
                $pregunta = PreguntaVof::where('pregunta', $registro->idpregunta)->first();
                
                if (intval($registro->respuesta) === 2){
                    //EL ALUMNO OMITIO LA PREGUNTA, SE ASIGNA PUNTAJE CERO EN RESULTADOS Y RESPUESTA VOF ALUMNO
                    $puntaje = 0;
                    $contestada = 0;

                }else if (intval($registro->respuesta) === intval($pregunta->verdadero)){
                    //LA RESPUESTA DEL ALUMNO ES IGUAL A LA DE LA BASE DE DATOS, ES CORRECTA 
                    $puntaje = $pregunta->puntaje;
                    $contestada = 1;

                }else{
                    //ES INCORRECTA
                    $puntaje = 0;
                    $contestada = 1;

                }

                $resultado = new Resultado;
                $resultado->test = $registro->idtest;
                $resultado->alumno = $registro->idalumno;
                $resultado->pregunta = $registro->idpregunta;
                $resultado->puntaje = $puntaje;
                $resultado->contestada = $contestada;
                $resultado->save();
                
                $RespuestaVofAlumno = RespuestaVofAlumno::where('idtest',$registro->idtest)->where('idalumno',$registro->idalumno)->where('idpregunta',$registro->idpregunta)->first();
                $RespuestaVofAlumno->puntaje = $puntaje;
                $RespuestaVofAlumno->save();

                break;
            
            case 2:
                //$preguntaParejas = PreguntaEmparejamientoVinculo::where('pregunta', $registro->idpregunta)->get();

                //Necesito el puntaje de la pregunta en el test.
                $dataPregunta = TestPregunta::where('test',$registro->idtest)->where('pregunta', $registro->idpregunta)->first();

                $parejas = $registro->respuesta;

                $cantVinculos = count($parejas);
                
                $puntajePregunta = $dataPregunta->puntaje;
                $puntosPorPareja = $puntajePregunta/$cantVinculos;

                $puntaje = 0; 
                $contestada = 0;

                foreach($parejas as $pos=>$val)
                {

                    $respuestaAlumno = json_decode($val);
                    $correcta = PreguntaEmparejamientoVinculo::where('vinculo_a', $respuestaAlumno[0])->first();
                    $vinculo_b = $correcta->vinculo_b;

                    if (intval($respuestaAlumno[1]) != 0)
                    {
                        
                        $contestada = 1;
                        if ( intval($respuestaAlumno[1]) === intval($vinculo_b) )
                        {

                            $puntaje = $puntaje + $puntosPorPareja;

                            $RespuestaEmpAlumno = RespuestaEmparejaAlumno::where('idtest',$registro->idtest)->where('idalumno',$registro->idalumno)->where('idpregunta',$registro->idpregunta)->where('vinculo_a', $respuestaAlumno[0])->first();
                            $RespuestaEmpAlumno->puntaje = $puntosPorPareja;
                            $RespuestaEmpAlumno->save();
                        }

                    }

                }

                $resultado = new Resultado;
                $resultado->test = $registro->idtest;
                $resultado->alumno = $registro->idalumno;
                $resultado->pregunta = $registro->idpregunta;
                $resultado->puntaje = $puntaje;
                $resultado->contestada = $contestada;
                $resultado->save();
                
                break;

            case 3:
               //DESARROLLO)
                if($registro->respuesta != '') 
                { 

                    $contestada = 2; 

                } 
                else 
                { 

                    $contestada = 0; 
                }
        
                $puntaje = 0;
                
                $resultado = new Resultado;
                $resultado->test = $registro->idtest;
                $resultado->alumno = $registro->idalumno;
                $resultado->pregunta = $registro->idpregunta;
                $resultado->puntaje = $puntaje;
                $resultado->contestada = $contestada;
                $resultado->save();
                
                $RespuestaDesarrolloAlumno = RespuestaDesarrolloAlumno::where('idtest',$registro->idtest)->where('idalumno',$registro->idalumno)->where('idpregunta',$registro->idpregunta)->first();
                $RespuestaDesarrolloAlumno->idresultado = $resultado->id;
                $RespuestaDesarrolloAlumno->puntaje = $puntaje;
                $RespuestaDesarrolloAlumno->save();

                //echo "<br>contestada: ".$contestada;
          

            break;

            case 4:
                
                $pregunta = PreguntaAlternativa::where('pregunta', $registro->idpregunta)->where('visible','1')->where('puntaje', '!=', 0)->first();
                //dd(intval($registro->respuesta), intval($pregunta->id));
                if(intval($registro->respuesta) === 0){
                    $puntaje = 0;
                    $contestada = 0;
                }else if (intval($registro->respuesta) === intval($pregunta->id) ){
                    $puntaje = $pregunta->puntaje;
                    $contestada = 1;
                }else{
                    $puntaje = 0;
                    $contestada = 1;
                }

                $resultado = new Resultado;
                $resultado->test = $registro->idtest;
                $resultado->alumno = $registro->idalumno;
                $resultado->pregunta = $registro->idpregunta;
                $resultado->puntaje = $puntaje;
                $resultado->contestada = $contestada;
                $resultado->save();

                $RespuestaAlternativaAlumno = RespuestaAlternativaAlumno::where('idtest',$registro->idtest)->where('idalumno',$registro->idalumno)->where('idpregunta',$registro->idpregunta)->first();
                $RespuestaAlternativaAlumno->puntaje = $puntaje;
                $RespuestaAlternativaAlumno->save();

                break;

            case 5:
                //RESPUESTA CORTA
                

                if (trim($registro->respuesta) == "")
                {
                     $puntaje = 0;
                     $contestada = 0;
                }
                else 
                {
                    $correctas = PreguntaCorta::where( 'pregunta' , $registro->idpregunta )->get();
                    foreach($correctas as $pos => $val){

                            if(trim($val->texto) === trim($registro->respuesta))
                            {
                                $puntaje = $val->puntaje;
                                $contestada = 1;
                                break;
                            }else{
                                $puntaje = 0;
                                $contestada = 1;
                            }

                    }

                }

                //dd($puntaje, $contestada);

                $resultado = new Resultado;
                $resultado->test = $registro->idtest;
                $resultado->alumno = $registro->idalumno;
                $resultado->pregunta = $registro->idpregunta;
                $resultado->puntaje = $puntaje;
                $resultado->contestada = $contestada;
                $resultado->save();

                $RespuestaCortaAlumno = RespuestaCortaAlumno::where('idtest',$registro->idtest)->where('idalumno',$registro->idalumno)->where('idpregunta',$registro->idpregunta)->first();
                $RespuestaCortaAlumno->puntaje = $puntaje;
                $RespuestaCortaAlumno->save();
                break;
        }

    } 

    public function procesarRespuesta(){

        
        if(Request::ajax()) {

            $data = Input::all();

            $data["idalumno"] = Session::get('idalumno');

            switch($data["tipoPregunta"]){
                case 1:
                        //Verdadero o Falso

                        $exists = RespuestaVofAlumno::where('idtest', $data["test"])
                                ->where('idpregunta', $data["pregunta"])
                                ->where('idalumno', $data["idalumno"])
                                ->count();

                        if ( $exists == 0) 
                        {

                                $registro = new RespuestaVofAlumno;
                                                                    
                                $registro->idtest = $data["test"];
                                $registro->idpregunta = $data["pregunta"];
                                $registro->idalumno = $data["idalumno"];
                                $registro->respuesta = $data["respuestaAlumno"];
                                $registro->justificacion = "";
                                $registro->puntaje = 0;
                                $registro->fecha = time();
                                //$corregida = EvaluacionController::corregirLaPregunta($data["tipoPregunta"], $registro);
                                if ($registro->save())
                                {

                                    $corregida = EvaluacionController::corregirLaPregunta($data["tipoPregunta"], $registro);
                                    return Response::json(array('success' => true, 'last_insert_id' => $registro->id, 'messege' => "<input class='btn btn-success' value='Respuesta Enviada!'>"), 200);
                                
                                }
                                else
                                {
                                
                                    return Response::json(array('success' => false, 'last_insert_id' => "-1", 'messege' => "Ocurrió un error al guardar tu respuesta. Intentalo de nuevo por favor!!"), 200);
                                
                                }
                        }
                        else
                        {

                                return Response::json(array('success' => false, 'last_insert_id' => "-1", 'messege' => 'Esta pregunta ya registra una respuesta!!'), 200);
                        
                        }
                        

                        
                break;
                case 2:

                        //respuesta emparejamiento
                        $exists = RespuestaEmparejaAlumno::where('idtest', $data["test"])
                                            ->where('idpregunta', $data["pregunta"])
                                            ->where('idalumno', $data["idalumno"])
                                            ->count();
                        if ( $exists == 0) 
                        {
                            $parejas = json_decode($data['respuestaAlumno']);

                            $todoOk = true;
                            $cantInsertados = 0;
                            foreach($parejas as $pos => $val){

                                    $pareja = json_decode($val);
                                    $col1 = $pareja[0];
                                    $col2 = $pareja[1];

                                    $registro = new RespuestaEmparejaAlumno;
                                                                    
                                    $registro->idtest = $data["test"];
                                    $registro->idpregunta = $data["pregunta"];
                                    $registro->idalumno = $data["idalumno"];
                                    $registro->vinculo_a = $col1;
                                    $registro->vinculo_b = $col2;
                                    $registro->puntaje = 0;
                                    $registro->fecha = time();
                                    
                                    if ($registro->save())
                                    {

                                        $todoOk = true;
                                        $cantInsertados++;

                                    }
                                    else
                                    {
                                    
                                        $todoOk = false;
                                        break;
                                    }

                            }

                            $newRegistro = new StdClass();
                            $newRegistro->respuesta = $parejas;
                            $newRegistro->idtest = $data["test"];
                            $newRegistro->idpregunta = $data["pregunta"];
                            $newRegistro->idalumno = $data["idalumno"];                


                            if ($todoOk){
                                $corregida = EvaluacionController::corregirLaPregunta($data["tipoPregunta"], $newRegistro);
                                return Response::json(array('success' => true, 'last_insert_id' => $cantInsertados, 'messege' => "<input type='button' class='btn btn-success btn-md' value='Respuesta Enviada!!'>"), 200);
                            
                            }else{

                                $eliminados = RespuestaEmparejaAlumno::where('idtest', $data["test"])
                                            ->where('idpregunta', $data["pregunta"])
                                            ->where('idalumno', $data["idalumno"])->delete();

                                return Response::json(array('success' => false, 'last_insert_id' => "-1", 'messege' => "Ocurrió un error al guardar tu respuesta. Intentalo de nuevo por favor!!"), 200);

                            }
                        }
                        else
                        {

                            return Response::json(array('success' => false, 'last_insert_id' => "-1", 'messege' => 'Esta pregunta ya registra una respuesta!!'), 200);
                        
                        }
                        
                    

                break;

                        
                case 3:

                        //respuesta desarrollo alumno
                        $exists = RespuestaDesarrolloAlumno::where('idtest', $data["test"])
                                ->where('idpregunta', $data["pregunta"])
                                ->where('idalumno', $data["idalumno"])
                                ->count();

                        if ( $exists == 0) 
                        {

                            $registro = new RespuestaDesarrolloAlumno;
                                                                
                            $registro->idtest = $data["test"];
                            $registro->idpregunta = $data["pregunta"];
                            $registro->idalumno = $data["idalumno"];
                            $registro->respuesta = $data["respuestaAlumno"];
                            $registro->puntaje = 0;
                            $registro->idresultado = 0;
                            $registro->comentario_profe = "";
                            $registro->retro_alumno = "";
                            $registro->fecha = time();
                            
                            if ($registro->save())
                            {

                                $corregida = EvaluacionController::corregirLaPregunta($data["tipoPregunta"], $registro);
                                return Response::json(array('success' => true, 'last_insert_id' => $registro->id, 'messege' => "<input type='button' class='btn btn-success btn-md' value='Respuesta Enviada!!'>"), 200);
                            
                            }
                            else
                            {
                            
                                return Response::json(array('success' => false, 'last_insert_id' => "-1", 'messege' => "Ocurrió un error al guardar tu respuesta. Intentalo de nuevo por favor!!"), 200);
                            
                            }
                        }
                        else
                        {

                            return Response::json(array('success' => false, 'last_insert_id' => "-1", 'messege' => 'Esta pregunta ya registra una respuesta!!'), 200);
                        
                        }

                break;
                case 4:
                        //Respuesta alternatiiva alumno
                        $exists = RespuestaAlternativaAlumno::where('idtest', $data["test"])
                                ->where('idpregunta', $data["pregunta"])
                                ->where('idalumno', $data["idalumno"])
                                ->count();

                        if ( $exists == 0) 
                        {

                            $registro = new RespuestaAlternativaAlumno;
                                                                
                            $registro->idtest = $data["test"];
                            $registro->idpregunta = $data["pregunta"];
                            $registro->idalumno = $data["idalumno"];
                            $registro->respuesta = $data["respuestaAlumno"];
                            $registro->puntaje = 0;
                            $registro->fecha = time();
                            
                            if ($registro->save())
                            {

                                $corregida = EvaluacionController::corregirLaPregunta($data["tipoPregunta"], $registro);
                                return Response::json(array('success' => true, 'last_insert_id' => $registro->id, 'messege' => "<input type='button' class='btn btn-success btn-md' value='Respuesta Enviada!!'>"), 200);
                            
                            }
                            else
                            {
                            
                                return Response::json(array('success' => false, 'last_insert_id' => "-1", 'messege' => "Ocurrió un error al guardar tu respuesta. Intentalo de nuevo por favor!!"), 200);
                            
                            }
                        }
                        else
                        {

                            return Response::json(array('success' => false, 'last_insert_id' => "-1", 'messege' => 'Esta pregunta ya registra una respuesta!!'), 200);
                        
                        }

                break;
                case 5:

                        //respuesta corta alumno
                        $exists = RespuestaCortaAlumno::where('idtest', $data["test"])
                                ->where('idpregunta', $data["pregunta"])
                                ->where('idalumno', $data["idalumno"])
                                ->count();

                        if ( $exists == 0) 
                        {

                            $registro = new RespuestaCortaAlumno;
                                                                
                            $registro->idtest = $data["test"];
                            $registro->idpregunta = $data["pregunta"];
                            $registro->idalumno = $data["idalumno"];
                            $registro->respuesta = $data["respuestaAlumno"];
                            $registro->puntaje = 0;
                            $registro->fecha = time();
                            
                            if ($registro->save())
                            {
                                
                                $corregida = EvaluacionController::corregirLaPregunta($data["tipoPregunta"], $registro);
                                return Response::json(array('success' => true, 'last_insert_id' => $registro->id, 'messege' => "<input type='button' class='btn btn-success btn-md' value='Respuesta Enviada!!'>"), 200);
                            
                            }
                            else
                            {
                                
                                return Response::json(array('success' => false, 'last_insert_id' => "-1", 'messege' => "Ocurrió un error al guardar tu respuesta. Intentalo de nuevo por favor!!"), 200);
                            
                            }
                        }
                        else
                        {

                            return Response::json(array('success' => false, 'last_insert_id' => "-1", 'messege' => 'Esta pregunta ya registra una respuesta!!'), 200);
                        
                        }

                break;

            }

        }

    }



    public function generarUrlDelRecurso($urlRecurso){


        $direccion = explode('.',$urlRecurso);

        $url = $direccion[0];

        if($url =='http' or $url == 'https' or $url =='www' or $url =='http://www' or $url =='https://www' or $url =='http://contenidos')
        {
                
                $ruta = $urlRecurso;

        }
        else
        { 
                
                $ruta = URL_PLATAFORMA_PRODUCCION.'/home/recursos/'.$urlRecurso;

        }

        return $ruta;
    }

    public function obtenerRespuestaDelAlumno($pregunta, $tipoPregunta, $idtest, $idalumno){

        switch($tipoPregunta)
        {
            case 1:

                    $respuestaAlumno = RespuestaVofAlumno::getRespuestaDelAlumno($pregunta, $tipoPregunta, $idtest, $idalumno);
                    
            break;

            case 2:

                    $respuestaAlumno = RespuestaEmparejaAlumno::getRespuestaDelAlumno($pregunta, $tipoPregunta, $idtest, $idalumno);
                    
                    $dataResp = Array();
                    
                    foreach($respuestaAlumno as $pos => $val)
                    {
                            
                            $dataResp[$val->vinculo_a] = $val->vinculo_b;  
                            
                    }

                    $respuesta = new StdClass();

                    if (count($dataResp) > 0)
                    {

                            $respuesta->respuesta = $dataResp;

                    }
                    else
                    {

                            $respuesta->respuesta = null;

                    }
                    
                    
                    
                    $respuestaAlumno = $respuesta;



            break;

            case 3:

                    $respuestaAlumno = RespuestaDesarrolloAlumno::getRespuestaDelAlumno($pregunta, $tipoPregunta, $idtest, $idalumno);
            
            break;  

            case 4:

                    $respuestaAlumno = RespuestaAlternativaAlumno::getRespuestaDelAlumno($pregunta, $tipoPregunta, $idtest, $idalumno);

            break;

            case 5:

                    $respuestaAlumno = RespuestaCortaAlumno::getRespuestaDelAlumno($pregunta, $tipoPregunta, $idtest, $idalumno);

            break;
        }

        return $respuestaAlumno;

    }

    public function obternerContenidoDePreguntasDelTest($preguntasTest, $idtest, $barajarAlternativas)
        {
            $respuesta = Array();
            $num = 1;

            $idalumno = Session::get('idalumno');


            foreach($preguntasTest as $pos=>$value)
            {
                    $arreglo = Array();
                    $pregunta = Pregunta::find($value->pregunta);

                    $tipoPregunta = $pregunta->tipo;

                    $arreglo['numero'] = $num;
                    $arreglo['data'] = $pregunta;
                    
                    //dd($arreglo['respuestaAlumno']);                    

                    if(!isset($pregunta->miRecurso->url))
                    {

                            $arreglo['recurso'] = "";

                    }
                    else
                    {

                            $arreglo['recurso'] = $pregunta->miRecurso;
                            if (isset($arreglo['recurso']->url))
                            {

                                    $resp = EvaluacionController::generarUrlDelRecurso($arreglo['recurso']->url);
                                    $arreglo['recurso']->url = $resp;

                            }

                    }

                    
                    $arreglo['data']->texto = str_replace('/sistema/webclass/', URL_PLATAFORMA_PRODUCCION.'/', $arreglo['data']->texto);                    
                    
                   
                    //si la pregunta es de alternativas (tipo 4) entonces adjunto en el arreglo sus alternativas.

                    if ($tipoPregunta === 4)
                    {
                            
                            $alternativasArray = Array();

                            $letras = Array('0'=>'A','1'=>'B','2'=>'C','3'=>'D','4'=>'E','5'=>'F','6'=>'G','7'=>'H','8'=>'I');

                            $idPregunta = $pregunta->id;

                                                        
                            if ($barajarAlternativas === 1){

                                    $lasAlternativas = PreguntaAlternativa::where('pregunta',$idPregunta)->where('visible',1)->orderBy(DB::raw('RAND()'))->get();

                            }else{

                                    $lasAlternativas = PreguntaAlternativa::where('pregunta',$idPregunta)->where('visible',1)->orderBy('orden','asc')->get();

                            }

                            

                            foreach($lasAlternativas as $pos => $val){
                                $alternativa = new StdClass();
                                $alternativa->id = $val->id;
                                $alternativa->texto = $val->texto;
                                $alternativa->letra = $letras[$pos];
                                $alternativa->retroalimentacion = $val->retroalimentacion;
                                $alternativa->pregunta = $val->pregunta;

                                array_push($alternativasArray, $alternativa);   
                            }

                            $arreglo['alternativas'] = $alternativasArray;
                            //dd($arreglo['alternativas']);
                    }
                    else if ($tipoPregunta === 2)
                    {

                            $idPregunta = $pregunta->id;
                            $lasAlternativasCol1 = PreguntaEmparejamiento::where('pregunta',$idPregunta)->where('visible',1)->where('columna',1)->orderBy(DB::raw('RAND()'))->get();
                            $lasAlternativasCol2 = PreguntaEmparejamiento::where('pregunta',$idPregunta)->where('visible',1)->where('columna',2)->orderBy(DB::raw('RAND()'))->get();
                            
                            $arreglo['alternativas'] = Array("col1"=>$lasAlternativasCol1, "col2"=>$lasAlternativasCol2);

                    }
                    else
                    {

                            $arreglo['alternativas'] = false;

                    }

                    $arreglo['respuestaAlumno'] = EvaluacionController::obtenerRespuestaDelAlumno($arreglo['data']->id, $arreglo['data']->tipo, $idtest, $idalumno);
                    
                        array_push($respuesta, $arreglo);

                    
                    
                    $num++;

            }
            
            return $respuesta;

        }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
