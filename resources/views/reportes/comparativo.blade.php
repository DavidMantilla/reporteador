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
                <th>Año</th>
                <th>Total Ventas</th>
                <th> Numero Transacciones</th>
            </tr>
        </thead>
        <tbody>
      
            @foreach ($ventas as $venta)
                <tr>
                    <td>{{ $venta->Sucursal }}</td>
                    <td>{{ $venta->Anio }}</td>
                    <td>{{ $venta->Total_ventas }}</td>
                    <td>{{ $venta->Numero_Transacciones }}</td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
