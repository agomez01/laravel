<?php

    namespace App\models;

    use Illuminate\Database\Eloquent\Model;

    class Variables extends Model
    {
        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'wc_auth_variables';

        protected $fillable = array('auth_sesion_id', 'variables');


        public function variables(){
            return $this->hasOne('App\models\Variables', 'auth_sesion_id', 'id');
        }
    }
