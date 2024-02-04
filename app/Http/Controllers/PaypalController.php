<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPal\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPal\Exceptions\HttpException;
use PayPalCheckoutSdk\Payments\CapturesRefundRequest;
use PayPal\Api\Refund;
use PayPal\Api\Sale;
use PayPal\Exception\PayPalConnectionException;
use Hashids\Hashids;
use App\Models\Reserva;

class PaypalController extends Controller
{
    private $client;

    public function __construct()
    {
        $paypalEnvironment = 'sandbox'; // Debes definir esto en tu archivo de configuración
        $clientId = 'AYoKresmgirjy-Btw9k5gB14TTnDd_GsM_08Loq8OB98Iidrsr946yAkL9qbR0E5WRiULl3atKM3f7Ri'; // Debes definir esto en tu archivo de configuración
        $clientSecret = 'ELBT4WCJmT83LWprK2sKxvvXrSVEqg-mAqpuSAAWejTb-Orei9Bed4HSKgJ6jAMD0SQ3bIt5SIZ77SWq'; // Debes definir esto en tu archivo de configuración

        if ($paypalEnvironment === 'sandbox') {
            $environment = new SandboxEnvironment($clientId, $clientSecret);
        } else {
            $environment = new ProductionEnvironment($clientId, $clientSecret);
        }

        $this->client = new PayPalHttpClient($environment);
    }

    public function checkout(Request $request, $horarioId)
    {
        $requestPaypal = new OrdersCreateRequest();
        $requestPaypal->prefer('return=representation');

        session([
            'datosReserva' => [
                'num_adultos' => $request->input('num_adultos'),
                'num_ninos' => $request->input('num_ninos'),
                'observaciones' => $request->input('observaciones'),
                'horario_id' => $horarioId,
            ],
        ]);

        $requestPaypal->body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'EUR',
                        'value' => $request->input('amount'),
                    ],
                ],
            ],
            'application_context' => [
                'cancel_url' => route('paypal.cancel', ['horarioId' => $horarioId]),
                'return_url' => route('paypal.success', ['horarioId' => $horarioId]),
            ],
        ];

        try {
            $response = $this->client->execute($requestPaypal);
            $orderId = $response->result->id;

            // Redirigir al usuario a la página de aprobación de PayPal
            return redirect()->away($response->result->links[1]->href);
        } catch (\HttpException $ex) {
            // Manejo de excepciones
            Log::error($ex);
            return redirect()
                ->route('reservar.show')
                ->with('error', 'Error en el proceso de pago.');
        }
    }

    public function success(Request $request, $horarioId)
    {
        $orderId = $request->input('token'); // Asegúrate de que 'token' es el nombre correcto del campo en tu respuesta de PayPal

        try {
            $requestPaypal = new OrdersCaptureRequest($orderId);
            $response = $this->client->execute($requestPaypal);

            if ($response->statusCode == 201 || $response->statusCode == 200) {
                // Suponiendo que la respuesta tiene la propiedad 'result' que contiene los detalles del pago
                $captureId = $response->result->purchase_units[0]->payments->captures[0]->id;
                // Asegúrate de que 'id' es la propiedad correcta para el ID de pago

                // Suponiendo que 'purchase_units' es un array y que el total se encuentra en la primera unidad de compra
                $paypalTotal = $response->result->purchase_units[0]->payments->captures[0]->amount->value;

                // Almacenar el ID de PayPal y el total en la sesión
                session(['paypal_capture_id' => $captureId, 'paypal_total' => $paypalTotal]);

                // Continuar con el proceso de reserva...
                $datosReserva = session('datosReserva');
                $reservaRequest = new Request($datosReserva);
                $reservaController = new ReservaController();
                return $reservaController->store($reservaRequest);
            } else {
                // Manejo de casos donde el pago no fue aprobado
                return redirect()
                    ->route('reservar.show', ['horarioId' => $horarioId])
                    ->with('error', 'El pago no se completó correctamente.');
            }
        } catch (\HttpException $ex) {
            // Manejo de excepciones
            Log::error($ex);
            return redirect()
                ->route('reservar.show', ['horarioId' => $horarioId])
                ->with('error', 'Error al procesar el pago.');
        }
    }

    public function cancel($horarioId)
    {
        // Inicializa Hashids con una sal secreta y una longitud mínima
        $this->hashids = new Hashids(env('HASHID_SALT'), 10);
        // Codifica el $horarioId que se recibe como parámetro
        $horarioIdCodificado = $this->hashids->encode($horarioId);

        // Redirige a la ruta 'reservar.show' con el $horarioId codificado
        return redirect()->route('reservar.show', ['horarioId' => $horarioIdCodificado]);
    }

    public function error()
    {
        return redirect()
            ->route('reservar.show')
            ->with('error', 'Error en el proceso de pago.');
    }

    public function refundPayment($captureId)
    {
        try {
            // Configura la solicitud de reembolso
            $request = new CapturesRefundRequest($captureId);

            // Obtén el valor del reembolso desde la base de datos
            $reserva = Reserva::where('paypal_sale_id', $captureId)->first();
            if (!$reserva) {
                return redirect()
                    ->back()
                    ->with('error', 'No se encontró la reserva correspondiente.');
            }

            $refundAmount = $reserva->total_pagado; // Aquí asumo que el campo en tu base de datos se llama 'total_pagado'

            // Define el cuerpo de la solicitud como un arreglo
            $request->body = [
                'amount' => [
                    'currency_code' => 'EUR', // La moneda en la que deseas reembolsar
                    'value' => $refundAmount, // El valor del reembolso
                ],
            ];


            // Realiza la solicitud de reembolso
            $response = $this->client->execute($request);

            // Verifica la respuesta de PayPal
            if ($response->statusCode === 201 || $response->statusCode === 200) {
                // El reembolso se ha realizado correctamente
                // Puedes realizar cualquier acción adicional aquí
                return redirect()
                    ->back()
                    ->with('success', 'Reembolso exitoso.');
            } else {
                // Manejo de casos donde el reembolso no fue exitoso
                return redirect()
                    ->back()
                    ->with('error', 'Error al procesar el reembolso.');
            }
        } catch (HttpException $ex) {
            // Manejo de excepciones
            Log::error($ex);
            return redirect()
                ->back()
                ->with('error', 'Error al procesar el reembolso.');
        }
    }
}
