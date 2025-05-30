<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        img { width: 60px; height: auto; }
    </style>
</head>
<body>
    <h2>Factura de Compra</h2>
    <p><strong>Cliente:</strong> {{ Auth::user()->name }}</p>
    <p><strong>Fecha:</strong> {{ $venta->created_at->format('d/m/Y H:i') }}</p>

    @if($venta->cod_autorizacion)
        <p><strong>Código de Autorización:</strong> {{ $venta->cod_autorizacion }}</p>
    @endif

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
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>Bs {{ number_format($detalle->precio, 2) }}</td>
                    <td>Bs {{ number_format($detalle->cantidad * $detalle->precio, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total: Bs {{ number_format($venta->total, 2) }}</h3>
</body>
</html>
