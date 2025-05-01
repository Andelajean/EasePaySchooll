<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RedirectIfAdmin
{
    
    public function handle($request, Closure $next)
    {
        if (!Session::has('admin')) {
            return redirect()->route('admin.login')->withErrors('Vous devez vous connecter pour accéder à cette page.');
        }

        return $next($request);
    }

}