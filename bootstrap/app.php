<?php

use App\Http\Middleware\AdminEcole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\TrackVisits;

return Application::configure(basePath: dirname(_DIR_))
    ->withRouting(
        web: _DIR_.'/../routes/web.php',
        commands: _DIR_.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Enregistrer ici le middleware sous forme de tableau
        $middleware->alias([
            'auth.ecole' => \App\Http\Middleware\AdminEcole::class,
        ]);
        
        $middleware->prepend(TrackVisits::class);
    })
    
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();