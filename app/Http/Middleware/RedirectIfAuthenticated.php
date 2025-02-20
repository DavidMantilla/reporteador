<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, ...$guards)
    {
        Log::info('Entrando en el middleware RedirectIfAuthenticated.');
        Log::info('Guards recibidos: ' . implode(', ', $guards));

        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            Log::info('Verificando guard: ' . $guard);
            if (Auth::guard($guard)->check()) {
                Log::info('Usuario autenticado con guard: ' . $guard);

                if ($guard == "web") {
                    Log::info('Redirigiendo a /usuario');
                    return redirect('/usuario');
                } else {
                    Log::info('Redirigiendo a /empresa');
                    return redirect('/empresa');
                }
            } else {
                Log::info('Usuario no autenticado con guard: ' . $guard);
            }
        }

        Log::info('Ningún guard autenticado, continuando con la solicitud.');
        return $next($request);
    }
}
