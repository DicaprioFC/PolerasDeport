<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;


class PromocionController extends Controller
{


public function mostrarVista()
    {
        // IP de la PC 1 con Laravel (donde corre la API)
        $respuesta = Http::get('http://192.168.247.225:8000/api/promociones');

        $promociones = $respuesta->json(); // convierte JSON a array

        return view('ofertitas', compact('promociones'));
    }
}