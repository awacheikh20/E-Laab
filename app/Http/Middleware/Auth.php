<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->status === 'etudiant') {
            return $next($request);
        }
        elseif ($request->user()->status === 'enseignant') {
            return $next($request);
        }
        
        abort(403, 'Accès non autorisé.');
        //return $next($request);
    }
}
