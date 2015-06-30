<?php

    namespace App\models;

    use Illuminate\Database\Eloquent\Model;


    class RespuestaDesarrolloAlumno extends Model
    {

        /**
         * The database table used by the model.
         *
         * @var string
         */

        public $timestamps = false;
        
        protected $table = 'respuesta_desarrollo_alumno';
       
        public static function getRespuestaDelAlumno($idpregunta, $tipoPregunta, $idtest, $idalumno){

            return $respuestaAlumno = RespuestaDesarrolloAlumno::where('idtest', $idtest)->where('idpregunta', $idpregunta)->where('idalumno', $idalumno)->get()->first();
            
        }
    }