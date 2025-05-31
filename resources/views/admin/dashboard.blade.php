<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const marcaSelect = document.getElementById('marca');
            const otraMarca = document.getElementById('otraMarcaContainer');
            const inputOtra = document.getElementById('otraMarca');

            marcaSelect.addEventListener('change', () => {
                if (marcaSelect.value === 'otras') {
                    otraMarca.classList.remove('hidden');
                    inputOtra.required = true;
                } else {
                    otraMarca.classList.add('hidden');
                    inputOtra.required = false;
                }
            });
        });
    </script>
</head>
<body class="bg-gray-100">

<nav class="bg-gray-800 py-4 text-white text-center text-xl font-semibold">
    Panel de Administración
</nav>

<nav class="bg-gray-700 text-white py-3">
    <div class="flex justify-center gap-6">
        <a href="{{ route('admin.reportes') }}" class="hover:underline">Reportes</a>
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

<div class="max-w-xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-center mb-6">Agregar Nuevo Producto</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.store') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <div>
        <label for="nombre" class="block text-gray-800 text-base font-semibold mb-1">Descripción de la polera:</label>
        <input type="text" id="nombre" name="nombre" required
               class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
    </div>

    <div>
        <label for="precio" class="block text-gray-800 text-base font-semibold mb-1">Precio (Bs):</label>
        <input type="number" id="precio" name="precio" step="0.01" required
               class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
    </div>

    <div>
        <label for="marca" class="block text-gray-800 text-base font-semibold mb-1">Marca:</label>
        <select id="marca" name="marca" required
                class="w-full border border-gray-300 rounded px-3 py-2 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <option value="">-- Selecciona una marca --</option>
            <option value="Nike">Nike</option>
            <option value="Adidas">Adidas</option>
            <option value="Marathon">Marathon</option>
            <option value="MarcaNike">MarcaNike</option>
            <option value="MarcaMarathon">MarcaMarathon</option>
            <option value="Otras">Otras</option>
        </select>
    </div>

    <div id="otraMarcaContainer" class="hidden">
        <label for="otraMarca" class="block text-gray-800 text-base font-semibold mb-1">Especifica otra marca:</label>
        <input type="text" id="otraMarca" name="otraMarca"
               class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
    </div>

    <div>
        <label for="imagen" class="block text-gray-800 text-base font-semibold mb-1">Imagen del producto:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*" required
               class="w-full border border-gray-300 rounded px-3 py-2 file:bg-blue-600 file:text-white file:px-4 file:rounded">
    </div>

    <div class="text-center">
        <button type="submit"
                class="bg-green-600 text-white font-semibold px-6 py-2 rounded hover:bg-green-700 transition">
            Subir producto
        </button>
    </div>
</form>

</div>

</body>
</html>
