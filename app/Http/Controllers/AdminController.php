<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // al inicio del archivo si no está
use Illuminate\Support\Facades\DB;
use App\Models\Producto;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'marca' => 'required|string',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $marca = $request->input('marca') === 'otras' ? $request->input('otraMarca') : $request->input('marca');

        // Similar a PHP: mueve imagen manualmente a /public/imagenes/
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('imagenes'); // esto apunta a /public/imagenes
            $file->move($destinationPath, $fileName);
            $rutaImagen = 'imagenes/' . $fileName;
        } else {
            return back()->with('error', '❌ Error al subir la imagen.');
        }

        DB::table('productos')->insert([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'marca' => $marca,
            'imagen' => $rutaImagen,
            'id_usuario' => Auth::id(),
        ]);

        return redirect()->route('admin.dashboard')->with('success', '✅ Producto agregado exitosamente.');
    }


    public function formOferta()
    {
        return view('admin.oferta');
    }

    public function storeOferta(Request $request)
    {
        $request->validate([
            'nombre'         => 'required|string|max:255',
            'descripcion'    => 'nullable|string|max:1000',
            'precio'         => 'required|numeric|min:0',
            'marca'          => 'required|string|max:255',
            'descuento'      => 'required|numeric|min:0|max:100',
            'imagen_url'     => 'required|url',
        ]);

        // Usamos solo la URL de imagen
        $rutaImagen = $request->imagen_url;

        Producto::create([
            'nombre'       => $request->nombre,
            'precio'       => $request->precio,
            'marca'        => $request->marca,
            'imagen'       => $rutaImagen,
            'oferta'       => true,
            'descuento'    => $request->descuento,
            'descripcion'  => $request->descripcion,
            'id_usuario'   => Auth::id(),
        ]);

        return redirect()
            ->route('admin.oferta')
            ->with('success', 'Producto en oferta guardado correctamente.');
    }
}
