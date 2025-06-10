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
            return redirect()->back()->with('error', 'El carrito está vacío.');
        }

        // 1) Calcular total
        $total = $items->sum(function ($item) {
            return $item->cantidad * $item->producto->precio;
        });

        // 2) Crear Venta sin cod_autorizacion ni cuenta_generada
        $venta = Venta::create([
            'user_id' => $userId,
            'total'   => $total,
        ]);

        // 3) Crear DetalleVenta
        foreach ($items as $item) {
            DetalleVenta::create([
                'venta_id'    => $venta->id,
                'producto_id' => $item->producto_id,
                'cantidad'    => $item->cantidad,
                'precio'      => $item->producto->precio,
                'monto'       => $item->cantidad * $item->producto->precio,
            ]);
        }

        //
        // ─── 4) Llamada a la API de FACTURACIÓN ───────────────────────────────────────
        //
        try {
            $facturaPayload = [
                'codigo'       => 19,
                'codoperacion' => $venta->id,
                'fecha'        => Carbon::now()->format('Y-m-d'),
                'montototal'   => $total,
                'detalle'      => $items->map(function ($item) {
                    return [
                        'codproducto' => $item->producto_id,
                        'cantidad'    => $item->cantidad,
                        'descripcion' => $item->producto->nombre,
                        'monto'       => $item->cantidad * $item->producto->precio,
                    ];
                })->toArray(),
            ];

            // **Aquí solo cambias la IP; la ruta sigue siendo /api/invoices**
            $facturaResp = Http::post('http://192.168.1.104/public/api/invoices', $facturaPayload);

            Log::info('>>> FACTURACIÓN: Payload enviado:', $facturaPayload);
            Log::info('>>> FACTURACIÓN: Respuesta:', $facturaResp->json());

            if ($facturaResp->successful()) {
                $facturaData = $facturaResp->json();
                $codAut = $facturaData['codautorizacion'] ?? null;

                if ($codAut) {
                    $venta->cod_autorizacion = $codAut;
                    $venta->save();
                }
                // Si no llega codautorizacion, lo dejamos null
            } else {
                Log::error("Facturación: error HTTP {$facturaResp->status()} - " . $facturaResp->body());
            }
        } catch (\Exception $e) {
            Log::error("Excepción en facturación: " . $e->getMessage());
        }

        //
        // ─── 5) Llamada a la API de CONTABILIDAD ───────────────────────────────────────
        try {
            $contabPayload = [
                'CodigoEmpresa' => 19,
                'Fecha'         => Carbon::now()->format('Y-m-d'),
                'Monto'         => $total,
            ];

            $contabResp = Http::post('http://192.168.1.101:50570/api/transaccion/registrar', $contabPayload);

            Log::info('>>> CONTABILIDAD: Payload enviado:', $contabPayload);
            Log::info('>>> CONTABILIDAD: Respuesta:', $contabResp->json());

            if ($contabResp->successful()) {
                $contabData = $contabResp->json();
                $cuentaGen = $contabData['cuenta_generada'] ?? null;

                if ($cuentaGen) {
                    $venta->cuenta_generada = $cuentaGen;
                    $venta->save();
                }
            } else {
                Log::error("Contabilidad: error HTTP {$contabResp->status()} - " . $contabResp->body());
            }
        } catch (\Exception $e) {
            Log::error("Excepción en contabilidad: " . $e->getMessage());
        }


        // 6) Vaciar carrito y redirigir a vista de éxito
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
