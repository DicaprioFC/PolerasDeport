<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


use App\Http\Controllers\Api\OfertaApiController;

Route::get('/ofertas', [OfertaApiController::class, 'index']);


use App\Http\Controllers\PromocionController;

Route::get('/productos/oferta', [PromocionController::class, 'productosEnOferta']);
