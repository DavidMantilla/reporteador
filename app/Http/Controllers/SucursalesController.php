<?php

namespace App\Http\Controllers;

use App\Models\sucursales;
use Illuminate\Http\Request;

class SucursalesController extends Controller
{
 
   function index(){


    
   }

  //store 
function store(Request $request){
      
      $validate=$request->validate([
            "slempresa"=>"required",
            "Sucursal"=>"required",
            "SUID"=>"required",

      ]);
    
      $status=$request->input("Estado")?"ACTIVO":"INACTIVO";
      $suc=["Id_Empresa"=>$validate["slempresa"],"Sucursal"=>$validate["Sucursal"],"SUID"=>$validate["SUID"],"estado"=>$status,"FechaAlta"=>date("Y-m-d H:i:s")];   
      
      $sucursal = sucursales::insert($suc);
      if($sucursal){

            return response()->json(['success' => 'Sucursal se ha creado exitosamente ']);
      }
      else{
            return response()->json(['error' => 'Sucursal no se ha creado ']); 
      }

}

}
