<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Prueba extends Model
{
    protected $table = 'prueba';

    public function misPreguntas()
    {
    	return $this->hasMany('App\models\PruebaPregunta','prueba','id');
    }

    public function miSector()
    {
    	return $this->belongsTo('App\models\Sector','sector','id');
    }
}
