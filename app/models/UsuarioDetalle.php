<?php

    namespace App\models;

    use Illuminate\Database\Eloquent\Model;

    class UsuarioDetalle extends Model
    {
        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'usuario_detalle';

        public function getFullNameAttribute(){
            return  $this->apellido_paterno." ".$this->apellido_materno." ".$this->nombre_usuario;
        }


        public function usuario(){
            return $this->belongsTo('App\models\Usuario', 'id', 'idusuario');
        }


    }
