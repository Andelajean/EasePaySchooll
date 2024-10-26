<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AdminEcole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
  
    public function handle($request, Closure $next)
{
    if (!Session::has('ecole')) {
        return redirect()->route('login.ecole')->withErrors('Vous devez vous connecter pour accéder à cette page.');
    }

    return $next($request);
}

}
