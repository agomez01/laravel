<?php

    namespace App\models;

    use Illuminate\Database\Eloquent\Model;


    class PreguntaVof extends Model
    {

        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'respuesta_vof';
       
       public function miPregunta()
       {

            return $this->belongsTo('App/models/Pregunta','pregunta','id');

       }

    }