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

                <h3 class="mt-4">Resumen de compra:</h3>
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
                                        <img src="/{{ $detalle->producto->imagen }}" alt="Imagen del producto" style="width: 60px; height: auto; border-radius: 6px;" />
                                    </td>
                                    <td>{{ $detalle->cantidad }}</td>
                                    <td>{{ number_format($detalle->precio, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total:</td>
                                <td class="fw-bold">Bs {{ number_format($venta->total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="text-center mt-4">
                    <form action="{{ route('carrito.factura', $venta->id) }}" method="GET">
                        <button type="submit" class="btn btn-primary">Descargar factura PDF</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
