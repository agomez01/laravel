<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'          => \App\Http\Middleware\Authenticate::class,
        'auth.basic'    => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest'         => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'isAlumno'      => \App\Http\Middleware\isAlumno::class,
        'isProfesor'    => \App\Http\Middleware\isProfesor::class,
        'isSuperAdmin'  => \App\Http\Middleware\isSuperAdmin::class,
        'isWcManager'   => \App\Http\Middleware\isWcManager::class,
        'isCapacitador' => \App\Http\Middleware\isCapacitador::class,
        'isFinanzas'    => \App\Http\Middleware\isFinanzas::class,
        'isSostenedor'  => \App\Http\Middleware\isSostenedor::class,
        'isDirector'    => \App\Http\Middleware\isDirector::class,
        'isUtp'         => \App\Http\Middleware\isUtp::class,
        'isInsGeneral'  => \App\Http\Middleware\isInsGeneral::class,
        'isApoderado'   => \App\Http\Middleware\isApoderado::class
        

    ];
}
