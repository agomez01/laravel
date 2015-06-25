<?php

    namespace App\models;

    use Illuminate\Database\Eloquent\Model;


    class PreguntaEmparejamiento extends Model
    {

        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'respuesta_enpareja_orden';
       
       public function miPregunta()
       {

            return $this->belongsTo('App/models/Pregunta','pregunta','id');

       }

       public function miVinculo()
       {
        
            return $this->hasOne('App/models/PreguntaEmparejamientoVinculo','vinculo_a','id');

       }

    }