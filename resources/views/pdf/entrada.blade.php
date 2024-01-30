<!DOCTYPE html>
<html>

<head>
    <title>Entrada de la Reserva</title>
    <link rel="stylesheet" type="text/css" href="css/entrada-pdf.css">
</head>

<body>
    <div class="header">
        <div class="d-flex align-items-center">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/img/logo.png'))) }}" alt="Logo Empresa" style="height: 70px; width: auto; margin-bottom: 1vh">
        </div><br>
        <h1>Entrada para {{ $reserva->actividad->nombre }}</h1>
    </div>

    <div class="info">
        <div class="info-section">
            <h3>Detalles de la Reserva</h3>
            <p class="info-detail"><strong>Fecha:</strong> {{ $reserva->horario->fecha }}</p>
            <p class="info-detail"><strong>Hora:</strong> {{ $reserva->horario->hora }}</p>
        </div>

        <div class="info-section">
            <h3>Información del Usuario</h3>
            <p class="info-detail"><strong>Nombre:</strong> {{ $reserva->usuario->nombre }}</p>
            <p class="info-detail"><strong>Apellidos:</strong> {{ $reserva->usuario->apellido1 }} {{ $reserva->usuario->apellido2 }}</p>
        </div>

        <div class="info-section">
            <h3>Detalles Adicionales</h3>
            <p class="info-detail"><strong>Número de Adultos:</strong> {{ $reserva->num_adultos }}</p>
            <p class="info-detail"><strong>Número de Niños:</strong> {{ $reserva->num_ninos }}</p>
            <p class="info-detail"><strong>Observaciones:</strong> {{ $reserva->observaciones }}</p>
            <p class="info-detail"><strong>Estado:</strong> {{ $reserva->estado }}</p>
            <p class="info-detail"><strong>Total Pagado:</strong> {{ number_format($totalPagado, 2) }} €</p>
        </div>
    </div>

    <div class="qr-code" style="text-align: center">
        <p>Escanea este código en la entrada</p>
        <img src="data:image/png;base64, {{ $qrCode }}" alt="Código QR">
    </div>
</body>

</html>
