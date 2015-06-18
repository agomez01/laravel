<?php

    namespace App\models;

    use Illuminate\Database\Eloquent\Model;


    class Colegio extends Model
    {

        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'colegio';


        public function usuario(){
            return $this->hasMany('App\models\Usuario', 'idcolegio', 'id');
        }

        public function curso(){
            return $this->hasMany('App\models\Curso', 'colegio', 'id');
        }
    }
