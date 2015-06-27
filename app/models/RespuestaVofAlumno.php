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
       

    }