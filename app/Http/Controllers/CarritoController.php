<?php

// app/Http/Controllers/CarritoController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use App\Models\Venta;
use App\Models\DetalleVenta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CarritoController extends Controller
{
    public function agregar($id)
    {
        $producto = Producto::findOrFail($id);

        $carrito = Carrito::where('user_id', Auth::id())
            ->where('producto_id', $id)
            ->first();

        if ($carrito) {
            $carrito->cantidad += 1;
            $carrito->save();
        } else {
            Carrito::create([
                'user_id' => Auth::id(),
                'producto_id' => $id,
                'cantidad' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }

    public function mostrar()
    {
        $items = Carrito::with('producto')->where('user_id', Auth::id())->get();
        return view('carrito.index', compact('items'));
    }

    public function eliminar($id)
    {
        Carrito::where('id', $id)->where('user_id', Auth::id())->delete();
        return redirect()->back()->with('success', 'Producto eliminado del carrito');
    }

    public function comprar()
    {
        $userId = Auth::id();
        $items  = Carrito::with('producto')->where('user_id', $userId)->get();
    
        if ($items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'El carrito está vacío.'
            ], 400);
        }
    
        $total = $items->sum(function ($item) {
            return $item->cantidad * $item->producto->precio;
        });
    
        $venta = Venta::create([
            'user_id' => $userId,
            'total'   => $total,
            // cod_autorizacion por defecto NULL
        ]);
    
        foreach ($items as $item) {
            DetalleVenta::create([
                'venta_id'    => $venta->id,
                'producto_id' => $item->producto_id,
                'cantidad'    => $item->cantidad,
                'precio'      => $item->producto->precio,
                'monto'       => $item->cantidad * $item->producto->precio,
            ]);
        }
    
        $payload = [
            'codigo'      => 19,
            'codoperacion' => $venta->id,
            'fecha'       => Carbon::now()->format('Y-m-d'),
            'montototal'  => $total,
            'detalle'     => $items->map(function ($item) {
                return [
                    'codproducto' => $item->producto_id,
                    'cantidad'    => $item->cantidad,
                    'descripcion' => $item->producto->nombre,
                    'monto'       => $item->cantidad * $item->producto->precio,
                ];
            })->toArray(),
        ];
    
        try {
            $response = Http::post('http://192.168.63.76/public/api/invoices', $payload);
    
            Log::info('Envió factura externa:', $payload);
            Log::info('Respuesta externa:', $response->json());
    
            if ($response->successful()) {
                $data = $response->json();
                $codAut = $data['codautorizacion'] ?? null;
                $venta->cod_autorizacion = $codAut;
                $venta->save();
            } else {
                Log::error('Error al facturar externamente: ' . $response->body());
                // No hacemos throw, dejamos cod_autorizacion null
            }
        } catch (\Exception $e) {
            Log::error('Excepción facturación externa: ' . $e->getMessage());
            // No hacemos throw, dejamos cod_autorizacion null
        }
    
        // Vaciar carrito igual
        Carrito::where('user_id', $userId)->delete();
    
        return redirect()->route('carrito.exito', ['venta' => $venta->id]);
    }
    


    public function factura($id)
    {
        $venta = Venta::with('detalles.producto')->findOrFail($id);

        $pdf = Pdf::loadView('carrito.factura', ['venta' => $venta]);

        return $pdf->download('factura-compra.pdf');
    }
}
