<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ClienteController extends Controller
{
    public function productosNike()
    {
        $productos = DB::table('productos')
            ->where('marca', 'Nike')
            ->get();

        return view('clientes/nikecliente', compact('productos'));
    }

    public function productosAdidas()
    {
        $productos = DB::table('productos')
            ->where('marca', 'Adidas')
            ->get();

        return view('clientes/adidascliente', compact('productos'));
    }

    public function productosMarathon()
    {
        $productos = DB::table('productos')
            ->where('marca', 'Marathon')
            ->get();

        return view('clientes/marathoncliente', compact('productos'));
    }
    public function productosMarcaMarathon()
    {
        $productos = DB::table('productos')
            ->where('marca', 'MarcaMarathon')
            ->get();

        return view('clientes/marcamaracli', compact('productos'));
    }
    public function productosMarcaNike()
    {
        $productos = DB::table('productos')
            ->where('marca', 'MarcaNike')
            ->get();

        return view('clientes/marcanikecli', compact('productos'));
    }
    public function productosOtrasMarcas()
    {
        $productos = DB::table('productos')
            ->where('marca', 'Otras')
            ->get();

        return view('clientes/otrasmarcas', compact('productos'));
    }


    
    public function productosOfertas()
    {
        $productos = DB::table('productos')
            ->where('marca', 'Ofertas')
            ->get();

        return view('clientes/ofertas', compact('productos'));
    }



    public function porMarca()
    {
        // Obtener las marcas distintas
        $marcas = DB::table('productos')
            ->select('marca')
            ->distinct()
            ->orderBy('marca')
            ->get();

        // Obtener productos agrupados por marca
        $productosPorMarca = [];
        foreach ($marcas as $marca) {
            $productos = DB::table('productos')
                ->where('marca', $marca->marca)
                ->orderByDesc('id')
                ->get();

            $productosPorMarca[$marca->marca] = $productos;
        }

        return view('clientes.productos', compact('productosPorMarca'));
    }
}