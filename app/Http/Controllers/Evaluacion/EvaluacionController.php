<?php

namespace App\Http\Controllers\Evaluacion;



use App\models\Test;
use App\models\TestPregunta;
use App\models\Prueba;
use App\models\Pregunta;
use App\models\PreguntaAlternativa;
use App\models\PreguntaEmparejamiento;
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
                       //dd($preguntasTest);
                        
                        if ($dataTest->barajar === 1)
                        {
                             
                                $preguntasTest  = TestPregunta::where('test', $dataTest->id)->orderBy(DB::raw('RAND()'))->get(); //Esta es la tabla vinculante entre test y las preguntas.

                        }
                        else
                        {

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
                        //dd($preguntas);
                        return view('evaluacion/rendirEvaluacion')->with('test', $test)->with('preguntas', $preguntas);
                break;

                case 2:



                break;
            }
            
        }

    public static function corregirLaPregunta($tipoPregunta, $registro){

        switch ($tipoPregunta) {
            case 1:
                //VERDADERO O FALSO
                $pregunta = PreguntaVof::where('pregunta', $registro->idpregunta)->get();
                
                if ($registro->respuesta == 2){
                    //EL ALUMNO OMITIO LA PREGUNTA
                    $resulado = new Resultado;
                    dd($resulado);
                    return;
                }

                

                break;
            
            case 2:
               //EMPAREJAMIENTO


                break;

            case 3:
               //DESARROLLO


                break;

            case 4:
               //ALTERNATIVA


                break;

            case 5:
               //RESPUESTA CORTA


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
                            
                            if ($registro->save())
                            {

                                $corregida = EvaluacionController::corregirLaPregunta($data["tipoPregunta"], $registro);
                                return Response::json(array('success' => true, 'last_insert_id' => $registro->id, 'messege' => "Respuesta Enviada!!"), 200);
                            
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
                                    
                                        $todoOk = fasle;
                                        exit();
                                    }

                            }

                            if ($todoOk){
                                $corregida = EvaluacionController::corregirLaPregunta($data["tipoPregunta"], $registro);
                                return Response::json(array('success' => true, 'last_insert_id' => $cantInsertados, 'messege' => "Respuesta Enviada!!"), 200);
                            
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
                                return Response::json(array('success' => true, 'last_insert_id' => $registro->id, 'messege' => "Respuesta Enviada!!"), 200);
                            
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
                                return Response::json(array('success' => true, 'last_insert_id' => $registro->id, 'messege' => "Respuesta Enviada!!"), 200);
                            
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
                                return Response::json(array('success' => true, 'last_insert_id' => $registro->id, 'messege' => "Respuesta Enviada!!"), 200);
                            
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
