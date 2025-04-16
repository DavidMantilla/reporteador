<?php

namespace App\Exports;

use App\Models\Ventas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class CompFechaExport implements FromArray, WithEvents
{
    private $sucursal;
    private $empresa;
    public function __construct($sucursal, $empresa)
    {
      
        $this->sucursal = $sucursal;
        $this->empresa = $empresa;
    }
    public function array(): array
    { 
        $ventas = Ventas::query();

        $ventas->join('gg_sucursales', 'gg_sucursales.Id_Sucursal', '=', 'gg_ventas.Id_Sucursal')
            ->select('gg_sucursales.Sucursal')
            ->selectRaw('YEAR(FechaDoc) as Anio, MONTH(FechaDoc) as Mes, SUM(gg_ventas.Importe) as Total_ventas, COUNT(gg_ventas.Id_Ventas) as Numero_Transacciones')
            ->where('gg_sucursales.Id_Empresa', $this->empresa);
        
        if ($this->sucursal) {
            $ventas->where('gg_ventas.Id_Sucursal', $this->sucursal);
        }
        
        // Se agrupa por sucursal, año y mes para obtener la suma y el conteo correcto
        $ventas->groupBy('gg_sucursales.Sucursal', 'Anio', 'Mes')
               ->orderBy('Anio', 'desc');
        
        $dataventas = $ventas->get();
        //dd($dataventas);
        // Si aún deseas agrupar la colección por año para facilitar la presentación o el procesamiento adicional:
        $grouped = $dataventas->groupBy('Anio');
        
       
        $data = [];
        
        // Lista de nombres de meses en español
        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];

        // Recorremos cada grupo (año)
        foreach ($grouped as $anio => $ventasAnio) {
            // Fila que indica el año - se usará para agrupar visualmente
            $data[] = ["Año: {$anio}"];
            // Fila de encabezados para este grupo
            $data[] = ['Sucursal', 'Mes', 'Total Ventas', 'Número Transacciones'];
            // Iteramos los registros de ese año
            $totalVentas = 0;
            $totalTransacciones = 0;
            foreach ($ventasAnio as $venta) {
                $data[] = [
                    $venta->Sucursal,
                    $meses[$venta->Mes] ?? $venta->Mes,
                    $venta->Total_ventas,
                    $venta->Numero_Transacciones
                ];
                $totalVentas += $venta->Total_ventas;
                $totalTransacciones += $venta->Numero_Transacciones;
            }
            // Fila para totalizar por año
            $data[] = [
                'Total por año',
                '',
                $totalVentas,
                $totalTransacciones
            ]; 
            
            // Fila vacía para separar cada grupo
            $data[] = [];
        }
        
        return $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                // Recorremos las filas para identificar aquellas que contienen el título del año
                for ($row = 1; $row <= $highestRow; $row++) {
                    $value = $sheet->getCell("A{$row}")->getValue();
                    if (strpos($value, 'Año:') !== false) {
                        // Fusionamos columnas para el título del año (ajusta el rango según el número de columnas)
                        $sheet->mergeCells("A{$row}:D{$row}");
                        // Aplicamos estilos: texto en negrita, fondo claro y alineación centrada
                        $sheet->getStyle("A{$row}:D{$row}")->applyFromArray([
                            'font' => ['bold' => true],
                            'alignment' => [
                                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                            ],
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'E3E3E3'],
                            ],
                        ]);
                    }

                    // Aplicamos estilos a la fila de encabezados
                    if ($sheet->getCell("A{$row}")->getValue() == 'Sucursal') {
                        $sheet->getStyle("A{$row}:D{$row}")->applyFromArray([
                            'font' => ['bold' => true],
                            'alignment' => [
                                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                            ],
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'C0C0C0'],
                            ],
                        ]);
                    }

                    //negrita para la fila de totales por año
                    if ($sheet->getCell("A{$row}")->getValue() == 'Total por año') {
                        $sheet->getStyle("A{$row}:D{$row}")->applyFromArray([
                            'font' => ['bold' => true],
                            'alignment' => [
                                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                            ],
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'C0C0C0'],
                            ],
                        ]);
                    }
                }
            },
        ];
    }

    
}
