<?php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\TrackVisits;
<<<<<<< HEAD
=======
use App\Http\Middleware\Redirection;
>>>>>>> b610dc2e03e1e8e3ac1f8dc2b2bd7a69a7e63053
use App\Http\Middleware\AdminEcole;
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
<<<<<<< HEAD
=======
        $middleware->prepend(Redirection::class);
>>>>>>> b610dc2e03e1e8e3ac1f8dc2b2bd7a69a7e63053
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Placez ici toute configuration d'exception nécessaire
    })
    ->create();
