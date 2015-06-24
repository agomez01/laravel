<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class PruebaPregunta extends Model
{
    protected $table = 'prueba_preguntas';

    public function miPregunta()
    {

    	return $this->belongsTo('App\models\Pregunta', 'pregunta','id');

    }
}
