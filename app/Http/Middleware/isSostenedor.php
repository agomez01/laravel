<?php

namespace App\Http\Middleware;

use Session;
use Closure;
use URL;
use Illuminate\Contracts\Auth\Guard;

class isSostenedor
{

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

        if (Session::get('rol') != 10){
            
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {

                if(URL::previous() != ''){
                    return redirect()->guest(URL::previous());
                }else{
                    return redirect()->guest('/');
                }                
            }
        }

        return $next($request); 


    }
}
