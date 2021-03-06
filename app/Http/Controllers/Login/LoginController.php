<?php

namespace App\Http\Controllers\Login;

use App\Http\Clases\generaLink;
use App\models\Usuario;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Auth\AuthController;

use View;
use Input;
use Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;


class LoginController extends Controller
{

    public function index(){

        if (Session::get('logeado')){
            # Dependiendo del Perfil se redireccionara
            return Redirect::to('/home');
            
        }else{
            return View::make('login/login');
            //return Redirect::to('/login');
        }   
    }

    public function logexterno(){

        $modulo = Request::get('modulo');
        $id = Request::get('usuario');
        $token = Request::get('token');


        if(AuthController::comprueba($id, $token)){


            $usuario = Usuario::find($id);
            $usuario->token = $token;

            $auth = new AuthController();
            $auth->setSesion($usuario);


            return Redirect::to($modulo);
        }else{
            abort(403, 'Unauthorized action.');
        }

    }


    public function logearse(){

    	$userdata = array(
            'nombre_usuario' => Request::get('username'),
            'clave'=> md5(Request::get('password'))
        );

    	// Validamos los datos y además mandamos como un segundo parámetro la opción de recordar el usuario.
        if(AuthController::logear($userdata) == 'ok' ){

            if(Session::get('rol') != 31){

                $link = generaLink::getLink('modulo&desde=login'); 

                return Redirect::away($link);

            }else{
                return Redirect::to('/home');
            }

            

        }else{

            // En caso de que la autenticación haya fallado manda un mensaje al formulario de login y también regresamos los valores enviados con withInput().
            return Redirect::to('/')
                    ->with('mensaje_error', 'Tus datos son incorrectos')
                    ->withInput();
        }
    }

    public function logout(){

        if(AuthController::logout()){
            return Redirect::to('/');
        }

    }

}
