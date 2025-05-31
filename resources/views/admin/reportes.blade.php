<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reportes de Ventas</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script> <!-- CDN de Tailwind -->
</head>

<body class="bg-gray-100 font-sans">

    <!-- Primera barra de navegación -->
    <nav class="bg-gray-800 py-4 text-white text-center text-xl font-semibold">
        Panel de Administración
    </nav>

    <!-- Segunda barra de navegación con enlaces -->
    <nav class="bg-gray-700 text-white py-3">
        <div class="flex justify-center gap-6">
            <a href="{{ route('admin.dashboard') }}" class="hover:underline">Inicio</a>
            <a href="{{ route('admin.oferta') }}" class="hover:underline">Subir Ofertas</a>
            <a href="{{ route('logout') }}" class="hover:underline"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Cerrar sesión
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </nav>

    <!-- Contenedor principal -->
    <div class="max-w-4xl mx-auto mt-8 bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Reportes de Ventas</h1>

        <!-- Selección de fechas -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label for="fecha_desde" class="block text-sm font-medium text-gray-700">Fecha inicio:</label>
                <input
                    type="date"
                    id="fecha_desde"
                    name="fecha_desde"
                    required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            <div>
                <label for="fecha_hasta" class="block text-sm font-medium text-gray-700">Fecha fin:</label>
                <input
                    type="date"
                    id="fecha_hasta"
                    name="fecha_hasta"
                    required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="flex flex-col sm:flex-row justify-center gap-4 mb-6">
            <form id="form-pdf" method="POST" action="{{ route('admin.pdf') }}">
                @csrf
                <input type="hidden" name="fecha_desde" id="hidden_fecha_desde">
                <input type="hidden" name="fecha_hasta" id="hidden_fecha_hasta">
                <button
                    type="submit"
                    class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded"
                >
                    Generar PDF
                </button>
            </form>

            <button
                id="btn-previsualizar"
                type="button"
                class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded"
            >
                Ver Previa
            </button>
        </div>

        <!-- Tabla de vista previa -->
        <div class="overflow-x-auto">
            <table
                id="tabla-previa"
                class="w-full border border-gray-300 rounded-lg overflow-hidden"
                style="display: none;"
            >
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 border text-center text-gray-700">ID</th>
                        <th class="p-2 border text-center text-gray-700">Fecha</th>
                        <th class="p-2 border text-center text-gray-700">Total</th>
                        <th class="p-2 border text-gray-700">Productos (Nombre - Cantidad)</th>
                    </tr>
                </thead>
                <tbody class="bg-white" id="tabla-previa-body">
                    <!-- Se llenará dinámicamente -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Script para AJAX y llenado de la tabla -->
    <script>
        document.getElementById('btn-previsualizar').addEventListener('click', function(e) {
            e.preventDefault();

            const desde = document.getElementById('fecha_desde').value;
            const hasta = document.getElementById('fecha_hasta').value;

            if (!desde || !hasta) {
                alert('Por favor, selecciona ambas fechas');
                return;
            }

            // Pasar fechas ocultas al form de PDF
            document.getElementById('hidden_fecha_desde').value = desde;
            document.getElementById('hidden_fecha_hasta').value = hasta;

            fetch('{{ route("admin.previsualizar") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ fecha_desde: desde, fecha_hasta: hasta })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                const tbody = document.querySelector('#tabla-previa tbody');
                tbody.innerHTML = '';

                if (data.ventas.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="4" class="text-center p-4 text-gray-500">
                                No hay ventas en ese rango
                            </td>
                        </tr>`;
                } else {
                    data.ventas.forEach(v => {
                        // Formatear fecha en formato local (dd/mm/yyyy)
                        const fecha = new Date(v.created_at).toLocaleDateString('es-ES');
                        const total = Number(v.total) || 0;

                        let detallesTexto = '';
                        if (v.detalles && v.detalles.length > 0) {
                            detallesTexto = v.detalles.map(d => {
                                const nombre = d.producto ? d.producto.nombre : 'Producto eliminado';
                                return `${nombre} - ${d.cantidad}`;
                            }).join(', ');
                        } else {
                            detallesTexto = 'No hay detalles';
                        }

                        tbody.innerHTML += `
                            <tr>
                                <td class="p-2 border text-center text-gray-600">${v.id}</td>
                                <td class="p-2 border text-center text-gray-600">${fecha}</td>
                                <td class="p-2 border text-center text-gray-600">${total.toFixed(2)}</td>
                                <td class="p-2 border text-gray-600">${detallesTexto}</td>
                            </tr>`;
                    });
                }

                // Mostrar la tabla
                document.getElementById('tabla-previa').style.display = 'table';
            })
            .catch(err => {
                console.error(err);
                alert('Ocurrió un error: ' + err.message);
            });
        });
    </script>

</body>

</html>
