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

        $total = $items->sum(function ($item) {
            return $item->cantidad * $item->producto->precio;
        });

        $venta = $this->finalizarCompra($userId, $items, $total);

        return redirect()->route('carrito.exito', ['venta' => $venta->id]);
    }

    private function obtenerTokenPaypal()
    {
        $baseUrl = config('services.paypal.base_url');

        $response = Http::asForm()
            ->withBasicAuth(
                config('services.paypal.client_id'),
                config('services.paypal.client_secret')
            )
            ->post($baseUrl . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        if (!$response->successful()) {
            Log::error('PAYPAL TOKEN ERROR: ' . $response->body());
            throw new \Exception('No se pudo obtener el token de PayPal.');
        }

        return $response->json()['access_token'];
    }


    public function factura($id)
    {
        $venta = Venta::with('detalles.producto')->findOrFail($id);

        $pdf = Pdf::loadView('carrito.factura', ['venta' => $venta]);

        return $pdf->download('factura-compra.pdf');
    }

    public function pagarConPaypal()
    {
        $userId = Auth::id();

        $items = Carrito::with('producto')->where('user_id', $userId)->get();

        if ($items->isEmpty()) {
            return redirect()->back()->with('error', 'El carrito está vacío.');
        }

        $totalBs = $items->sum(function ($item) {
            return $item->cantidad * $item->producto->precio;
        });

        $tasaCambio = (float) config('services.paypal.bob_rate', 6.96);
        $totalUsd = round($totalBs / $tasaCambio, 2);

        try {
            $baseUrl = config('services.paypal.base_url');
            $accessToken = $this->obtenerTokenPaypal();

            $response = Http::withToken($accessToken)
                ->post($baseUrl . '/v2/checkout/orders', [
                    'intent' => 'CAPTURE',
                    'purchase_units' => [
                        [
                            'description' => 'Compra en PolerasDepor',
                            'amount' => [
                                'currency_code' => config('services.paypal.currency', 'USD'),
                                'value' => number_format($totalUsd, 2, '.', ''),
                            ],
                        ],
                    ],
                    'application_context' => [
                        'brand_name' => 'PolerasDepor',
                        'user_action' => 'PAY_NOW',
                        'return_url' => route('paypal.exito'),
                        'cancel_url' => route('paypal.cancelado'),
                    ],
                ]);

            if (!$response->successful()) {
                Log::error('PAYPAL CREATE ORDER ERROR: ' . $response->body());
                return redirect()->back()->with('error', 'No se pudo crear la orden de pago.');
            }

            $orden = $response->json();

            foreach ($orden['links'] ?? [] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }

            return redirect()->back()->with('error', 'No se encontró el enlace de aprobación de PayPal.');
        } catch (\Exception $e) {
            Log::error('PAYPAL ERROR: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al conectar con PayPal.');
        }
    }
    public function paypalExito(Request $request)
    {
        $orderId = $request->query('token');

        if (!$orderId) {
            return redirect()->route('carrito.mostrar')
                ->with('error', 'No se recibió el token de PayPal.');
        }

        try {
            $baseUrl = config('services.paypal.base_url');
            $accessToken = $this->obtenerTokenPaypal();

            $url = $baseUrl . "/v2/checkout/orders/{$orderId}/capture";

            $response = Http::withToken($accessToken)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->send('POST', $url, [
                    'body' => '{}',
                ]);

            Log::info('>>> PAYPAL CAPTURE STATUS: ' . $response->status());
            Log::info('>>> PAYPAL CAPTURE BODY: ' . $response->body());

            if (!$response->successful()) {
                Log::error('PAYPAL CAPTURE ERROR: ' . $response->body());

                return redirect()->route('carrito.mostrar')
                    ->with('error', 'PayPal no pudo confirmar el pago. Revisa el log.');
            }

            $data = $response->json();

            if (($data['status'] ?? null) !== 'COMPLETED') {
                return redirect()->route('carrito.mostrar')
                    ->with('error', 'El pago no fue completado. Estado: ' . ($data['status'] ?? 'sin estado'));
            }

            $userId = Auth::id();

            $items = Carrito::with('producto')
                ->where('user_id', $userId)
                ->get();

            if ($items->isEmpty()) {
                return redirect()->route('carrito.mostrar')
                    ->with('error', 'El carrito está vacío o ya fue procesado.');
            }

            $total = $items->sum(function ($item) {
                return $item->cantidad * $item->producto->precio;
            });

            $venta = $this->finalizarCompra($userId, $items, $total);

            return redirect()->route('carrito.exito', ['venta' => $venta->id])
                ->with('success', 'Pago realizado correctamente con PayPal.');
        } catch (\Throwable $e) {
            Log::error('PAYPAL EXITO ERROR: ' . $e->getMessage());

            return redirect()->route('carrito.mostrar')
                ->with('error', 'Error interno al finalizar la compra: ' . $e->getMessage());
        }
    }
    public function paypalCancelado()
    {
        return redirect('/carrito')->with('error', 'Pago cancelado por el usuario.');
    }

    private function finalizarCompra($userId, $items, $total)
    {
        // 1) Crear Venta
        $venta = Venta::create([
            'user_id' => $userId,
            'total'   => $total,
        ]);

        // 2) Crear DetalleVenta
        foreach ($items as $item) {
            DetalleVenta::create([
                'venta_id'    => $venta->id,
                'producto_id' => $item->producto_id,
                'cantidad'    => $item->cantidad,
                'precio'      => $item->producto->precio,
                'monto'       => $item->cantidad * $item->producto->precio,
            ]);
        }

        // 3) API de facturación
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

            $facturaResp = Http::post('http://192.168.1.104/public/api/invoices', $facturaPayload);

            Log::info('>>> FACTURACIÓN: Payload enviado:', $facturaPayload);
            Log::info('>>> FACTURACIÓN: Respuesta:', [
                'respuesta' => $facturaResp->json(),
                'body' => $facturaResp->body(),
            ]);

            if ($facturaResp->successful()) {
                $facturaData = $facturaResp->json();
                $codAut = $facturaData['codautorizacion'] ?? null;

                if ($codAut) {
                    $venta->cod_autorizacion = $codAut;
                    $venta->save();
                }
            } else {
                Log::error("Facturación: error HTTP {$facturaResp->status()} - " . $facturaResp->body());
            }
        } catch (\Exception $e) {
            Log::error("Excepción en facturación: " . $e->getMessage());
        }

        // 4) API de contabilidad
        try {
            $contabPayload = [
                'CodigoEmpresa' => 19,
                'Fecha'         => Carbon::now()->format('Y-m-d'),
                'Monto'         => $total,
            ];

            $contabResp = Http::post('http://192.168.1.101:50570/api/transaccion/registrar', $contabPayload);

            Log::info('>>> CONTABILIDAD: Payload enviado:', $contabPayload);
            Log::info('>>> CONTABILIDAD: Respuesta:', [
                'respuesta' => $contabResp->json(),
                'body' => $contabResp->body(),
            ]);

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

        // 5) Vaciar carrito
        Carrito::where('user_id', $userId)->delete();

        return $venta;
    }
}
