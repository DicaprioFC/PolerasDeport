<style>
 /* Estilos para el título */
 h1 {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }

    /* Estilos para el enlace INICIO */
    li {
        list-style: none;
        margin: 10px 0 30px 20px;
    }

    li a {
        text-decoration: none;
        color: #007BFF;
        font-weight: 600;
        font-family: Arial, sans-serif;
    }

    li a:hover {
        text-decoration: underline;
    }

    /* Estilos para la tabla */
    table {
        width: 90%;
        margin: 0 auto 30px auto;
        border-collapse: collapse;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        font-family: 'Arial', sans-serif;
    }

    /* Encabezado de la tabla */
    thead tr {
        background-color: #007BFF;
        color: white;
        text-align: left;
    }

    thead th {
        padding: 12px 15px;
    }

    /* Filas de la tabla */
    tbody tr {
        border-bottom: 1px solid #ddd;
    }

    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tbody td {
        padding: 12px 15px;
        vertical-align: middle;
    }

    /* Botón eliminar */
    button[type="submit"] {
        background-color: #dc3545; /* rojo */
        color: white;
        border: none;
        padding: 7px 12px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        font-family: Arial, sans-serif;
    }

    button[type="submit"]:hover {
        background-color: #c82333;
    }

    /* Total y botón finalizar compra */
    h3 {
        width: 90%;
        margin: 0 auto 20px auto;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #222;
        text-align: right;
    }

    form[action$="comprar"] button {
        background-color: #28a745; /* verde */
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        display: block;
        margin: 0 auto 40px auto;
        transition: background-color 0.3s ease;
        font-family: Arial, sans-serif;
    }

    form[action$="comprar"] button:hover {
        background-color: #218838;
    }

</style>
    <h1>Tu carrito</h1>
    <li><a href="{{ route('dashboard') }}">INICIO</a></li>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($items as $item)
                @php $subtotal = $item->cantidad * $item->producto->precio; $total += $subtotal; @endphp
                <tr>
                    <td>{{ $item->producto->nombre }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>Bs {{ number_format($item->producto->precio, 2) }}</td>
                    <td>Bs {{ number_format($subtotal, 2) }}</td>
                    <td>
                        <form action="{{ route('carrito.eliminar', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h3>Total: Bs {{ number_format($total, 2) }}</h3>

    <form action="{{ route('carrito.comprar') }}" method="POST">
        @csrf
        <button type="submit">Finalizar compra</button>
    </form>

