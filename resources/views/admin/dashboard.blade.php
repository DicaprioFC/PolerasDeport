<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const marcaSelect = document.getElementById('marca');
            const otraMarca = document.getElementById('otraMarcaContainer');
            const inputOtra = document.getElementById('otraMarca');
            const toggleSidebar = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');

            if (marcaSelect) {
                function revisarMarca() {
                    if (marcaSelect.value === 'otras') {
                        otraMarca.classList.remove('hidden');
                        inputOtra.required = true;
                    } else {
                        otraMarca.classList.add('hidden');
                        inputOtra.required = false;
                        inputOtra.value = '';
                    }
                }

                marcaSelect.addEventListener('change', revisarMarca);
                revisarMarca();
            }

            if (toggleSidebar) {
                toggleSidebar.addEventListener('click', () => {
                    sidebar.classList.toggle('-translate-x-full');
                });
            }

            const ctx = document.getElementById('ventasChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul'],
                        datasets: [
                            {
                                label: 'Ventas',
                                data: [1200, 1800, 1500, 2400, 2100, 3000, 2800],
                                borderColor: '#3B82F6',
                                backgroundColor: 'rgba(59,130,246,0.15)',
                                fill: true,
                                tension: 0.4
                            },
                            {
                                label: 'Ingresos',
                                data: [900, 1300, 1200, 1900, 1700, 2400, 2200],
                                borderColor: '#10B981',
                                backgroundColor: 'rgba(16,185,129,0.10)',
                                fill: true,
                                tension: 0.4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    </script>
</head>

<body class="bg-slate-100 text-slate-800">

    <div class="min-h-screen flex">

        <!-- SIDEBAR -->
        <aside id="sidebar"
               class="fixed md:static inset-y-0 left-0 z-40 w-72 bg-slate-900 text-white transform md:translate-x-0 -translate-x-full transition duration-300 shadow-xl">
            
            <div class="h-16 flex items-center justify-between px-6 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center font-bold text-lg">
                        PD
                    </div>
                    <div>
                        <h1 class="font-bold text-lg">PolerasDepor</h1>
                        <p class="text-xs text-slate-400">Panel Admin</p>
                    </div>
                </div>

                <button class="md:hidden text-white" id="toggleSidebar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="px-6 py-5 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-slate-700 flex items-center justify-center">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div>
                        <p class="font-semibold">Administrador</p>
                        <p class="text-sm text-slate-400">Bienvenido de vuelta</p>
                    </div>
                </div>
            </div>

            <nav class="px-4 py-5 space-y-2">
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-blue-600 text-white">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.reportes') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition">
                    <i class="fas fa-file-alt"></i>
                    <span>Reportes</span>
                </a>

                <a href="{{ route('admin.oferta') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition">
                    <i class="fas fa-tags"></i>
                    <span>Subir Ofertas</span>
                </a>

                <a href="#formProducto" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition">
                    <i class="fas fa-shirt"></i>
                    <span>Productos</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition">
                    <i class="fas fa-cart-shopping"></i>
                    <span>Ventas</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition">
                    <i class="fas fa-box"></i>
                    <span>Inventario</span>
                </a>
            </nav>

            <div class="absolute bottom-0 left-0 w-full p-4 border-t border-slate-800">
                <a href="{{ route('logout') }}"
                   class="flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 transition rounded-lg py-3 font-semibold"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-right-from-bracket"></i>
                    Cerrar sesión
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </aside>

        <!-- CONTENIDO -->
        <div class="flex-1 md:ml-0 w-full">

            <!-- TOPBAR -->
            <header class="bg-white shadow-sm border-b border-slate-200 h-16 flex items-center justify-between px-4 md:px-8">
                <div class="flex items-center gap-4">
                    <button id="toggleSidebar" class="md:hidden text-slate-700 text-xl">
                        <i class="fas fa-bars"></i>
                    </button>

                    <div>
                        <h2 class="text-xl md:text-2xl font-bold text-slate-800">Dashboard</h2>
                        <p class="text-sm text-slate-500">Resumen general del panel administrativo</p>
                    </div>
                </div>

                <div class="hidden md:flex items-center gap-3">
                    <div class="bg-slate-100 px-4 py-2 rounded-lg text-sm text-slate-600">
                        <i class="fas fa-calendar-day mr-2"></i> Hoy
                    </div>
                </div>
            </header>

            <main class="p-4 md:p-8 space-y-8">

                <!-- ALERTAS -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- CARDS -->
                <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                    <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 text-white rounded-2xl p-6 shadow">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm opacity-90">Ventas totales</p>
                                <h3 class="text-3xl font-bold mt-1">Bs 8,450</h3>
                            </div>
                            <i class="fas fa-chart-line text-3xl opacity-80"></i>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-violet-500 to-violet-600 text-white rounded-2xl p-6 shadow">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm opacity-90">Pedidos</p>
                                <h3 class="text-3xl font-bold mt-1">124</h3>
                            </div>
                            <i class="fas fa-bag-shopping text-3xl opacity-80"></i>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-rose-500 to-rose-600 text-white rounded-2xl p-6 shadow">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm opacity-90">Pendientes</p>
                                <h3 class="text-3xl font-bold mt-1">9</h3>
                            </div>
                            <i class="fas fa-clock text-3xl opacity-80"></i>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-sky-500 to-sky-600 text-white rounded-2xl p-6 shadow">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm opacity-90">Productos</p>
                                <h3 class="text-3xl font-bold mt-1">{{ isset($productos) ? count($productos) : '0' }}</h3>
                            </div>
                            <i class="fas fa-box-open text-3xl opacity-80"></i>
                        </div>
                    </div>
                </section>

                <!-- GRAFICO + ACTIVIDAD -->
                <section class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                    <div class="xl:col-span-2 bg-white rounded-2xl shadow p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-xl font-bold">Rendimiento de ventas</h3>
                                <p class="text-sm text-slate-500">Resumen mensual del negocio</p>
                            </div>
                            <span class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded-full">Mensual</span>
                        </div>

                        <div class="h-80">
                            <canvas id="ventasChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow p-6">
                        <h3 class="text-xl font-bold mb-4">Actividad reciente</h3>

                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Compra procesada correctamente</p>
                                    <p class="text-sm text-slate-500">Hace 10 minutos</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                    <i class="fas fa-image"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Nueva imagen subida a Cloudinary</p>
                                    <p class="text-sm text-slate-500">Hace 30 minutos</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center">
                                    <i class="fab fa-paypal"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Pago recibido con PayPal</p>
                                    <p class="text-sm text-slate-500">Hace 1 hora</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-full bg-red-100 text-red-600 flex items-center justify-center">
                                    <i class="fab fa-google"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Nuevo ingreso con Google Auth</p>
                                    <p class="text-sm text-slate-500">Hace 2 horas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- FORMULARIO -->
                <section id="formProducto" class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                    <div class="xl:col-span-2 bg-white rounded-2xl shadow p-6">
                        <div class="mb-6">
                            <h3 class="text-2xl font-bold">Agregar nuevo producto</h3>
                            <p class="text-slate-500 text-sm">Registra una polera nueva en el sistema</p>
                        </div>

                        <form method="POST" action="{{ route('admin.store') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            <div>
                                <label for="nombre" class="block text-slate-700 font-semibold mb-2">Descripción de la polera</label>
                                <input type="text" id="nombre" name="nombre" required value="{{ old('nombre') }}"
                                       class="w-full border border-slate-300 rounded-xl px-4 py-3 bg-white text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="precio" class="block text-slate-700 font-semibold mb-2">Precio (Bs)</label>
                                    <input type="number" id="precio" name="precio" step="0.01" required value="{{ old('precio') }}"
                                           class="w-full border border-slate-300 rounded-xl px-4 py-3 bg-white text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                </div>

                                <div>
                                    <label for="marca" class="block text-slate-700 font-semibold mb-2">Marca</label>
                                    <select id="marca" name="marca" required
                                            class="w-full border border-slate-300 rounded-xl px-4 py-3 bg-white text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                        <option value="">-- Selecciona una marca --</option>
                                        <option value="Nike" {{ old('marca') == 'Nike' ? 'selected' : '' }}>Nike</option>
                                        <option value="Adidas" {{ old('marca') == 'Adidas' ? 'selected' : '' }}>Adidas</option>
                                        <option value="Marathon" {{ old('marca') == 'Marathon' ? 'selected' : '' }}>Marathon</option>
                                        <option value="MarcaNike" {{ old('marca') == 'MarcaNike' ? 'selected' : '' }}>MarcaNike</option>
                                        <option value="MarcaMarathon" {{ old('marca') == 'MarcaMarathon' ? 'selected' : '' }}>MarcaMarathon</option>
                                        <option value="otras" {{ old('marca') == 'otras' ? 'selected' : '' }}>Otras</option>
                                    </select>
                                </div>
                            </div>

                            <div id="otraMarcaContainer" class="hidden">
                                <label for="otraMarca" class="block text-slate-700 font-semibold mb-2">Especifica otra marca</label>
                                <input type="text" id="otraMarca" name="otraMarca" value="{{ old('otraMarca') }}"
                                       class="w-full border border-slate-300 rounded-xl px-4 py-3 bg-white text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>

                            <div>
                                <label for="imagen" class="block text-slate-700 font-semibold mb-2">Imagen del producto</label>
                                <input type="file" id="imagen" name="imagen" accept="image/*" required
                                       class="w-full border border-slate-300 rounded-xl px-4 py-3 bg-white text-slate-900 file:bg-blue-600 file:text-white file:px-4 file:py-2 file:rounded-lg file:border-0">
                            </div>

                            <div class="pt-2">
                                <button type="submit"
                                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-8 py-3 rounded-xl transition">
                                    <i class="fas fa-upload mr-2"></i> Subir producto
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- PANEL DERECHO -->
                    <div class="space-y-6">
                        <div class="bg-white rounded-2xl shadow p-6">
                            <h3 class="text-xl font-bold mb-4">Integraciones activas</h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between border-b pb-3">
                                    <span class="flex items-center gap-2"><i class="fab fa-google text-red-500"></i> Google Auth</span>
                                    <span class="text-green-600 font-semibold">Activo</span>
                                </div>
                                <div class="flex items-center justify-between border-b pb-3">
                                    <span class="flex items-center gap-2"><i class="fab fa-paypal text-blue-600"></i> PayPal</span>
                                    <span class="text-green-600 font-semibold">Activo</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="flex items-center gap-2"><i class="fas fa-cloud text-sky-500"></i> Cloudinary</span>
                                    <span class="text-green-600 font-semibold">Activo</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow p-6">
                            <h3 class="text-xl font-bold mb-4">Resumen rápido</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-slate-500">Ventas del día</p>
                                    <p class="text-2xl font-bold text-slate-800">Bs 1,250</p>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-500">Productos registrados</p>
                                    <p class="text-2xl font-bold text-slate-800">{{ isset($productos) ? count($productos) : 0 }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-500">Órdenes pendientes</p>
                                    <p class="text-2xl font-bold text-slate-800">4</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </main>
        </div>
    </div>

</body>
</html>