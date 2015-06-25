<?php

    namespace App\models;

    use Illuminate\Database\Eloquent\Model;


    class PreguntaAlternativa extends Model
    {

        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'respuesta_alternativa';
       
       public function miPregunta()
       {

            return $this->belongsTo('App/models/Pregunta','pregunta','id');

       }

    }