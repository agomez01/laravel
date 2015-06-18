<?php

    namespace App\models;

    use Illuminate\Database\Eloquent\Model;


    class Curso extends Model
    {

        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'curso';


        public function colegio(){
            return $this->hasOne('App\models\Colegio', 'id', 'colegio');
        }
    }
