<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Inventario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #4CAF50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 3px rgba(0,0,0,0.1);
        }
        table thead {
            background-color: #4CAF50;
            color: #ffffff;
        }
        table th, table td {
            padding: 12px;
            text-align: center;
        }
        table th {
            background-color: #4CAF50;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table tr:hover {
            background-color: #e9f5e9;
        }
        table td {
            border: 1px solid #dddddd;
        }
    </style>
</head>
<body>
    <h1>Reporte de Inventario</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Cantidad Ingresada</th>
                <th>Cantidad Actual</th>
                <th>Costo Unitario</th>
                <th>Fecha de Ingreso</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventarios as $inventario)
                <tr>
                    <td>{{ $inventario->id }}</td>
                    <td>{{ $inventario->producto->nombre }}</td>
                    <td>{{ $inventario->cantidad_ingresada }}</td>
                    <td>{{ $inventario->cantidad_actual }}</td>
                    <td>{{ number_format($inventario->costo_unitario, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($inventario->fecha_ingreso)->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
