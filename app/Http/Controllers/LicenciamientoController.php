<?php

namespace App\Http\Controllers;

use App\Models\licenciamiento;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class LicenciamientoController extends Controller
{
    function  store(Request $request)
    {
        $validate = $request->validate([
            "slempresa" => "required",
            "slsucursal" => "required",
            "Id_Unico" => "required",
            "FechaInicial" => "required",
            "FechaFinal" => "required",
        ]);

       
        $status = $request->input("Estado") ? "ACTIVO" : "INACTIVO";
        $licencia = ["Id_Empresa" => $validate["slempresa"], "Id_Sucursal" => $validate["slsucursal"], "Id_Unico" => $validate["Id_Unico"], "FechaInicial" => $validate["FechaInicial"], "FechaFinal" => $validate["FechaFinal"], "FechaAlta" => date("Y-m-d H:i:s"), "estado" => $status];
       
        $lic = licenciamiento::insert($licencia);

        if ($lic) {
            return response()->json(['success' => 'la licencia se ha creado exitosamente ']);
        } else {
            return response()->json(['error' => 'la licencia no se ha creado ']);
        }
    }
}
