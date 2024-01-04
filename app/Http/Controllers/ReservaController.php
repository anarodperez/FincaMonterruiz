<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\Horario;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReservaController extends Controller
{
    public function index()
    {
        $reservas = Reserva::with(['usuario', 'actividad', 'horario'])->paginate(3);

        return view('admin.reservas.index', compact('reservas'));
    }

    public function create(Request $request, $horarioId)
    {
        // Método para mostrar el formulario de creación de una reserva
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'num_adultos' => 'required|integer|min:0',
            'num_ninos' => 'required|integer|min:0',
            'observaciones' => 'nullable|string',
            'horario_id' => 'required|exists:horarios,id',
        ]);

        // Obtener el horario y la actividad relacionada
        $horario = Horario::with('actividad')->findOrFail($validated['horario_id']);
        $actividad = $horario->actividad;

        // Calcular el número total de personas para la reserva
        $numPersonas = $validated['num_adultos'] + $validated['num_ninos'];

        // Verificar si hay suficiente aforo disponible
        if ($actividad->aforo < $numPersonas) {
            return back()->withErrors(['error' => 'No hay suficiente aforo disponible para esta reserva.']);
        }

        // Crear la reserva
        $reserva = new Reserva();
        $reserva->num_adultos = $validated['num_adultos'];
        $reserva->num_ninos = $validated['num_ninos'];
        $reserva->horario_id = $validated['horario_id'];
        $reserva->user_id = Auth::id();
        $reserva->actividad_id = $actividad->id;
        $reserva->observaciones = $validated['observaciones'] ?? null;

        // Guardar la reserva
        $reserva->save();

        // Actualizar el aforo de la actividad
        $actividad->aforo -= $numPersonas;
        $actividad->save();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Reserva realizada con éxito');
    }

    public function show($horarioId)
    {
        $horario = Horario::findOrFail($horarioId);
        $actividad = Actividad::where('id', $horario->actividad_id)->firstOrFail();
        $usuario = auth()->user();

        return view('pages.reservar', compact('actividad', 'horario', 'usuario'));
    }

    public function cancelar($id)
    {
        $reserva = Reserva::with('actividad')->findOrFail($id);

        // Verificar si la reserva ya está cancelada
        if ($reserva->estado !== 'cancelada') {
            $actividad = $reserva->actividad;

            // Aumentar el aforo de la actividad
            $actividad->aforo += $reserva->num_adultos + $reserva->num_ninos;
            $actividad->save();

            // Cambiar el estado de la reserva a 'cancelada'
            $reserva->estado = 'cancelada';
            $reserva->save();

            return back()->with('success', 'Reserva cancelada correctamente.');
        }

        // Manejar el caso en que la reserva ya esté cancelada
        return back()->with('error', 'La reserva ya estaba cancelada.');
    }

    public function edit(Reserva $reserva)
    {
        // Método para mostrar el formulario de edición de una reserva
    }

    public function update(Request $request, Reserva $reserva)
    {
        // Método para actualizar una reserva específica
    }

    public function destroy(Reserva $reserva)
    {
        // Método para borrar una reserva específica
    }

    //Descarga pdf

    public function descargarEntrada($reserva_id)
    {
        $reserva = Reserva::with(['usuario', 'actividad', 'horario'])->findOrFail($reserva_id);

        $precioPorAdulto = $reserva->actividad->precio_adulto; // Asegúrate de que estos campos existan en tu modelo 'Actividad'
        $precioPorNino = $reserva->actividad->precio_nino;

        $totalPagado = $reserva->num_adultos * $precioPorAdulto + $reserva->num_ninos * $precioPorNino;

        if (!$reserva) {
            // Manejar el error, por ejemplo, redirigir con un mensaje
            return redirect()
                ->back()
                ->with('error', 'Reserva no encontrada.');
        }

        // Usa el token de la reserva en lugar del ID en el contenido del QR
        $contenidoQR = 'https://tu-sitio-web.com/validar-reserva/' . $reserva->token;
        $qrCode = base64_encode(
            QrCode::format('png')
                ->size(200)
                ->generate($contenidoQR),
        );

        $pdf = PDF::loadView('pdf.entrada', compact('reserva', 'qrCode', 'totalPagado'));
        return $pdf->download('entrada-reserva.pdf');
    }
}
