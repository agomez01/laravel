<?php

    namespace App\models;

    use Illuminate\Database\Eloquent\Model;

    class Usuario extends Model
    {
        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'usuario';


        public function alumno(){
            return $this->hasMany('App\models\Alumno', 'alumno', 'id');
        }

        public function colegio(){
            return $this->hasOne('App\models\Colegio', 'id', 'idcolegio');
        }

        public function usuario_detalle(){
            return $this->hasOne('App\models\UsuarioDetalle', 'idusuario', 'id');
        }


    }
