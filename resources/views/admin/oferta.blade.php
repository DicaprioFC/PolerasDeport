<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Subir Oferta</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<nav class="bg-gray-800 py-4 text-white text-center text-xl font-semibold">
    Panel de Administración
</nav>

<nav class="bg-gray-700 text-white py-3">
    <div class="flex justify-center gap-6">
        <a href="" class="hover:underline">Ver Pedidos</a>
        <a href="" class="hover:underline">Reportes</a>
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
    <h2 class="text-2xl font-bold text-center mb-6">Agregar Producto en Oferta</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.oferta.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label for="nombre" class="block text-gray-800 font-semibold mb-1">Nombre del producto</label>
            <input type="text" id="nombre" name="nombre" required class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label for="precio" class="block text-gray-800 font-semibold mb-1">Precio original (Bs)</label>
            <input type="number" id="precio" name="precio" step="0.01" required class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label for="descuento" class="block text-gray-800 font-semibold mb-1">Descuento (%)</label>
            <input type="number" id="descuento" name="descuento" step="0.01" required class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label for="marca" class="block text-gray-800 font-semibold mb-1">Marca</label>
            <input type="text" id="marca" name="marca" required class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label for="imagen" class="block text-gray-800 font-semibold mb-1">Imagen</label>
            <input type="file" id="imagen" name="imagen" accept="image/*" required class="w-full border rounded px-3 py-2" />
        </div>

        <div class="text-center">
            <button type="submit" class="bg-blue-600 text-white font-semibold px-6 py-2 rounded hover:bg-blue-700">
                Guardar Oferta
            </button>
        </div>
    </form>
</div>

</body>
</html>
