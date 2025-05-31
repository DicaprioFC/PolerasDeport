<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reporte de Ventas</title>
    <style>
        /** Aquí puedes poner estilos CSS “inline” que DomPDF entienda **/
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .fechas {
            text-align: center;
            margin-bottom: 10px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #444;
            padding: 6px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .totales {
            text-align: right;
            margin-right: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Reporte de Ventas</h1>
    </div>
    <div class="fechas">
        <span>Desde: {{ $fechaDesde }} &nbsp; | &nbsp; Hasta: {{ $fechaHasta }}</span>
    </div>

    @if ($ventas->isEmpty())
        <p>No se encontraron ventas en el rango seleccionado.</p>
    @else
        {{-- Tabla general de ventas --}}
        <table>
            <thead>
                <tr>
                    <th># Venta</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Cant. Items</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ number_format($venta->total, 2, ',', '.') }}</td>
                        <td>{{ $venta->detalles->sum('cantidad') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Total General --}}
        <div class="totales">
            Total general: {{ $ventas->sum('total') }}
        </div>

        <br><br>

        {{-- Detalle por venta --}}
        @foreach ($ventas as $venta)
            <h3>Detalle Venta #{{ $venta->id }} ({{ $venta->created_at->format('d/m/Y H:i') }})</h3>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($venta->detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->producto ? $detalle->producto->nombre : 'Sin producto' }}</td>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>{{ number_format($detalle->precio, 2, ',', '.') }}</td>
                            <td>{{ number_format($detalle->precio * $detalle->cantidad, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p style="text-align: right; margin-bottom: 20px;">
                Subtotal Venta:
                {{ number_format($venta->detalles->sum(function ($d) {
                    return $d->precio * $d->cantidad;
                }), 2, ',', '.') }}
            </p>
            <hr>
        @endforeach
    @endif

    <footer style="position: fixed; bottom: 0; text-align: center; width: 100%; font-size: 10px;">
        <span>Generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</span>
    </footer>
</body>

</html>
