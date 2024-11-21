<?php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

<<<<<<< HEAD
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
        
=======

use App\Http\Middleware\TrackVisits; // Assurez-vous d'importer votre middleware

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
>>>>>>> 4fd056178773114949f0cf894f01cfc356724566
        $middleware->prepend(TrackVisits::class);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
<<<<<<< HEAD
        // Placez ici toute configuration d'exception nécessaire
    })
    ->create();
=======
        //
    })->create();


>>>>>>> 4fd056178773114949f0cf894f01cfc356724566
