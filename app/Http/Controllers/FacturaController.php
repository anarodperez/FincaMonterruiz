<?php

namespace App\Http\Controllers;
use App\Models\Factura;
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;


class FacturaController extends Controller
{
    public function facturas(Request $request)
{
    $query = Factura::query();

    if ($request->filled('factura_id')) {
        $query->where('id', $request->factura_id);
    }
    if ($request->filled('reserva_id')) {
        $query->where('reserva_id', $request->reserva_id);
    }

    $facturas = $query->get();

    return view('admin.facturas.index', compact('facturas'));
}

public function generatePdf($facturaId)
{
    $factura = Factura::with(['reserva.actividad', 'reserva.usuario'])->findOrFail($facturaId);

    $fechaActividad = Carbon::parse($factura->reserva->horario->fecha);
    $horaActividad = Carbon::parse($factura->reserva->horario->hora);

    $reserva = $factura->reserva;
    $usuario = $reserva->usuario;
    $actividad = $reserva->actividad;

    $pdf = PDF::loadView('admin.facturas.pdf', compact('factura', 'reserva', 'usuario', 'actividad','fechaActividad','horaActividad'));

    // Descargar el PDF con un nombre de archivo
    return $pdf->download("factura-{$facturaId}.pdf");
}


}
