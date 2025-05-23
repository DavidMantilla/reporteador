<?php

namespace App\Exports;

use App\Models\Ventas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VentasExport implements FromCollection,WithHeadings
{
 
    private $fechaDesde;
    private $fechaHasta;
    private $sucursal;
    private $empresa;

    /**
     * Create a new instance of the class.
     *
     * @param string $desde
     * @param string $hasta
     * @param int $sucursal
     * @param int $empresa
     */
    public function __construct($desde, $hasta,$sucursal, $empresa)
    {
        $this->fechaDesde = $desde;
        $this->fechaHasta = $hasta;
        $this->sucursal = $sucursal;
        $this->empresa = $empresa;
        }
    
        /**
         * Return the headings for the export.
         *
         * @return array
         */
        public function headings(): array
        {
            return ['Sucursal','Tipo documento' ,'Fecha','Codigo Cliente','Nombre','Moneda','Importe','Descuento','Impuesto','Total'];
        }

        //return the collection of data to be exported
    /**
     * @return \Illuminate\Support\Collection
     */ 
    
    public function collection()
    { 
        
        $ventas = Ventas::query();
        $ventas->join('gg_sucursales','gg_sucursales.Id_Sucursal','=','gg_ventas.Id_Sucursal')
            ->select('gg_sucursales.Sucursal','gg_ventas.Tipo_Doc','gg_ventas.FechaDoc','gg_ventas.Cliente','gg_ventas.NombreCliente','gg_ventas.Moneda','gg_ventas.Importe','gg_ventas.Descuento','gg_ventas.Impuesto')->selectRaw('(gg_ventas.Importe - gg_ventas.Descuento + gg_ventas.Impuesto) as Total');
        
            $ventas->where('gg_sucursales.Id_Empresa', $this->empresa);

        if ($this->fechaDesde && $this->fechaHasta) {
            $ventas->whereBetween('FechaDoc', [$this->fechaDesde, $this->fechaHasta]);
        }
        if($this->sucursal){
            $ventas->where('gg_ventas.Id_Sucursal', $this->sucursal);
            
        }
        return $ventas->get();
    }
}
