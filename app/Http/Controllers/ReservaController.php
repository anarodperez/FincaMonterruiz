<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\Horario;
use App\Models\Factura;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationConfirmationMail;
use App\Mail\ReservationCancellationMail;
use Illuminate\Support\Facades\DB;
use Hashids\Hashids;
use App\Models\AdminNotification;

class ReservaController extends Controller
{
    private $hashids;

    public function __construct()
    {
        // Inicializa Hashids con una sal secreta y una longitud mínima
        $this->hashids = new Hashids(env('HASHID_SALT'), 10);
    }

    public function index()
    {
        // Resetear el contador de nuevas reservas
        $notification = AdminNotification::first();
        if ($notification && $notification->nuevos_reservas_count > 0) {
            $notification->update(['nuevos_reservas_count' => 0]);
        }

        $reservas = Reserva::with(['usuario', 'actividad', 'horario'])
            ->join('horarios', 'reservas.horario_id', '=', 'horarios.id')
            ->orderBy('horarios.fecha', 'desc') // Ordena por la fecha del horario
            ->select('reservas.*')
            ->paginate(10);

        // Obtener la lista de actividades disponibles
        $actividadesDisponibles = Actividad::all();

        // Obtener la lista de horarios disponibles
        $horariosDisponibles = Horario::all();

        // Obtener datos de reservas
        $datosReservas = Reserva::select(DB::raw("to_char(created_at, 'YYYY-MM-DD') as fecha"), DB::raw('count(*) as total'))
            ->groupBy('fecha')
            ->orderBy('fecha', 'asc')
            ->get();

        return view('admin.reservas.index', compact('reservas', 'actividadesDisponibles', 'horariosDisponibles', 'datosReservas'));
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
            'num_ninos' => 'nullable|integer|min:0', // Cambiar a nullable
            'observaciones' => 'nullable|string',
            'horario_id' => 'required|exists:horarios,id',
        ]);

        // Obtener el horario y la actividad relacionada
        $horario = Horario::with('actividad')->findOrFail($validated['horario_id']);
        $actividad = $horario->actividad;

        // Calcular el número total de personas para la reserva
        $numPersonas = $validated['num_adultos'] + ($validated['num_ninos'] ?? 0); // Usar ?? para establecer un valor predeterminado de 0 si num_ninos está vacío

        // Calcular plazas ya reservadas para esta actividad
        $plazasReservadas = Reserva::where('actividad_id', $horario->actividad->id)
            ->where('estado', 'confirmado')
            ->sum(DB::raw('num_adultos + num_ninos'));
        $aforoDisponible = $horario->actividad->aforo - $plazasReservadas;

        // Verificar si hay suficiente aforo disponible
        if ($actividad->aforo - $plazasReservadas < $numPersonas) {
            return back()->withErrors(['aforo_error' => 'No hay suficiente aforo disponible para esta reserva.']);
        }

        // Obtener el ID de PayPal y el total del pago de la sesión
        $paypalPaymentId = session('paypal_payment_id', null);
        $paypalTotal = session('paypal_total', null);

        // Crear la reserva
        $reserva = new Reserva();
        $reserva->num_adultos = $validated['num_adultos'];
        $reserva->num_ninos = $validated['num_ninos'] ?? 0; // Usar ?? para establecer un valor predeterminado de 0 si num_ninos está vacío
        $reserva->horario_id = $validated['horario_id'];
        $reserva->user_id = Auth::id();
        $reserva->actividad_id = $actividad->id;
        $reserva->observaciones = $validated['observaciones'] ?? null;
        $reserva->paypal_sale_id = $paypalPaymentId;
        $reserva->total_pagado = $paypalTotal;

        // Guardar la reserva
        $reserva->save();

        // Actualizar contador de nuevas reservas
        $notification = AdminNotification::first();
        if ($notification) {
            $notification->increment('nuevos_reservas_count');
        } else {
            AdminNotification::create(['nuevos_reservas_count' => 1]);
        }

        //Intenta procesar el pago
        // Enviar correo electrónico de confirmación
        try {
            $precioPorAdulto = $reserva->actividad->precio_adulto;
            $precioPorNino = $reserva->actividad->precio_nino;

            $totalPagado = $reserva->num_adultos * $precioPorAdulto + $reserva->num_ninos * $precioPorNino;

            // Definir la dirección de email del administrador
            $adminEmail = 'anarodpe8@gmail.com';

            // Enviar correo electrónico de confirmación
            Mail::to(Auth::user()->email)
                ->cc($adminEmail)
                ->send(new ReservationConfirmationMail($reserva, $totalPagado));
        } catch (Exception $e) {
            // Manejo de la excepción, por ejemplo, loguear el error
            // Log::error('Error al enviar correo de confirmación: '.$e->getMessage());
            // Opcionalmente, puedes redirigir al usuario con un mensaje de error
        }

        // Calcular el total pagado
        $precioPorAdulto = $actividad->precio_adulto;
        $precioPorNino = $actividad->precio_nino;
        $totalPagado = $validated['num_adultos'] * $precioPorAdulto + ($validated['num_ninos'] ?? 0) * $precioPorNino;

        // Crear la factura asociada a la reserva
        $factura = new Factura([
            'reserva_id' => $reserva->id,
            'monto' => $totalPagado,
            'estado' => 'emitida', // O cualquier estado inicial que desees
            'fecha_emision' => now(), // Fecha actual
            // Puedes agregar más campos si es necesario, como detalles de la factura
        ]);

        // Guardar la factura
        $factura->save();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Reserva realizada con éxito');
    }

    public function show($hashid)
    {
        $decodedArray = $this->hashids->decode($hashid);

        if (empty($decodedArray)) {
            // Maneja el caso donde la decodificación falla (por ejemplo, redirigir o mostrar un error)
            abort(404, 'Horario no encontrado.');
        }

        $realId = $decodedArray[0];

        $horario = Horario::findOrFail($realId);
        $actividad = Actividad::where('id', $horario->actividad_id)->firstOrFail();
        $usuario = auth()->user();

        // Sumar las plazas reservadas para esta actividad
        $plazasReservadas = Reserva::where('actividad_id', $actividad->id)
            ->where('estado', 'confirmado')
            ->sum(DB::raw('num_adultos + num_ninos'));

        // Calcular las plazas disponibles
        $aforoDisponible = max(0, $horario->actividad->aforo - $plazasReservadas);

        // Codifica el ID del horario antes de enviarlo a la vista
        $horarioHashid = $this->hashids->encode($horario->id);

        return view('pages.reservar', compact('actividad', 'horario', 'usuario', 'aforoDisponible'));
    }

    public function cancelar($id)
    {
        $reserva = Reserva::with('actividad')->findOrFail($id);

        // Verificar si la reserva ya está cancelada
        if ($reserva->estado === 'cancelada') {
            return back()->with('error', 'La reserva ya estaba cancelada.');
        }

        $paypalSaleId = $reserva->paypal_sale_id;

        if ($paypalSaleId) {
            try {
                $paypalController = new PaypalController();
                $refund = $paypalController->refundPayment($paypalSaleId);
            } catch (Exception $e) {
                Log::error('Error al procesar la devolución en PayPal: ' . $e->getMessage());
            }
        }

        // Iniciar transacción de base de datos para asegurar la atomicidad de la operación
        DB::beginTransaction();
        try {
            // Cambiar el estado de la reserva a 'cancelada'
            $reserva->estado = 'cancelada';
            $reserva->save();

            // Actualizar el estado de la factura correspondiente y registrar la fecha de cancelación
            $factura = Factura::where('reserva_id', $id)->first();
            if ($factura) {
                $factura->estado = 'cancelada';
                $factura->fecha_cancelacion = now(); // Usar Carbon para obtener la fecha y hora actual
                $factura->save();
            }

            // Definir la dirección de email del administrador
            $adminEmail = 'anarodpe8@gmail.com';

            // Enviar correo de cancelación
            Mail::to($reserva->usuario->email)
                ->cc($adminEmail)
                ->send(new ReservationCancellationMail($reserva));

            // Confirmar las operaciones de la base de datos
            DB::commit();

            return back()->with('success', 'Reserva cancelada correctamente y reembolso procesado correctamente.');
        } catch (\Exception $e) {
            // En caso de error, revertir todas las operaciones de base de datos
            DB::rollback();
            Log::error('Error al cancelar la reserva: ' . $e->getMessage());
            return back()->with('error', 'Hubo un problema al cancelar la reserva.');
        }
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
        // Obtiene la reserva con usuario, actividad, horario y factura asociados
        $reserva = Reserva::with(['usuario', 'actividad', 'horario', 'factura'])->findOrFail($reserva_id);

        if (!$reserva) {
            // Manejar el error, por ejemplo, redirigir con un mensaje
            return redirect()
                ->back()
                ->with('error', 'Reserva no encontrada.');
        }

        // Asume que la relación en Reserva se llama 'factura' y obtiene el monto
        $totalPagado = $reserva->factura->monto;

        // Usa el token de la reserva en lugar del ID en el contenido del QR
        $contenidoQR = 'https://tu-sitio-web.com/validar-reserva/';
        $qrCode = base64_encode(
            QrCode::format('png')
                ->size(200)
                ->generate($contenidoQR),
        );

        $pdf = PDF::loadView('pdf.entrada', compact('reserva', 'qrCode', 'totalPagado'));
        return $pdf->download('entrada-reserva.pdf');
    }

    public function cancelarEnLote(Request $request)
    {
        $reservaIds = json_decode($request->input('reservas'));

        // Validar que los IDs de reserva existen
        $reservas = Reserva::whereIn('id', $reservaIds)->get();

        $paypalController = new PaypalController();

        foreach ($reservas as $reserva) {
            if ($reserva->estado !== 'cancelada') {
                $paypalSaleId = $reserva->paypal_sale_id;

                if ($paypalSaleId) {
                    $refund = $paypalController->refundPayment($paypalSaleId);

                    if (!$refund) {
                        // Decidir cómo manejar los reembolsos fallidos (continuar, detener, registrar, etc.)
                    }
                }

                $reserva->estado = 'cancelada';
                $reserva->save();

                // Definir la dirección de email del administrador
                $adminEmail = 'anarodpe8@gmail.com';

                // Enviar correo de cancelación
                try {
                    Mail::to($reserva->usuario->email)
                        ->cc($adminEmail)
                        ->send(new ReservationCancellationMail($reserva));
                } catch (Exception $e) {
                    // Manejo de excepciones si algo va mal con el envío del correo
                    // Log::error('Error al enviar correo de cancelación: ' . $e->getMessage());
                }
            }
        }

        return back()->with('success', 'Reservas canceladas correctamente.');
    }
}
