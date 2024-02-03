<!DOCTYPE html>
<html>

<head>
    <title>Factura de la Reserva</title>
    <link rel="stylesheet" type="text/css" href="css/entrada-pdf.css">
</head>

<body>
    <div class="header">
        <div class="d-flex align-items-center">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/img/logo.png'))) }}" alt="Logo Empresa" style="height: 70px; width: auto; margin-bottom: 1vh">
        </div><br>
        <h1>Factura de la Reserva para {{ $reserva->actividad->nombre }}</h1>
    </div>

    <div class="info">
        <div class="info-section">
            <h3>Detalles del Proveedor</h3>
            <p class="info-detail"><strong>Nombre de la Empresa:</strong> Finca Monterruiz</p>
            <p class="info-detail"><strong>Dirección:</strong>  Barriada la Polila, 123 </p>
            <p class="info-detail"><strong>NIF/CIF:</strong> B12345678</p>
        </div>

        <div class="info-section">
            <h3>Información del Cliente</h3>
            <p class="info-detail"><strong>Nombre:</strong> {{ $reserva->usuario->nombre }} {{ $reserva->usuario->apellido1 }} {{ $reserva->usuario->apellido2 }}</p>
            <p class="info-detail"><strong>Email:</strong> {{ $reserva->usuario->email }}</p>

        <div class="info-section">
            <h3>Detalles de la Reserva</h3>
            <p class="info-detail"><strong>Fecha:</strong> {{ $reserva->horario->fecha }}</p>
            <p class="info-detail"><strong>Hora:</strong> {{ $reserva->horario->hora }}</p>
        </div>


        <div class="info-section">
            <h3>Detalles Adicionales</h3>
            <p class="info-detail"><strong>Número de Adultos:</strong> {{ $reserva->num_adultos }}</p>
            <p class="info-detail"><strong>Número de Niños:</strong> {{ $reserva->num_ninos }}</p>
            <p class="info-detail"><strong>Observaciones:</strong> {{ $reserva->observaciones }}</p>
            <p class="info-detail"><strong>Estado:</strong> {{ $reserva->estado }}</p>
        </div>

        <div class="info-section">
            <h3>Desglose de Pago</h3>
            <p class="info-detail"><strong>Subtotal (Sin IVA):</strong> {{ $reserva->factura->monto }} €</p>
            <p class="info-detail"><strong>IVA (21%):</strong> {{ $reserva->factura->iva }} €</p>
            <p class="info-detail"><strong>Total Pagado (Con IVA):</strong> {{ $reserva->factura->monto_total }} €</p>
        </div>
        <div class="info-section">
            <h3>Información de la Factura</h3>
            <p class="info-detail"><strong>Fecha de Emisión:</strong> {{ $reserva->factura->fecha_emision }}</p>
            <p class="info-detail"><strong>Método de Pago:</strong> PayPal </p>
        </div>
    </div>

    <div class="qr-code" style="text-align: center">
        <p>Escanea este código en la entrada</p>
        <img src="data:image/png;base64, {{ $qrCode }}" alt="Código QR">
    </div>
    <div class="footer">
        <p>Esta factura es válida sin firma y sello.</p>
    </div>
</body>

</html>
