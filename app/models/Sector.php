<?php

    namespace App\models;

    use Illuminate\Database\Eloquent\Model;


    class Sector extends Model
    {

        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'sector';

        public function miNivel()
        {
            return $this->belongsTo('App\models\Nivel','nivel','id');
        }
        

        

    }