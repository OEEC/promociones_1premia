<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/login'); // Redirigir a login si no está autenticado
        }

        if (Auth::user()->role != $role) {
            abort(403, 'No tienes acceso a esta página.'); // Error 403 si el rol no coincide
        }

        return $next($request);
    }
}
