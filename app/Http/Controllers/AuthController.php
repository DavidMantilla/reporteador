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
use Illuminate\Support\Facades\Date;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {




        if ($request->RazonSocial) {

            $request->validate([
                'logotipo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);




            $imageName = time() . '.' . $request->logotipo->extension();
            $request->logotipo->move(public_path('images'), $imageName);
            $empresa = Empresa::create(['NomComercial' => $request->NomComercial, 'RazonSocial' => $request->RazonSocial, 'FechaAlta' =>  date("Y-m-d"), 'Logotipo' => $imageName, 'Estado' => $request->Estado, 'Correo' => $request->Correo, 'password' => Hash::make($request->password), 'GUID' => $request->GUID]);
            return $empresa;
        } else {

            $usuario = User::create(['Clave' => Hash::make($request->Clave), 'Nombre' => $request->Nombre, 'Admin' => $request->Admin, 'Correo' => $request->Correo]);
            return $usuario;
        }
    }


    public function update(Request $request)
    {



        if ($request->RazonSocial) {
            $data = [];
            $data["NomComercial"] = $request->NomComercial;
            $data["RazonSocial"] = $request->RazonSocial;
            $data["GUID"] = $request->GUID;
            $data["Estado"] = $request->Estado;
            $data["Correo"] = $request->Correo;

            if ($request->password != "") {

                $data["password"] =  Hash::make($request->password);
            }


            if ($request->file("logotipo")) {
                $imageName = time() . '.' . $request->logotipo->extension();
                $request->logotipo->move(public_path('images'), $imageName);
                $data["Logotipo"] = $imageName;
            }


            return Empresa::where('Id_Empresa', $request->id)->update($data);
        }else{
            $data = [];
            $data["Nombre"] = $request->Nombre;
            $data["Correo"] = $request->Correo;
            $data["Admin"] = $request->Admin;
         
            if ($request->Clave != "") {
                
                $data["Clave"] =  Hash::make($request->Clave);
            }
            print_r($request->all());

            return User::where('Id_Usuario',$request->id)->update($data);
        }
    }


    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required'
        ]);

        try {


            $empresa = Empresa::where('Correo', '=', $request->input('correo'))->where('Estado', "ACTIVO")->first();
            if ($empresa && Hash::check($request->input('password'), $empresa->password)) {

                Auth::guard('empresa')->login($empresa);
                $user = Auth::guard('empresa')->user();
                $token = Crypt::encrypt(json_encode($user));
                session(['auth_token' => $token, 'auth_guard' => 'empresa']);
                return "empresa";
            }


            $usuario = User::where('Correo', '=', $request->input('correo'))->first();
            if ($usuario && Hash::check($request->input('password'), $usuario->Clave)) {
                Auth::guard('web')->login($usuario);
                $user = Auth::guard('web')->user();
                $token = Crypt::encrypt(json_encode($user));
                session(['auth_token' => $token, 'auth_guard' => 'web']);
                return "usuario";
            }




            return response()->json(["Error" => "credenciales invalidas"], 500);
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


    public function getuser()
    {

        return  User::all();
    }

    public function getEmpresa()
    {

        return  Empresa::all();
    }
}
