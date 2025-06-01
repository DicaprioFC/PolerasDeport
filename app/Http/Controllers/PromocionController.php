<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Support\Facades\Http;


class PromocionController extends Controller
{

    public function vistaPublica()
{
    $ofertas = Producto::where('oferta', true)->get();

    return view('ofertitas', compact('ofertas'));
}


//public function vistaPublica()
   // {
         //IP de la PC 1 con Laravel (donde corre la API)
      // $respuesta = Http::get('http://192.168.100.35:8000/api/ofertas');

       // $ofertas = $respuesta->json(); // convierte JSON a array

      //return view('ofertitas', compact('ofertas'));
  // }

    
}
