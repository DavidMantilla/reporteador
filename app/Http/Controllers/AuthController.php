<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Date;
use Tymon\JWTAuth\Facades\JWTAuth;

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
            
            if ($empresa && Hash::check($request->input('password'), $empresa->Clave)) {

                 $token = JWTAuth::fromUser($empresa);

                 return response()->json([
                        "tipo" => "empresa",
                        "access_token" => $token,
                        "token_type" => "Bearer",
                        "expires_in" => auth()->factory()->getTTL() * 60
                    ])->cookie('jwt_token', $token, 60, '/', null, true, true);

              
            } else if($empresa->password==$request->input('password')){
             
              
               $empresa->Clave=Hash::make($request->Clave);
               $empresa->save();
               $token = JWTAuth::fromUser($empresa);

                 return response()->json([
                        "tipo" => "empresa",
                        "access_token" => $token,
                        "token_type" => "Bearer",
                        "expires_in" => auth()->factory()->getTTL() * 60
                    ])->cookie('jwt_token', $token, 60, '/', null, true, true);
            }


            $usuario = User::where('Correo', '=', $request->input('correo'))->first();
            if ($usuario && Hash::check($request->input('password'), $usuario->Clave)) {
                  $token = JWTAuth::fromUser($usuario);


                  
            return response()->json([
                "tipo" => "usuario",
                "access_token" => $token,
                "token_type" => "Bearer",
                "expires_in" => auth()->factory()->getTTL() * 60
            ]) ->cookie('jwt_token', $token, 60, '/', null, true, true);




            }




            return response()->json(["Error" => "credenciales invalidas"], 500);
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return response()->json(["Error" => "Algo salió mal: " . $e->getMessage()], 500);
        }
    }



    public function logout(Request $request)
    {

        $token = $request->header('Authorization')?? request()->cookie('jwt_token');
        // Cerrar la sesión del guard
        $token=str_replace("bearer ",'',$token);
        JWTAuth::invalidate($token); 

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
