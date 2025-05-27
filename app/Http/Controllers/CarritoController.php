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
        $items = Carrito::with('producto')->where('user_id', $userId)->get();

        if ($items->isEmpty()) {
            return redirect()->back()->with('error', 'El carrito está vacío.');
        }

        $total = 0;
        foreach ($items as $item) {
            $total += $item->cantidad * $item->producto->precio;
        }

        
        // Crear venta
        $venta = Venta::create([
            'user_id' => $userId,
            'total' => $total,
        ]);

        // Crear detalles de venta
        foreach ($items as $item) {
            DetalleVenta::create([
                'venta_id' => $venta->id,
                'producto_id' => $item->producto_id,
                'cantidad' => $item->cantidad,
                'precio' => $item->producto->precio,
            ]);
        }

        // Vaciar carrito
        Carrito::where('user_id', $userId)->delete();

        return view('carrito.exito', [
            'venta' => $venta,
            'detalles' => $venta->detalles,
        ]);
    }
    public function factura($id)
    {
        $venta = Venta::with('detalles.producto')->findOrFail($id);

        $pdf = Pdf::loadView('carrito.factura', ['venta' => $venta]);

        return $pdf->download('factura-compra.pdf');
    }
}
