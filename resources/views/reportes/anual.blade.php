<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Ventas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 0.8px solid black;
        }
        th, td {
            padding: 3px;
            text-align: left;
            font-size: 11px;
        }
        th{
            background: #b6b5b5;
        }
    </style>
</head>
<body>
    <h1>Reporte de Ventas</h1>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Sucursal</th>
                <th>Cliente</th>
                <th>Moneda</th>
                <th>Importe</th>
                <th>Impuesto</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $venta)
            <tr>
                <td>{{ date("d/m/Y", strtotime($venta->FechaDoc)) }}</td>
                <td>{{ $venta->Sucursal }}</td>
                <td>{{ $venta->NombreCliente }}</td>
                <td>{{ $venta->Moneda }}</td>
                <td>{{ $venta->Importe }}</td>
                <td>{{ $venta->Impuesto }}</td>
                <td>{{ $venta->Importe-$venta->Descuento+$venta->Impuesto }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
