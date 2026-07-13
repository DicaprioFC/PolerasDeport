<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // al inicio del archivo si no está
use Illuminate\Support\Facades\DB;
use App\Models\Producto;
use Cloudinary\Cloudinary;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    private function subirImagenCloudinary($imagen): array
    {
        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
            'url' => [
                'secure' => true,
            ],
        ]);

        $resultado = $cloudinary->uploadApi()->upload(
            $imagen->getRealPath(),
            [
                'folder' => 'polerasdepor/productos',
            ]
        );

        return [
            'url' => $resultado['secure_url'],
            'public_id' => $resultado['public_id'],
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'marca'  => 'required|string',
            'otraMarca' => 'nullable|string|max:255',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $marca = $request->input('marca') === 'otras'
            ? $request->input('otraMarca')
            : $request->input('marca');

        if (!$request->hasFile('imagen')) {
            return back()->with('error', '❌ Error al subir la imagen.');
        }

        try {
            // Subir imagen a Cloudinary
            $imagenCloudinary = $this->subirImagenCloudinary($request->file('imagen'));

            $rutaImagen = $imagenCloudinary['url'];
            $imagenPublicId = $imagenCloudinary['public_id'];

            DB::table('productos')->insert([
                'nombre' => $request->nombre,
                'precio' => $request->precio,
                'marca' => $marca,
                'imagen' => $rutaImagen,
                'imagen_public_id' => $imagenPublicId,
                'id_usuario' => Auth::id(),
            ]);

            return redirect()
                ->route('admin.dashboard')
                ->with('success', '✅ Producto agregado exitosamente con imagen en Cloudinary.');
        } catch (\Throwable $e) {
            return back()->with('error', '❌ Error al subir la imagen a Cloudinary: ' . $e->getMessage());
        }
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
