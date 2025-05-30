<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\Api\ProductoController;

Route::get('/ofertas', [ProductoController::class, 'ofertas']);
Route::post('/ofertas', [ProductoController::class, 'store']);

use App\Http\Controllers\Api\VentaController;
Route::post('/ventas', [VentaController::class, 'store']);



use App\Http\Controllers\PromocionApiController;

Route::get('/productos/oferta', [PromocionApiController::class, 'productosEnOferta']);
