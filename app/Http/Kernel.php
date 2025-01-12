<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        \App\Http\Middleware\ForceHttps::class,
    ];

    protected $middlewareGroups = [
        'web' => [
           
        ],

        'api' => [
            // Middlewares pour les routes API
        ],
    ];

    protected $routeMiddleware = [
        // Middlewares pour les routes spécifiques
    ];
}
