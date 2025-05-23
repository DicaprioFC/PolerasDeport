<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/api/poleras', function (Request $request) {
    $marca = $request->query('marca');

    $query = DB::table('productos')
        ->join('users', 'productos.id_usuario', '=', 'users.id')
        ->select(
            'productos.id',
            'productos.nombre',
            'productos.precio',
            'productos.marca',
            'productos.imagen',
            'users.name as nombre_admin'
        );
    if ($marca) {
        $query->where('productos.marca', $marca);
    }

    $poleras = $query->orderByDesc('productos.id')->get();

    return response()->json([
        'marca_filtrada' => $marca ?? 'todas',
        'total_poleras' => $poleras->count(),
        'poleras' => $poleras
    ]);
});
