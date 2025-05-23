<?php

namespace App\Http\Middleware;

use App\Models\Empresa;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Payload;

class Authenticate extends Middleware
{
    protected function authenticate($request, array $guards)
    {
        
        $token = $request->header('Authorization')?? request()->cookie('jwt_token');
        $token=str_replace("bearer ",'',$token);
;
        Log::info('Token recibido: ' . json_encode($token));


        try {
            $payload = JWTAuth::setToken($token)->getPayload();
            $userId = $payload->get('sub');
            $guard = $payload->get('guard');
             
             // Intenta validar el token desde el encabezado "Authorization"
             if($guard=='empresa'){
             $user = Empresa::find($userId); 

            if ($user) {
                Auth::guard('empresa')->login($user); // Autentica manualmente al usuario
                Log::info("Usuario autenticado manualmente: " . json_encode($user));
            } else {
                Log::warning("Usuario no encontrado.");
                return response()->json(["error" => "Usuario no autenticado"], 401);
            }
            }else{
                $user = User::find($userId);
                if ($user) {
                Auth::guard('web')->login($user); 
                }else{
                     Log::warning("Usuario no encontrado.");
                     return response()->json(["error" => "Usuario no autenticado"], 401);
                }

            }


            Log::info('Usuario autenticado correctamente: ' . json_encode($user));
            return; // Si el usuario es válido, continúa con la solicitud

        } catch (JWTException $e) {
            Log::error('Error en la autenticación JWT: ' . $e->getMessage());
            $this->unauthenticated($request, $guards);
        }
    }

    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            Log::info('Redirigiendo al login.');
            return route('login');
        }
    }

    protected function unauthenticated($request, array $guards)
    {
        Log::warning('Usuario no autenticado, lanzando excepción.');
        throw new \Illuminate\Auth\AuthenticationException(
            'Unauthenticated.',
            $guards,
            $this->redirectTo($request)
        );
    }
}
