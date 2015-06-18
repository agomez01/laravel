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
        'isSuperAdmin'  => \App\http\Middleware\isSuperAdmin::class,
        'isWcManager'   => \App\http\Middleware\isWcManager::class,
        'isCapacitador' => \App\http\Middleware\isCapacitador::class,
        'isFinanzas'    => \App\http\Middleware\isFinanzas::class,
        'isSostenedor'  => \App\http\Middleware\isSostenedor::class,
        'isDirector'    => \App\http\Middleware\isDirector::class,
        'isUtp'         => \App\http\Middleware\isUtp::class,
        'isProfesor'    => \App\http\Middleware\isProfesor::class,
        'isInsGeneral'  => \App\http\Middleware\isInsGeneral::class,
        'isApoderado'   => \App\http\Middleware\isApoderado::class,
        'isAlumno'      => \App\http\Middleware\isAlumno::class,

    ];
}
