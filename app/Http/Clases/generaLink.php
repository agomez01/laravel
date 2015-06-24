<?php
	namespace App\Http\Clases;


	use App\models\Sesion;
	use Session;

	class generaLink
	{

	    static function getLink($modulo){

	    	$sesion = Sesion::where('usuario_id', Session::get('idusuario'))->first();

	    	if(!is_null($sesion)){
	    		return URL_PLATAFORMA.'externo.php?idusuario='.Session::get('idusuario')."&modulo=$modulo&token=".$sesion->token;
	    	}else{
	    		return false;
	    	}
	    }

	}
