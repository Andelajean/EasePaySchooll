<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class MinifyHtml
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        Log::info('Middleware MinifyHtml exécuté.');

        $response = $next($request);

        // Vérifiez que le middleware s'exécute uniquement pour le HTML
        if ($response->headers->get('Content-Type') === 'text/html; charset=UTF-8') {
            $output = $response->getContent();
            // Minification
            $output = preg_replace('/\s+/', ' ', $output);
            $output = preg_replace('/>\\s+</', '><', $output);
            $output = trim($output);

            $response->setContent($output);
            Log::info('Contenu après minification : ' . $output);
        }

        return $response;
    }
}
