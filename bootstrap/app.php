<?php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\TrackVisits;
use App\Http\Middleware\AdminEcole;
use App\Http\Middleware\MinifyHtml;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Enregistrer ici les middlewares sous forme de tableau
        $middleware->alias([
            'auth.ecole' => AdminEcole::class,
        ]);
        
        // Ajouter le middleware pour minifier les vues HTML
        $middleware->prepend(TrackVisits::class);
        //$middleware->prepend(MinifyHtml::class);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Placez ici toute configuration d'exception nécessaire
    })
    ->create();
