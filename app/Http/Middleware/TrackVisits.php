<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackVisits
{
    public function handle(Request $request, Closure $next)
    {
        DB::table('visits')->insert([
            'ip_address' => $request->ip(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $next($request);
    }
}
