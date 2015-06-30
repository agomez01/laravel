<?php

    namespace App\models;

    use Illuminate\Database\Eloquent\Model;


    class RespuestaAlternativaAlumno extends Model
    {

        /**
         * The database table used by the model.
         *
         * @var string
         */

        public $timestamps = false;
        
        protected $table = 'respuesta_alternativa_alumno';
       
        public static function getRespuestaDelAlumno($idpregunta, $tipoPregunta, $idtest, $idalumno){

           $respuestaAlumno = RespuestaAlternativaAlumno::where('idtest', $idtest)->where('idpregunta', $idpregunta)->where('idalumno', $idalumno)->get()->first();


           return $respuestaAlumno;
        }
    }