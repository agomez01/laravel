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

        protected $fillable = array('usuario_id');


        public function variables(){
            return $this->hasOne('App\models\Variables', 'auth_sesion_id', 'id');
        }

        public function verifica_password(){

            
        }
    }
