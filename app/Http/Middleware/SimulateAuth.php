<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class SimulateAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Simulamos un usuario autenticado
        if (!auth()->check()) {
            // Buscamos el usuario administrador en la base de datos
            $user = User::first();
            
            if ($user) {
                // Asignamos el usuario a la sesión
                auth()->login($user);
            }
        }
        
        return $next($request);
    }
}
