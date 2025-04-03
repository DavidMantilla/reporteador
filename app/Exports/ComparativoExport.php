<?php

namespace App\Exports;

use App\Models\Ventas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ComparativoExport implements FromCollection,WithHeadings
{
 
    
    private $sucursal;
    private $empresa;

    /**
     * Create a new instance of the class.
     *
     * 
     * @param int $sucursal
     * @param int $empresa
     */
    public function __construct($sucursal, $empresa)
    {
      
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
            return ['Sucursal','año','Total Ventas','Numero Transacciones'];
        }

        //return the collection of data to be exported
    /**
     * @return \Illuminate\Support\Collection
     */ 
    
    public function collection()
    { 
        
        $ventas = Ventas::query();

        $ventas->join('gg_sucursales','gg_sucursales.Id_Sucursal','=','gg_ventas.Id_Sucursal')
            ->select( 'gg_sucursales.Sucursal')
            ->selectRaw('Year(FechaDoc) as Anio,Sum(gg_ventas.Importe) as Total_ventas, count(gg_ventas.Id_Ventas) as Numero_Transacciones')
            ->where('gg_sucursales.Id_Empresa', $this->empresa );

        if($this->sucursal){
            $ventas->where('gg_ventas.Id_Sucursal', $this->sucursal);
            
        }
        
        $ventas->groupBy('Anio','gg_sucursales.Sucursal');
        $ventas->orderBy('Anio', 'desc');

     
      

        return $ventas->get();
    }
}
