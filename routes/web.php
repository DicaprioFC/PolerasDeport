<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Models\Venta;
use App\Http\Controllers\ClienteController;
use App\Models\DetalleVenta;
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

    Route::get('/admin/ofertas', [AdminController::class, 'formOferta'])->name('admin.oferta');
    Route::post('/admin/ofertas', [AdminController::class, 'storeOferta'])->name('admin.oferta.store');
});



Route::get('/nikecliente', [ClienteController::class, 'productosNike']);
Route::get('/adidascliente', [ClienteController::class, 'productosAdidas']);
Route::get('/marathoncliente', [ClienteController::class, 'productosMarathon']);
Route::get('/marcamaracli', [ClienteController::class, 'productosMarcaMarathon']);
Route::get('/marcanikecli', [ClienteController::class, 'productosMarcaNike']);
Route::get('/otrasmarcas', [ClienteController::class, 'productosOtrasMarcas']);
Route::get('/Ofertas', [ClienteController::class, 'productosOfertas']);
Route::get('/productos', [ClienteController::class, 'porMarca'])->name('productosPorMarca');


use App\Http\Controllers\CarritoController;


Route::middleware(['auth'])->group(function () {

    // Mostrar carrito
    Route::get('/carrito', [CarritoController::class, 'mostrar'])
        ->name('carrito.mostrar');

    // Si antes usabas /index, lo dejamos redirigiendo al carrito
    Route::get('/index', function () {
        return redirect()->route('carrito.mostrar');
    });

    // Agregar producto al carrito
    Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])
        ->name('carrito.agregar');

    // Eliminar producto del carrito
    Route::delete('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])
        ->name('carrito.eliminar');

   

    // Pagar con PayPal
    Route::post('/carrito/pagar-paypal', [CarritoController::class, 'pagarConPaypal'])
        ->name('carrito.paypal');

    // Retorno exitoso desde PayPal
    Route::get('/paypal/exito', [CarritoController::class, 'paypalExito'])
        ->name('paypal.exito');

    // Retorno cancelado desde PayPal
    Route::get('/paypal/cancelado', [CarritoController::class, 'paypalCancelado'])
        ->name('paypal.cancelado');

    Route::get('/carrito/exito/{venta}', [CarritoController::class, 'exito'])
        ->name('carrito.exito');

    // Descargar factura
    Route::get('/factura/{venta}', [CarritoController::class, 'factura'])
        ->name('carrito.factura');
});

use App\Http\Controllers\ReporteVentaController;

Route::prefix('admin')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/reportes', [ReporteVentaController::class, 'index'])->name('admin.reportes');
        Route::post('/reportes/pdf', [ReporteVentaController::class, 'generarPDF'])->name('admin.pdf');
    });


Route::post('/admin/previsualizar', [ReporteVentaController::class, 'previsualizar'])->name('admin.previsualizar');



use App\Http\Controllers\PromocionController;

Route::get('/ofertas', [PromocionController::class, 'vistaPublica']);


require __DIR__ . '/auth.php';



use App\Http\Controllers\Auth\GoogleAuthController;

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])
    ->name('google.redirect');

Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])
    ->name('google.callback');
