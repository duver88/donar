<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar que el usuario esté autenticado
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Verificar que sea super admin
        if ($user->role !== 'super_admin') {
            abort(403, 'Acceso denegado. Solo super administradores pueden acceder a esta sección.');
        }
        
        return $next($request);
    }
}