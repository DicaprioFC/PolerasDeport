<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'productos' => 'required|array',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $total = 0;

            // Calcular total
            foreach ($request->productos as $item) {
                $producto = Producto::find($item['producto_id']);
                $subtotal = $producto->precio * $item['cantidad'];
                $total += $subtotal;
            }
            $userId = $request->user_id;
            // Guardar venta
            $venta = Venta::create([
                'user_id' => $userId,
                'total' => $total,
            ]);

            // Guardar detalle
            foreach ($request->productos as $item) {
                $producto = Producto::find($item['producto_id']);
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio' => $producto->precio,
                ]);
            }

            DB::commit();

            return response()->json(['mensaje' => '✅ Compra realizada con exito.'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => '❌ Error al realizar su compra.'], 500);
        }
    }
}
