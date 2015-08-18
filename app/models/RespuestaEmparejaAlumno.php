<?php

    namespace App\models;

    use Illuminate\Database\Eloquent\Model;


    class RespuestaEmparejaAlumno extends Model
    {

        /**
         * The database table used by the model.
         *
         * @var string
         */

        public $timestamps = false;
        
        protected $table = 'respuesta_enpareja_alumno';
       
        public static function getRespuestaDelAlumno($idpregunta, $tipoPregunta, $idtest, $idalumno){

            return $respuestaAlumno = RespuestaEmparejaAlumno::where('idtest', $idtest)->where('idpregunta', $idpregunta)->where('idalumno', $idalumno)->get();
            
        }

        public function rordena(){
            return $this->hasOne('App\models\RespuestaEmparejaOrden', 'id', 'vinculo_a');
        }

        public function rordenb(){
            return $this->hasOne('App\models\RespuestaEmparejaOrden', 'id', 'vinculo_b');
        }
    }