<?php

namespace App\Http\Controllers\Login;


use App\Http\Controllers\Controller;

use App\Http\Controllers\Auth\AuthController;

use View;
use Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;


class LoginController extends Controller
{

    public function index(){

        if (Session::get('logeado')){
            # Dependiendo del Perfil se redireccionara
            return Redirect::to('/alumno');
            
        }else{
            return View::make('login/login');
            //return Redirect::to('/login');
        }
    }


    public function logearse(){

    	$userdata = array(
            'nombre_usuario' => Request::get('username'),
            'clave'=> md5(Request::get('password'))
        );

    	// Validamos los datos y además mandamos como un segundo parámetro la opción de recordar el usuario.
        if(AuthController::logear($userdata) == 'ok' ){

            return Redirect::to('/alumno');

        }else{

            // En caso de que la autenticación haya fallado manda un mensaje al formulario de login y también regresamos los valores enviados con withInput().
            return Redirect::to('/')
                    ->with('mensaje_error', 'Tus datos son incorrectos')
                    ->withInput();
        }
    }

}
