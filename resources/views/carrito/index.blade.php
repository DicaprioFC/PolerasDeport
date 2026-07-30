<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu carrito</title>

    <link rel="stylesheet" href="{{ asset('carrito.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <h1>Tu carrito</h1>

    @if (session('success'))
    <div style="background: #d1e7dd; color: #0f5132; padding: 12px; border-radius: 6px; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div style="background: #f8d7da; color: #842029; padding: 12px; border-radius: 6px; margin-bottom: 15px;">
        {{ session('error') }}
    </div>
    @endif

    <a href="{{ route('dashboard') }}">← Volver al inicio</a>

    <div class="contenedor-carrito">

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

                    $imagen = $item->producto->imagen;
                    $imagenLimpia = $imagen ? ltrim($imagen, '/') : null;

                    $srcImagen = filter_var($imagenLimpia, FILTER_VALIDATE_URL)
                    ? $imagenLimpia
                    : asset($imagenLimpia ?? 'imagenes/default.png');
                    @endphp

                    <tr>
                        <td style="text-align: left;">
                            <img src="{{ $srcImagen }}"
                                alt="{{ $item->producto->nombre }}"
                                style="width: 70px; height: 70px; object-fit: contain;">

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

                                <button class="eliminar-btn" type="submit">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="resumen">
            <h3>Resumen de compra</h3>

            <p>Subtotal: <strong>Bs {{ number_format($total, 2) }}</strong></p>

            <form action="{{ route('carrito.paypal') }}" method="POST">
                @csrf

                <button type="submit">
                    Pagar con PayPal
                </button>
            </form>
        </div>

    </div>
</body>

</html>