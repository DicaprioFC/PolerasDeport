<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;   // Facade para DomPDF
use Carbon\Carbon;

class ReporteVentaController extends Controller
{
    /**
     * Muestra el formulario para filtrar por fecha.
     */
    public function index()
    {
        return view('admin.reportes');
    }

    /**
     * Recibe las fechas, consulta las ventas y genera el PDF.
     */
    public function generarPDF(Request $request)
    {
        // Validar input
        $request->validate([
            'fecha_desde' => 'required|date',
            'fecha_hasta' => 'required|date|after_or_equal:fecha_desde',
        ]);

        // Parsear fechas a Carbon (para asegurarnos que incluyan todo el día)
        $desde = Carbon::parse($request->input('fecha_desde'))->startOfDay();
        $hasta = Carbon::parse($request->input('fecha_hasta'))->endOfDay();

        // Consultar las ventas en ese rango, con su detalle y producto
        $ventas = Venta::with(['detalles.producto']) // "detalles", no "detalleVentas"
            ->whereBetween('created_at', [$desde, $hasta])
            ->orderBy('created_at', 'asc')
            ->get();


        // Calcular totales generales (opcional)
        $totalGeneral = $ventas->sum('total');

        // Datos adicionales para mostrar en el PDF
        $data = [
            'ventas'       => $ventas,
            'totalGeneral' => $totalGeneral,
            'fechaDesde'   => $desde->format('d/m/Y'),
            'fechaHasta'   => $hasta->format('d/m/Y'),
        ];

        // Cargar la vista 'admin.reportes.pdf' con los datos
        $pdf = Pdf::loadView('admin.pdf', $data)
            ->setPaper('a4', 'portrait');

        // Descargar el PDF con nombre personalizado
        $filename = 'reporte_ventas_' . $desde->format('Ymd') . '_a_' . $hasta->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }

    public function previsualizar(Request $request)
    {
        $request->validate([
            'fecha_desde' => 'required|date',
            'fecha_hasta' => 'required|date|after_or_equal:fecha_desde',
        ]);

        $desde = Carbon::parse($request->fecha_desde)->startOfDay();
        $hasta = Carbon::parse($request->fecha_hasta)->endOfDay();

        $ventas = Venta::with('detalles.producto')
            ->whereBetween('created_at', [$desde, $hasta])
            ->orderBy('created_at', 'asc')
            ->get(['id', 'created_at', 'total']);

        return response()->json(['ventas' => $ventas]);
    }
}
