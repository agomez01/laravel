<?php

    namespace App\models;

    use Illuminate\Database\Eloquent\Model;

    class Sesion extends Model
    {
        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'wc_auth_sesiones';


        public function alumno(){
            return $this->hasOne('App\models\Variables', 'id', 'alumno');
        }

        public function verifica_password(){

            
        }
    }
