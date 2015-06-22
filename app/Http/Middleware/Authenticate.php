<?php

namespace App\Http\Middleware;

use Session;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\models\Sesion;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        # si no están las variables de sesión correspondientes
        # se redireccionara a la ruta "/" para iniciar sesión
        if (!Session::get('logeado')) {
            
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('/');
            }
        
        }else{
            # si está iniciada la sesión
            # preguntaremos si existe el registro en la BD
            $usuario = Session::get('idusuario');

            # comprobamos que haya retornado una variable
            if( !empty($usuario)  ){

                $sesion = Sesion::where('usuario_id', $usuario)->first();

                # Si la sesión en BD está vacía o no concuerda el token
                # eliminamos las variables de sesión 
                if(empty($sesion)){
                    Session::flush();
                    return redirect()->guest('/');
                }

            }else{
                # si no existe variable sesion, redireccionamos a login
                return redirect()->guest('/');
            }

            

        }

        return $next($request);
    }
}
