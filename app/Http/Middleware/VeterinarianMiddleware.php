<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VeterinarianMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar que el usuario esté autenticado
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Verificar que sea veterinario
        if ($user->role !== 'veterinarian') {
            abort(403, 'Acceso denegado. Solo veterinarios pueden acceder a esta sección.');
        }

        // Verificar que esté aprobado
        if ($user->status !== 'approved') {
            return redirect()->route('home')->with('error', 'Tu cuenta está pendiente de aprobación por el administrador.');
        }
        
        return $next($request);
    }
}