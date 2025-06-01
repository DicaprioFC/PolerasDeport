<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class OfertaApiController extends Controller
{
    public function index()
    {
        $ofertas = Producto::where('oferta', true)->get();

        $response = $ofertas->map(function ($producto) {
            return [
                'codigo de empresa' => '19',
                'Descuento' => $producto->descuento . '%',
                'nombre' => $producto->nombre,
                'imagen' => $producto->imagen,
                'descripcion' => $producto->descripcion,
            ];
        });;

        return response()->json($response);
    }
}
