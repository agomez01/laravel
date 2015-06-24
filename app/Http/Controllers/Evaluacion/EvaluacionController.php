<?php

namespace App\Http\Controllers\Evaluacion;

use Illuminate\Http\Request;

use App\models\Test;
use App\models\Pregunta;

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
                    $dataTest = Test::find($idtest);
        
                    $preguntasTest = $dataTest->miPrueba->misPreguntas; //Esta es la tabla vinculante entre la prueba y las preguntas.

                    $preguntas = Pregunta::obternerContenidoDePreguntasDelTest($preguntasTest); //Este es un arreglo que contiene todas las preguntas de la prueba y su contenido.

                    //dd($preguntas);              
                    
                    $test["id"]      = $dataTest->id;
                    $test["prueba"]  = $dataTest->miPrueba->id;
                    $test["nombre"]      = $dataTest->miPrueba->titulo;
                    $test["nivel"]       = $dataTest->miPrueba->miSector->miNivel->nombre;
                    $test["asignatura"]  = $dataTest->miPrueba->miSector->nombre;
                    $test["duracion"]    = $dataTest->duracion;

                    return view('evaluacion/rendirEvaluacion')->with('test', $test)->with('preguntas', $preguntas);
            break;
        }
       
        
        
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
