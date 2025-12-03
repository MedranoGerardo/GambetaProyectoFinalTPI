<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Usuario no autenticado
        if (!auth()->check()) {
            return redirect('/');
        }

        // El usuario NO tiene el rol necesario
        if (auth()->user()->role !== $role) {
            return redirect('/'); // o mostrar 403
        }

        return $next($request);
    }
}