<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Exception;
use Illuminate\Support\Facades\Log;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\Sale;
use PayPal\Api\Refund;
use App\Http\Controllers\ReservaController;
use Hashids\Hashids;


class PaypalController extends Controller
{
    private $apiContext;
    private $clientId = 'AYoKresmgirjy-Btw9k5gB14TTnDd_GsM_08Loq8OB98Iidrsr946yAkL9qbR0E5WRiULl3atKM3f7Ri';
    private $clientSecret = 'ELBT4WCJmT83LWprK2sKxvvXrSVEqg-mAqpuSAAWejTb-Orei9Bed4HSKgJ6jAMD0SQ3bIt5SIZ77SWq';

    public function __construct()
    {
        $this->middleware('auth');

        $this->apiContext = new ApiContext(new OAuthTokenCredential($this->clientId, $this->clientSecret));
        $this->apiContext->setConfig([
            'mode' => 'sandbox',
            'log.LogEnabled' => true,
            'log.FileName' => storage_path('logs/paypal.log'),
            'log.LogLevel' => 'DEBUG',
            'cache.enabled' => true,
        ]);
    }

    public function checkout(Request $request, $horarioId)
    {
        $amount = new Amount();
        $redirectUrls = new RedirectUrls();
        $amount->setCurrency('EUR')->setTotal($request->input('amount'));

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setCurrency('EUR')->setTotal($request->input('amount'));

        $transaction = new Transaction();
        $transaction->setAmount($amount)->setDescription('Descripción de tu producto o servicio');

        session([
            'datosReserva' => [
                'num_adultos' => $request->input('num_adultos'),
                'num_ninos' => $request->input('num_ninos'),
                'observaciones' => $request->input('observaciones'),
                'horario_id' => $horarioId,
            ],
        ]);

        $redirectUrls->setReturnUrl(route('paypal.success', ['horarioId' => $horarioId]))->setCancelUrl(route('paypal.cancel', ['horarioId' => $horarioId]));

        $payment = new Payment();
        $payment
            ->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions([$transaction])
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);
            return redirect()->away($payment->getApprovalLink());
        } catch (PayPalConnectionException $ex) {
            // Manejo de excepciones
            Log::error($ex);
            return redirect()
                ->route('reservar.show')
                ->with('error', 'Error en el proceso de pago.');
        }
    }

    public function success(Request $request, $horarioId)
    {
        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');

        if (!$paymentId || !$payerId) {
            return redirect()
                ->route('reservar.show', ['horarioId' => $horarioId])
                ->with('error', 'El pago no se completó.');
        }

        $payment = Payment::get($paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            $result = $payment->execute($execution, $this->apiContext);

            if ($result->getState() === 'approved') {
                // Captura el ID del pago y el total del pago
                $paypalPaymentId = $result->getTransactions()[0]->getRelatedResources()[0]->getSale()->getId();
                $paypalTotal = $payment
                    ->getTransactions()[0]
                    ->getAmount()
                    ->getTotal();

                // Almacena el ID de PayPal y el total en la sesión
        session(['paypal_payment_id' => $paypalPaymentId, 'paypal_total' => $paypalTotal]);

                $datosReserva = session('datosReserva');

                // Crear un nuevo request con los datos de la reserva
                $reservaRequest = new Request($datosReserva);

                // Instanciar ReservaController y llamar al método store
                $reservaController = new ReservaController();
                return $reservaController->store($reservaRequest);
            }

            // ... manejo de casos donde el pago no es aprobado
        } catch (Exception $ex) {
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
        return redirect()->route('reservar.show');
    }

    //Devolución

    public function refundPayment($saleId)
    {
        try {
            $sale = Sale::get($saleId, $this->apiContext);

            // Crear un nuevo objeto Amount con los valores necesarios
            $amount = new \PayPal\Api\Amount();
            $amount->setTotal($sale->getAmount()->getTotal());
            $amount->setCurrency($sale->getAmount()->getCurrency());

            $refund = new Refund();
            $refund->setAmount($amount);

            $refundedSale = $sale->refund($refund, $this->apiContext);

            return $refundedSale;

        } catch (PayPalConnectionException $ex) {
            // Log y manejo de error
            $errorData = json_decode($ex->getData());
            Log::error('PayPal API Error: ' . json_encode($errorData));
            return null;
        }
    }


}
