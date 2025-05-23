<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="carrito.css"> <!-- Enlaza una hoja de estilo CSS llamada "estilo.css" -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <h1>Tu carrito</h1>
    <a href="{{ route('dashboard') }}">← Volver al inicio</a>

    <div class="contenedor-carrito">

        <!-- Lista de productos -->
        <div class="tabla-carrito">
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($items as $item)
                    @php
                    $subtotal = $item->cantidad * $item->producto->precio;
                    $total += $subtotal;
                    @endphp
                    <tr>
                        <td style="text-align: left;">
                            <img src="/{{ $item->producto->imagen }}" alt="Producto">


                            <div>{{ $item->producto->nombre }}</div>
                        </td>
                        <td>
                            <div class="cantidad-control">
                                <span>{{ $item->cantidad }}</span>
                            </div>
                        </td>
                        <td>Bs {{ number_format($item->producto->precio, 2) }}</td>
                        <td>Bs {{ number_format($subtotal, 2) }}</td>
                        <td>
                            <form action="{{ route('carrito.eliminar', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="eliminar-btn" type="submit"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Resumen -->
        <div class="resumen">
            <h3>Resumen de compra</h3>
            <p>Subtotal: <strong>Bs {{ number_format($total, 2) }}</strong></p>
            <form action="{{ route('carrito.comprar') }}" method="POST">
                @csrf
                <button type="submit" class="btn-pago">Procesar Pago</button>
            </form>
        </div>

    </div>
</body>

</html>