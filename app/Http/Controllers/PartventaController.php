<?php

namespace App\Http\Controllers;

use App\Models\partventa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartventaController extends Controller
{
     function index(Request $request){
       $empresa=$request->user("empresa")['Id_Empresa'];

        $producto=partventa::join('gg_ventas', 'gg_ventas.Id_Ventas', '=', 'gg_partvta.Id_Ventas')
        ->select(
            'gg_partvta.Articulo',
            'gg_partvta.Descripcion',
            DB::raw('SUM(gg_partvta.Cantidad) as cantidad'),
            DB::raw('SUM(gg_partvta.precio) as precio')
        )->where(
            'gg_ventas.Id_Empresa',$empresa
        )
        ->groupBy('gg_partvta.Articulo', 'gg_partvta.Descripcion')
        ->orderBy('cantidad', 'desc')
        ->limit(10)
        ->get();


        return $producto;
     }
}
