<?php

use App\Http\Middleware\AdminEcole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\TrackVisits;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Enregistrer ici le middleware sous forme de tableau
        $middleware->alias([
            'auth.ecole' => AdminEcole::class,
        ]);
        
        $middleware->prepend(TrackVisits::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Placez ici toute configuration d'exception nécessaire
    })
    ->create();
