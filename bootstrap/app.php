<?php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


use App\Http\Middleware\TrackVisits; 
use App\Http\Middleware\AdminEcole;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->prepend(TrackVisits::class);
        $middleware->alias([
            'auth.ecole' =>
            \App\Http\Middleware\AdminEcole::class,
        
        ]);
    })
    
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();


