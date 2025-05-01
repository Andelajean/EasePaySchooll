<?php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\TrackVisits;
use App\Http\Middleware\AdminEcole;
use App\Http\Middleware\MinifyHtml;
use App\Http\Middleware\RedirectIfAdmin;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Enregistrement des middlewares alias
        $middleware->alias([
            'auth.ecole' => AdminEcole::class,
            'admin' => \App\Http\Middleware\RedirectIfAdmin::class, // Correction ici
        ]);
        
        // Middleware à prépendre
        $middleware->prepend(TrackVisits::class);
        // $middleware->prepend(MinifyHtml::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Configuration des exceptions
    })
    ->create();