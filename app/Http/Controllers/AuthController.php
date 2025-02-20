<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {

        if ($request->RazonSocial) {


            $empresa = Empresa::create(['NomComercial' => $request->NomComercial, 'RazonSocial' => $request->RazonSocial, 'FechaAlta' => $request->FechaAlta, 'Logotipo' => $request->Logotipo, 'Estado' => $request->Estado, 'Correo' => $request->Correo, 'password' => Hash::make($request->password), 'GUID' => $request->GUID]);
            return $empresa;
        } else {

            $usuario = User::create(['Clave' => Hash::make($request->Clave), 'Nombre' => $request->Nombre, 'Admin' => $request->Admin, 'Correo' => $request->Correo]);
            return $usuario;
        }
    }


    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required'
        ]);

        try {
          

            if (Auth::guard('empresa')->attempt(['Correo' => $request->input("correo"), 'password' => $request->input("password")])) {


                $user = Auth::guard('empresa')->user();

                $token = Crypt::encrypt(json_encode($user));

                session(['auth_token' => $token, 'auth_guard' => 'empresa']);

                return 'empresa';
            }
         

            $usuario = User::where('Correo', 'like', '%' . $request->input('correo') . '%')->first();
            if ($usuario && Hash::check($request->input('password'), $usuario->Clave)) {
                Auth::guard('web')->login($usuario);
                $user = Auth::guard('web')->user();
                $token = Crypt::encrypt(json_encode($user));
                session(['auth_token' => $token, 'auth_guard' => 'web']);
                return "usuario";

            }




            return response()->json(["Error" => "credenciales invalidas" ], 500);
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return response()->json(["Error" => "Algo salió mal: " . $e->getMessage()], 500);
        }
    }



    public function logout(Request $request)
    {

        if (session('auth_guard') == "empresa") {

            Auth::guard('empresa')->logout();
        } else {
            Auth::guard('web')->logout();
        }
        // Cerrar la sesión del guard

        $request->session()->forget('auth_token');
        $request->session()->forget('auth_guard');
        // Limpiar la sesión
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
