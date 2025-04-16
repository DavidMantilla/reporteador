<!DOCTYPE html>
<html>

<head>
    <title>Reporte de Ventas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 0.8px solid black;
        }

        th,
        td {
            padding: 3px;
            text-align: left;
            font-size: 11px;
        }

        th {
            background: #b6b5b5;
        }
    </style>
</head>

<body>
    <h1>Reporte de Ventas</h1>
    <table>
        <thead>
            <tr>
                <th> Sucursal</th>
                <th>Mes</th>
                <th>Total Ventas</th>
                <th> Numero Transacciones</th>
            </tr>
        </thead>
        <tbody>

            @php
                $anioAnterior = null;
                $meses = [
                    'Enero',
                    'Febrero',
                    'Marzo',
                    'Abril',
                    'Mayo',
                    'Junio',
                    'Julio',
                    'Agosto',
                    'Septiembre',
                    'Octubre',
                    'Noviembre',
                    'Diciembre',
                ];
                $totalAnio = 0;
                $totalTransacciones = 0;

                // Totales generales
                $totalGeneral = 0;
                $totalTransaccionesGeneral = 0;
            @endphp

            @foreach ($ventas as $venta)
                @if ($anioAnterior !== null && $anioAnterior !== $venta->Anio)
                    {{-- Total por año --}}
                    <tr style="background: #dfdede;">
                        <td colspan="2" style="text-align: center;">Total {{ $anioAnterior }}</td>
                        <td>{{ $totalAnio }}</td>
                        <td>{{ $totalTransacciones }}</td>
                    </tr>
                    @php
                        $totalAnio = 0;
                        $totalTransacciones = 0;
                    @endphp
                @endif

                @if ($anioAnterior !== $venta->Anio)
                    <tr style="background: #d2d2d2;">
                        <td colspan="4" style="text-align: center;">{{ $venta->Anio }}</td>
                    </tr>
                    @php
                        $anioAnterior = $venta->Anio;
                    @endphp
                @endif

                <tr>
                    <td>{{ $venta->Sucursal }}</td>
                    <td>{{ $meses[$venta->Mes - 1] }}</td>
                    <td>{{ $venta->Total_ventas }}</td>
                    <td>{{ $venta->Numero_Transacciones }}</td>
                </tr>

                @php
                    $totalAnio += $venta->Total_ventas;
                    $totalTransacciones += $venta->Numero_Transacciones;

                    $totalGeneral += $venta->Total_ventas;
                    $totalTransaccionesGeneral += $venta->Numero_Transacciones;
                @endphp
            @endforeach

            {{-- Total del último año --}}
            @if ($anioAnterior !== null)
                <tr style="background: #dfdede;">
                    <td colspan="2" style="text-align: center;">Total {{ $anioAnterior }}</td>
                    <td>{{ $totalAnio }}</td>
                    <td>{{ $totalTransacciones }}</td>
                </tr>
            @endif

            {{-- Total general --}}
            <tr style="background: #c0bebe; font-weight: bold;">
                <td colspan="2" style="text-align: center;">Total General</td>
                <td>{{ $totalGeneral }}</td>
                <td>{{ $totalTransaccionesGeneral }}</td>
            </tr>

        </tbody>
    </table>
</body>

</html>
