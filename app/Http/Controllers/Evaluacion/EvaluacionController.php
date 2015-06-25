<?php

namespace App\Http\Controllers\Evaluacion;

use Illuminate\Http\Request;

use App\models\Test;
use App\models\TestPregunta;

use App\models\Pregunta;
use App\models\PreguntaAlternativa;
use App\models\PreguntaEmparejamiento;

use App\models\Usuario;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EvaluacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($idtest,$action)
    {

         $idtest = base64_decode($idtest);

        switch($action){
            case 0:
                    $dataTest = Test::find($idtest);
        
                    $nombreTest = $dataTest->miPrueba;

                    
                    $test["id"]      = $dataTest->id;
                    $test["nombre"]      = $dataTest->miPrueba->titulo;
                    $test["nivel"]       = $dataTest->miPrueba->miSector->miNivel->nombre;
                    $test["asignatura"]  = $dataTest->miPrueba->miSector->nombre;
                    $test["duracion"]    = $dataTest->duracion;
             
                    return view('evaluacion/portadaEvaluacion')->with('test', $test);
            break;

            case 1:
                    $dataTest       = Test::find($idtest);
                    $preguntasTest  = TestPregunta::where('test', $dataTest->id)->get(); //Esta es la tabla vinculante entre test y las preguntas.
                    $preguntas      = EvaluacionController::obternerContenidoDePreguntasDelTest($preguntasTest); //Este es un arreglo que contiene todas las preguntas de la prueba y su contenido.

                    //dd();
                    $dataAutor = Usuario::find($dataTest->profesor);
                    
                    $test["id"]          = $dataTest->id;
                    $test["autor"]       = $dataAutor->usuario_detalle->full_name;
                    //dd($test["autor"]);
                    $test["prueba"]      = $dataTest->miPrueba->id;
                    $test["nombre"]      = $dataTest->miPrueba->titulo;
                    $test["nivel"]       = $dataTest->miPrueba->miSector->miNivel->nombre;
                    $test["asignatura"]  = $dataTest->miPrueba->miSector->nombre;
                    $test["duracion"]    = $dataTest->duracion;

                    return view('evaluacion/rendirEvaluacion')->with('test', $test)->with('preguntas', $preguntas);
            break;
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


    public function obternerContenidoDePreguntasDelTest($preguntasTest)
        {
            $respuesta = Array();
            $num = 1;

            foreach($preguntasTest as $pos=>$value)
            {
                    $arreglo = Array();
                    $pregunta = Pregunta::find($value->pregunta);

                    $tipoPregunta = $pregunta->tipo;

                    $arreglo['numero'] = $num;
                    $arreglo['data'] = $pregunta;
                                    
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

                            $idPregunta = $pregunta->id;
                            $lasAlternativas = PreguntaAlternativa::where('pregunta',$idPregunta)->where('visible',1)->orderBy('orden','asc')->get();
                            $arreglo['alternativas'] = $lasAlternativas;

                    }
                    else if ($tipoPregunta === 2)
                    {

                            $idPregunta = $pregunta->id;
                            $lasAlternativasCol1 = PreguntaEmparejamiento::where('pregunta',$idPregunta)->where('visible',1)->where('columna',1)->orderBy('orden','asc')->get();
                            $lasAlternativasCol2 = PreguntaEmparejamiento::where('pregunta',$idPregunta)->where('visible',1)->where('columna',2)->orderBy('orden','asc')->get();
                            
                            $arreglo['alternativas'] = Array("col1"=>$lasAlternativasCol1, "col2"=>$lasAlternativasCol2);

                    }
                    else
                    {

                            $arreglo['alternativas'] = false;

                    }

                    
                    
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
