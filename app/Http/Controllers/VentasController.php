<?php

namespace App\Http\Controllers;

use App\Exports\ComparativoExport;
use App\Exports\MesExport;
use App\Exports\VentasExport;
use App\Models\ventas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class VentasController extends Controller
{
    
    function ExcelPeriodo(Request $request)
    {


        return Excel::download(new VentasExport($request->input("initialDate"), $request->input("finalDate"),$request->input('sucursal'),$request->user('empresa')->Id_Empresa), 'ventas.xlsx');
    }

    public function Pdfperiodo(Request $request)
    {
        $ventas = Ventas::query();

        $ventas->join('gg_sucursales','gg_sucursales.Id_Sucursal','=','gg_ventas.Id_Sucursal')
            ->select('gg_ventas.*', 'gg_sucursales.Sucursal')
            ->where('gg_sucursales.Id_Empresa', $request->user('empresa')->Id_Empresa);

      
        if ($request->filled('initialDate') && $request->filled('finalDate')) {
            $ventas->whereBetween('FechaDoc', [$request->input('initialDate'), $request->input('finalDate')]);
        }
        if($request->filled('sucursal')){
            $ventas->where('gg_ventas.Id_Sucursal', $request->input('sucursal'));
            
        }
   
        
      
     
      

        $ventas = $ventas->get();
        if ($ventas->isEmpty()) {
            return response()->json(['message' => 'No se encontraron registros para los filtros aplicados.'], 404);
        }

        $ventas->transform(function ($venta) {
            $venta->Facturado = number_format($venta->Facturado, 2, '.', '');
            return $venta;
        });
        
        $pdf = Pdf::loadView('reportes.ventas', compact('ventas'));
        return $pdf->download('ventas.pdf');
    }




    function ExcelComparativo(Request $request)
    {
        return Excel::download(new ComparativoExport($request->input('sucursal'),$request->user('empresa')->Id_Empresa), 'comparativo.xlsx');
    }

    public function Pdfcomparativo(Request $request)
    {
        $ventas = Ventas::query();

        $ventas->join('gg_sucursales','gg_sucursales.Id_Sucursal','=','gg_ventas.Id_Sucursal')
            ->select('gg_sucursales.Sucursal')
            ->selectRaw('Year(FechaDoc) as Anio,Sum(gg_ventas.Importe) as Total_ventas, count(gg_ventas.Id_Ventas) as Numero_Transacciones')
            ->where('gg_sucursales.Id_Empresa', $request->user('empresa')->Id_Empresa);

        if($request->filled('sucursal')){
            $ventas->where('gg_ventas.Id_Sucursal', $request->input('sucursal'));
            
        }
        
        $ventas->groupBy('Anio','gg_sucursales.Sucursal');
        $ventas->orderBy('Anio', 'desc');

     
      

        $ventas = $ventas->get();
        if ($ventas->isEmpty()) {
            return response()->json(['message' => 'No se encontraron registros para los filtros aplicados.'], 404);
        }

    
        
        $pdf = Pdf::loadView('reportes.comparativo', compact('ventas'));
        return $pdf->download('comparativo.pdf');
    }


    function ExcelMes(Request $request)
    {


        return Excel::download(new MesExport($request->input("month"), $request->input("year"),$request->input('sucursal'),$request->user('empresa')->Id_Empresa), 'ventas.xlsx');
    }

    public function PdfMes(Request $request)
    {
        $ventas = Ventas::query();

        $ventas->join('gg_sucursales','gg_sucursales.Id_Sucursal','=','gg_ventas.Id_Sucursal')
            ->select('gg_ventas.*', 'gg_sucursales.Sucursal')
            ->where('gg_sucursales.Id_Empresa', $request->user('empresa')->Id_Empresa);

      
        if ($request->filled('month') ) {
            $ventas->whereMonth('FechaDoc', [$request->input('month')]);
        }

        if ($request->filled('anio') ) {
            $ventas->whereYear('FechaDoc', [$request->input('anio')]);
        }
        if($request->filled('sucursal')){
            $ventas->where('gg_ventas.Id_Sucursal', $request->input('sucursal'));
            
        }
   
          
      

        $ventas = $ventas->get();
        if ($ventas->isEmpty()) {
            return response()->json(['message' => 'No se encontraron registros para los filtros aplicados.'], 404);
        }

        $ventas->transform(function ($venta) {
            $venta->Facturado = number_format($venta->Facturado, 2, '.', '');
            return $venta;
        });
        
        $pdf = Pdf::loadView('reportes.ventas', compact('ventas'));
        return $pdf->download('ventas.pdf');
    }


}
