<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

use App\Http\Controllers\AdminController;

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
});



Route::get('/nikecliente', [ClienteController::class, 'productosNike']);
Route::get('/adidascliente', [ClienteController::class, 'productosAdidas']);
Route::get('/marathoncliente', [ClienteController::class, 'productosMarathon']);
Route::get('/marcamaracli', [ClienteController::class, 'productosMarcaMarathon']);
Route::get('/marcanikecli', [ClienteController::class, 'productosMarcaNike']);
Route::get('/otrasmarcas', [ClienteController::class, 'productosOtrasMarcas']);
Route::get('/ofertas', [ClienteController::class, 'productosOfertas']);
Route::get('/productos', [ClienteController::class, 'porMarca'])->name('productosPorMarca');


use App\Http\Controllers\CarritoController;

Route::middleware(['auth'])->group(function () {
    Route::get('/index', [CarritoController::class, 'mostrar'])->name('carrito.mostrar');
    Route::get('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::delete('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::post('/carrito/comprar', [CarritoController::class, 'comprar'])->name('carrito.comprar');
});


Route::get('/factura/{venta}', [CarritoController::class, 'factura'])->name('carrito.factura');

Route::get('/compra-exitosa', function () {
    return view('carrito.exito');
})->name('carrito.exito');



Route::get('/carrito', function () {
    return view('carrito');
})->middleware('auth')->name('carrito');




Route::get('/api/poleras', function (Request $request) {
    $marca = $request->query('marca');

    $query = DB::table('productos')
        ->join('users', 'productos.id_usuario', '=', 'users.id')
        ->select(
            'productos.id',
            'productos.nombre',
            'productos.precio',
            'productos.marca',
            'productos.imagen',
            'users.name as nombre_admin'
        );

    if ($marca) {
        $query->where('productos.marca', $marca);
    }

    $poleras = $query->orderByDesc('productos.id')->get();

    return response()->json([
        'marca_filtrada' => $marca ?? 'todas',
        'total_poleras' => $poleras->count(),
        'poleras' => $poleras
    ]);
});



require __DIR__.'/auth.php';
