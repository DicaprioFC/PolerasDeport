<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Subir Oferta</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-gray-800 py-4 text-white text-center text-xl font-semibold">
        Panel de Administración
    </nav>

    <nav class="bg-gray-700 text-white py-3">
        <div class="flex justify-center gap-6">
            <a href="{{ route('admin.dashboard') }}" class="hover:underline">Inicio</a>
            <a href="{{ route('admin.reportes') }}" class="hover:underline">Reportes</a>
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
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.oferta.store') }}" class="space-y-6">
            @csrf

            {{-- NOMBRE --}}
            <div>
                <label for="nombre" class="block text-gray-800 font-semibold mb-1">Nombre del producto</label>
                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    value="{{ old('nombre') }}"
                    required
                    class="w-full border rounded px-3 py-2 @error('nombre') border-red-500 @enderror"
                />
                @error('nombre')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- DESCRIPCIÓN --}}
            <div>
                <label for="descripcion" class="block text-gray-800 font-semibold mb-1">Descripción</label>
                <textarea
                    id="descripcion"
                    name="descripcion"
                    rows="3"
                    class="w-full border rounded px-3 py-2 @error('descripcion') border-red-500 @enderror"
                >{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- PRECIO --}}
            <div>
                <label for="precio" class="block text-gray-800 font-semibold mb-1">Precio original (Bs)</label>
                <input
                    type="number"
                    id="precio"
                    name="precio"
                    step="0.01"
                    value="{{ old('precio') }}"
                    required
                    class="w-full border rounded px-3 py-2 @error('precio') border-red-500 @enderror"
                />
                @error('precio')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- DESCUENTO --}}
            <div>
                <label for="descuento" class="block text-gray-800 font-semibold mb-1">Descuento (%)</label>
                <input
                    type="number"
                    id="descuento"
                    name="descuento"
                    step="0.01"
                    value="{{ old('descuento') }}"
                    required
                    class="w-full border rounded px-3 py-2 @error('descuento') border-red-500 @enderror"
                />
                @error('descuento')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- MARCA --}}
            <div>
                <label for="marca" class="block text-gray-800 font-semibold mb-1">Marca</label>
                <input
                    type="text"
                    id="marca"
                    name="marca"
                    value="{{ old('marca') }}"
                    required
                    class="w-full border rounded px-3 py-2 @error('marca') border-red-500 @enderror"
                />
                @error('marca')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- URL DE IMAGEN --}}
            <div>
                <label for="imagen_url" class="block text-gray-800 font-semibold mb-1">URL de la imagen</label>
                <input
                    type="url"
                    id="imagen_url"
                    name="imagen_url"
                    value="{{ old('imagen_url') }}"
                    required
                    placeholder="https://..."
                    class="w-full border rounded px-3 py-2 @error('imagen_url') border-red-500 @enderror"
                />
                @error('imagen_url')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- BOTÓN --}}
            <div class="text-center">
                <button
                    type="submit"
                    class="bg-blue-600 text-white font-semibold px-6 py-2 rounded hover:bg-blue-700"
                >
                    Subir Oferta
                </button>
            </div>
        </form>
    </div>
</body>
</html>
