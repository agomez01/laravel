<?php

    namespace App\models;

    use Illuminate\Database\Eloquent\Model;


    class RespuestaVofAlumno extends Model
    {

        /**
         * The database table used by the model.
         *
         * @var string
         */

        public $timestamps = false;
        
        protected $table = 'respuesta_vof_alumno';
       
        public static function getRespuestaDelAlumno($idpregunta, $tipoPregunta, $idtest, $idalumno){

            return $respuestaAlumno = RespuestaVofAlumno::where('idtest', $idtest)->where('idpregunta', $idpregunta)->where('idalumno', $idalumno)->get()->first();

        }

    }