<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function ofertas()
    {
        $productos = Producto::where('oferta', true)->get();
        return response()->json($productos);
    }

    // Publicar un nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'precio' => 'required|numeric',
            'marca' => 'required|string',
            'imagen' => 'required|string',
            'oferta' => 'boolean',
            'descuento' => 'nullable|numeric',
            'id_usuario' => 'required|exists:users,id',
        ]);

        return response()->json([
            'codigo_empresa' => 19,
            
        ], 201);

        $producto = Producto::create($request->all());

        return response()->json(['mensaje' => 'Producto creado', 'producto' => $producto], 201);
    }
}
