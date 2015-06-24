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

	    public static function obternerContenidoDePreguntasDelTest($preguntasTest)
	    {
	    	$resp = Array();
	    	$num = 1;
	    	foreach($preguntasTest as $pos=>$value)
	    	{
	    			$variables = Pregunta::find($value->pregunta);

	    			
	    			$arreglo['numero'] = $num;
	    			$arreglo['data'] = $variables;
	    			
	    			//$imagenRecurso = $arreglo['data']->miRecurso->url;
	    			

	    			if(!isset($variables->miRecurso->url)){
	    				$rutaImagen = "";
	    			}else{
	    				$rutaImagen = $variables->miRecurso->url;
	    			}

	    			$arreglo['imagen'] = $rutaImagen;

					$arreglo['data']->texto = str_replace('/sistema/webclass/', 'http://proyecto.webescuela.cl/sistema/webclass/', $arreglo['data']->texto);	    			
					
	    			

	    			array_push($resp, $arreglo);
	    			$num++;

	    	}
	    	//dd($resp);
	    	return $resp;

	    }

	}
