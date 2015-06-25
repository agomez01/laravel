<?php

	namespace App\models;

	use Illuminate\Database\Eloquent\Model;

	class Pregunta extends Model
	{

	    protected $table = "pregunta";


	    public function miRecurso()
	    {

			return $this->hasOne('App\models\Recurso', 'id', 'idrecurso');
	    	
	    }

	    


	}
