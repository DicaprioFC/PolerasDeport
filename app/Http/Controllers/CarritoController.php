<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class CarritoController extends Controller
{
    public function agregar(int $id)
    {
        $producto = Producto::findOrFail($id);
        $userId = (int) Auth::id();

        if ((int) $producto->stock <= 0) {
            return redirect()->back()
                ->with('error', 'El producto no tiene stock disponible.');
        }

        $carrito = Carrito::where('user_id', $userId)
            ->where('producto_id', $id)
            ->first();

        $cantidadActual = $carrito ? (int) $carrito->cantidad : 0;

        if ($cantidadActual >= (int) $producto->stock) {
            return redirect()->back()
                ->with('error', 'No puedes agregar una cantidad mayor al stock disponible.');
        }

        if ($carrito) {
            $carrito->increment('cantidad');
        } else {
            Carrito::create([
                'user_id' => $userId,
                'producto_id' => $id,
                'cantidad' => 1,
            ]);
        }

        return redirect()->back()
            ->with('success', 'Producto agregado al carrito.');
    }

    public function mostrar()
    {
        $resumen = $this->resumenCarrito((int) Auth::id());

        return view('carrito.index', [
            'items' => $resumen['items'],
            'total' => $resumen['total'],
        ]);
    }

    public function eliminar(int $id)
    {
        $eliminados = Carrito::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        if ($eliminados === 0) {
            return redirect()->back()
                ->with('error', 'El producto no pertenece a tu carrito.');
        }

        return redirect()->back()
            ->with('success', 'Producto eliminado del carrito.');
    }
    public function pagarConPaypal()
    {
        $userId = (int) Auth::id();

        try {
            $resumen = $this->resumenCarrito($userId);
            $items = $resumen['items'];
            $totalBs = $resumen['total'];

            if ($items->isEmpty()) {
                return redirect()->route('carrito.mostrar')
                    ->with('error', 'El carrito está vacío.');
            }

            $this->validarStock($items);

            $tasaCambio = (float) config('services.paypal.bob_rate', 6.96);

            if ($tasaCambio <= 0) {
                throw new RuntimeException('La tasa de cambio configurada no es válida.');
            }

            $totalUsd = round($totalBs / $tasaCambio, 2);
            $currency = (string) config('services.paypal.currency', 'USD');
            $baseUrl = (string) config('services.paypal.base_url');
            $accessToken = $this->obtenerTokenPaypal();

            $response = Http::withToken($accessToken)
                ->post($baseUrl . '/v2/checkout/orders', [
                    'intent' => 'CAPTURE',
                    'purchase_units' => [
                        [
                            'description' => 'Compra en LF-Store',
                            'amount' => [
                                'currency_code' => $currency,
                                'value' => number_format($totalUsd, 2, '.', ''),
                            ],
                        ],
                    ],
                    'application_context' => [
                        'brand_name' => 'LF-Store',
                        'user_action' => 'PAY_NOW',
                        'return_url' => route('paypal.exito'),
                        'cancel_url' => route('paypal.cancelado'),
                    ],
                ]);

            if (!$response->successful()) {
                Log::error('PAYPAL CREATE ORDER ERROR', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return redirect()->route('carrito.mostrar')
                    ->with('error', 'No se pudo crear la orden de pago.');
            }

            $orden = $response->json();
            $orderId = $orden['id'] ?? null;

            if (!$orderId) {
                return redirect()->route('carrito.mostrar')
                    ->with('error', 'PayPal no devolvió un identificador de orden.');
            }

            session([
                'paypal_order_id' => $orderId,
                'paypal_user_id' => $userId,
                'paypal_total_bs' => $totalBs,
                'paypal_total_usd' => $totalUsd,
                'paypal_currency' => $currency,
            ]);

            foreach ($orden['links'] ?? [] as $link) {
                if (($link['rel'] ?? null) === 'approve') {
                    return redirect()->away($link['href']);
                }
            }

            return redirect()->route('carrito.mostrar')
                ->with('error', 'No se encontró el enlace de aprobación de PayPal.');
        } catch (\Throwable $e) {
            Log::error('PAYPAL CREATE ORDER EXCEPTION', [
                'user_id' => $userId,
                'message' => $e->getMessage(),
            ]);

            return redirect()->route('carrito.mostrar')
                ->with('error', $e->getMessage());
        }
    }

    public function paypalExito(Request $request)
    {
        $orderId = (string) $request->query('token');
        $sessionOrderId = (string) session('paypal_order_id');
        $sessionUserId = (int) session('paypal_user_id');
        $userId = (int) Auth::id();

        if ($orderId === '') {
            return redirect()->route('carrito.mostrar')
                ->with('error', 'No se recibió el identificador de la orden de PayPal.');
        }

        if ($sessionOrderId === '' || !hash_equals($sessionOrderId, $orderId)) {
            return redirect()->route('carrito.mostrar')
                ->with('error', 'La orden recibida no corresponde al pago iniciado.');
        }

        if ($sessionUserId !== $userId) {
            abort(403, 'La orden de PayPal no pertenece al usuario autenticado.');
        }

        try {
            $resumen = $this->resumenCarrito($userId);

            if ($resumen['items']->isEmpty()) {
                return redirect()->route('carrito.mostrar')
                    ->with('error', 'El carrito está vacío o ya fue procesado.');
            }

            $totalEsperadoBs = (float) session('paypal_total_bs');

            if (abs($resumen['total'] - $totalEsperadoBs) > 0.01) {
                return redirect()->route('carrito.mostrar')
                    ->with('error', 'El total del carrito cambió. Debes iniciar nuevamente el pago.');
            }

            $this->validarStock($resumen['items']);

            $baseUrl = (string) config('services.paypal.base_url');
            $accessToken = $this->obtenerTokenPaypal();

            $response = Http::withToken($accessToken)
                ->acceptJson()
                ->withBody('{}', 'application/json')
                ->post($baseUrl . "/v2/checkout/orders/{$orderId}/capture");

            Log::info('PAYPAL CAPTURE RESPONSE', [
                'order_id' => $orderId,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            if (!$response->successful()) {
                return redirect()->route('carrito.mostrar')
                    ->with('error', 'PayPal no pudo confirmar el pago.');
            }

            $data = $response->json();

            if (($data['status'] ?? null) !== 'COMPLETED') {
                return redirect()->route('carrito.mostrar')
                    ->with(
                        'error',
                        'El pago no fue completado. Estado: ' . ($data['status'] ?? 'sin estado')
                    );
            }

            $capturedValue = (float) data_get(
                $data,
                'purchase_units.0.payments.captures.0.amount.value',
                0
            );
            $capturedCurrency = (string) data_get(
                $data,
                'purchase_units.0.payments.captures.0.amount.currency_code',
                ''
            );

            $expectedUsd = (float) session('paypal_total_usd');
            $expectedCurrency = (string) session('paypal_currency');

            if (
                abs($capturedValue - $expectedUsd) > 0.01 ||
                $capturedCurrency !== $expectedCurrency
            ) {
                Log::critical('PAYPAL CAPTURE AMOUNT MISMATCH', [
                    'order_id' => $orderId,
                    'expected_value' => $expectedUsd,
                    'captured_value' => $capturedValue,
                    'expected_currency' => $expectedCurrency,
                    'captured_currency' => $capturedCurrency,
                ]);

                return redirect()->route('carrito.mostrar')
                    ->with('error', 'El monto confirmado por PayPal no coincide con la compra.');
            }

            $venta = $this->finalizarCompra(
                $userId,
                $resumen['items'],
                $totalEsperadoBs
            );

            $this->limpiarSesionPaypal();

            return redirect()->route('carrito.exito', ['venta' => $venta->id])
                ->with('success', 'Pago realizado correctamente con PayPal.');
        } catch (\Throwable $e) {
            Log::error('PAYPAL CHECKOUT ERROR', [
                'order_id' => $orderId,
                'user_id' => $userId,
                'message' => $e->getMessage(),
            ]);

            return redirect()->route('carrito.mostrar')
                ->with('error', 'No se pudo finalizar la compra: ' . $e->getMessage());
        }
    }

    public function paypalCancelado()
    {
        $this->limpiarSesionPaypal();

        return redirect()->route('carrito.mostrar')
            ->with('error', 'Pago cancelado. El carrito se mantiene disponible.');
    }

    public function factura(Venta $venta)
    {
        $this->autorizarVenta($venta);
        $venta->load('detalles.producto');

        $pdf = Pdf::loadView('carrito.factura', [
            'venta' => $venta,
        ]);

        return $pdf->download('factura-compra-' . $venta->id . '.pdf');
    }

    private function resumenCarrito(int $userId): array
    {
        $items = Carrito::with('producto')
            ->where('user_id', $userId)
            ->get();

        $total = (float) $items->sum(function ($item) {
            if (!$item->producto) {
                throw new RuntimeException(
                    "El producto {$item->producto_id} ya no se encuentra disponible."
                );
            }

            return (int) $item->cantidad * (float) $item->producto->precio;
        });

        return compact('items', 'total');
    }

    private function validarStock($items): void
    {
        foreach ($items as $item) {
            if (!$item->producto) {
                throw new RuntimeException(
                    "El producto {$item->producto_id} ya no existe."
                );
            }

            if ((int) $item->cantidad <= 0) {
                throw new RuntimeException('La cantidad de un producto no es válida.');
            }

            if ((int) $item->cantidad > (int) $item->producto->stock) {
                throw new RuntimeException(
                    "No existe stock suficiente para {$item->producto->nombre}."
                );
            }
        }
    }

    private function obtenerTokenPaypal(): string
    {
        $baseUrl = (string) config('services.paypal.base_url');

        $response = Http::asForm()
            ->withBasicAuth(
                (string) config('services.paypal.client_id'),
                (string) config('services.paypal.client_secret')
            )
            ->post($baseUrl . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        if (!$response->successful()) {
            Log::error('PAYPAL TOKEN ERROR', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new RuntimeException('No se pudo obtener el token de PayPal.');
        }

        $token = $response->json('access_token');

        if (!$token) {
            throw new RuntimeException('PayPal no devolvió un token de acceso.');
        }

        return (string) $token;
    }

    private function finalizarCompra(int $userId, $items, float $totalEsperado): Venta
    {
        return DB::transaction(function () use ($userId, $items, $totalEsperado) {
            $detalles = [];
            $totalCalculado = 0.0;

            foreach ($items as $item) {
                $producto = Producto::whereKey($item->producto_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $cantidad = (int) $item->cantidad;

                if ($cantidad <= 0) {
                    throw new RuntimeException('La cantidad de un producto no es válida.');
                }

                if ((int) $producto->stock < $cantidad) {
                    throw new RuntimeException(
                        "No existe stock suficiente para {$producto->nombre}."
                    );
                }

                $precio = (float) $producto->precio;
                $subtotal = $cantidad * $precio;
                $totalCalculado += $subtotal;

                $detalles[] = [
                    'producto' => $producto,
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'precio' => $precio,
                    'monto' => $subtotal,
                ];
            }

            if (abs($totalCalculado - $totalEsperado) > 0.01) {
                throw new RuntimeException(
                    'El total actual de la compra no coincide con el monto pagado.'
                );
            }

            $venta = Venta::create([
                'user_id' => $userId,
                'total' => $totalCalculado,
            ]);

            foreach ($detalles as $detalle) {
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $detalle['producto_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio' => $detalle['precio'],
                    'monto' => $detalle['monto'],
                ]);

                $detalle['producto']->decrement('stock', $detalle['cantidad']);
            }

            Carrito::where('user_id', $userId)->delete();

            return $venta;
        }, 3);
    }

    private function autorizarVenta(Venta $venta): void
    {
        $userId = (int) Auth::id();
        $esAdministrador = $userId === 1;
        $esPropietario = (int) $venta->user_id === $userId;

        if (!$esAdministrador && !$esPropietario) {
            abort(403, 'No tienes permiso para consultar esta venta.');
        }
    }

    private function limpiarSesionPaypal(): void
    {
        session()->forget([
            'paypal_order_id',
            'paypal_user_id',
            'paypal_total_bs',
            'paypal_total_usd',
            'paypal_currency',
        ]);
    }
    public function exito(Venta $venta)
    {
        $this->autorizarVenta($venta);
        $venta->load('detalles.producto');

        return view('carrito.exito', [
            'venta' => $venta,
            'detalles' => $venta->detalles,
        ]);
    }
}