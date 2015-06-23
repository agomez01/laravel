<?php

    namespace App\models;

    use Illuminate\Database\Eloquent\Model;


    class Alumno extends Model
    {

        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'alumno';


        public function usuario()
        {

            return $this->belongsTo('App\models\Usuario', 'alumno', 'id');
            
        }

    }
