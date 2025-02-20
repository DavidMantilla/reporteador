<?php

namespace App\Http\Middleware;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{
    protected function authenticate($request, array $guards)
    {
        Log::info('Entrando en el middleware Authenticate.');

        $encryptedToken = session('auth_token');
        $sessionGuard = session('auth_guard');
        Log::info('Token de autenticación desencriptado: ' . json_encode($guards));
        if ($encryptedToken && in_array($sessionGuard, $guards)) {
            try {
                $tokenData = json_decode(Crypt::decrypt($encryptedToken), true); // Desencriptar y decodificar el token
                Log::info('Token de autenticación desencriptado: ' . json_encode($tokenData));
               

                // Validar los datos del usuario
                if ($sessionGuard == "empresa") {
                    
                    $user = Empresa::find($tokenData['Id_Empresa']);
                    
                    if ($user && $user->Correo === $tokenData['Correo']) {
                        Auth::guard($sessionGuard)->login($user); // Iniciar sesión del usuario
                        return;
                    }
                }
                else{
                    $user = User::find($tokenData['Id_Usuario']);
                    if ($user && $user->Correo === $tokenData['Correo']) {
                        Auth::guard($sessionGuard)->login($user); // Iniciar sesión del usuario
                        return;
                    }

                }
            } catch (\Exception $e) {
                Log::error('Error al desencriptar el token: ' . $e->getMessage());
            }
        }


        $this->unauthenticated($request, $guards);
    }

    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            Log::info('Redirigiendo al login.');
            return route('login');
        }
    }

    protected function unauthenticated($request, array $guards)
    {
        Log::info('Ningún guard autenticado, lanzando excepción de autenticación.');
        throw new \Illuminate\Auth\AuthenticationException(
            'Unauthenticated.',
            $guards,
            $this->redirectTo($request)
        );
    }
}
