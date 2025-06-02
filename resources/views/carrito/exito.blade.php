<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Compra Exitosa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-light py-5">
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-body">
                <h1 class="text-success text-center mb-4">¡Compra exitosa!</h1>
                <p class="text-center">Gracias por tu compra.</p>

                {{-- Mostrar cod_autorizacion si existe --}}
                @if($venta->cod_autorizacion)
                <div class="alert alert-info text-center">
                    <strong>Código de Autorización:</strong> {{ $venta->cod_autorizacion }}
                </div>
                @endif

                {{-- Mostrar cuenta_generada si existe --}}
                @if($venta->cuenta_generada)
                <div class="alert alert-secondary text-center">
                    <strong>Cuenta Generada:</strong> {{ $venta->cuenta_generada }}
                </div>
                @endif

                {{-- Datos generales de la venta --}}
                <h3 class="mt-4">Detalles de la operación:</h3>
                <ul class="list-group mb-4">
                    <li class="list-group-item"><strong>ID de Venta:</strong> {{ $venta->id }}</li>
                    <li class="list-group-item"><strong>Total:</strong> Bs {{ number_format($venta->total, 2, ',', '.') }}</li>
                </ul>

                {{-- Tabla con los productos comprados --}}
                <h4>Resumen de productos:</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-3 align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Producto</th>
                                <th>Imagen</th>
                                <th>Cantidad</th>
                                <th>Precio (Bs)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detalles as $detalle)
                            <tr>
                                <td>{{ $detalle->producto->nombre }}</td>
                                <td>
                                    <img src="/{{ $detalle->producto->imagen }}"
                                         alt="Imagen del producto"
                                         style="width: 60px; height: auto; border-radius: 6px;" />
                                </td>
                                <td>{{ $detalle->cantidad }}</td>
                                <td>Bs {{ number_format($detalle->precio, 2, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total:</td>
                                <td class="fw-bold">Bs {{ number_format($venta->total, 2, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Botón para descargar la factura PDF --}}
                <div class="text-center mt-4">
                    <form action="{{ route('carrito.factura', $venta->id) }}" method="GET">
                        <button type="submit" class="btn btn-primary">
                            Descargar factura PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
