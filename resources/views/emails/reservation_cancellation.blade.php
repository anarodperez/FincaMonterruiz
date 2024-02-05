<!DOCTYPE html>
<html>
<head>
    <title>Cancelación de Reserva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
        }
        h1 {
            color: #d9534f;
        }
        p {
            font-size: 16px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Reserva Cancelada</h1>
        <p>Hola {{ $reserva->usuario->nombre }},</p>
        <p>Lamentamos informarte que tu reserva para la actividad <strong>{{ $reserva->actividad->nombre }}</strong> programada para el <strong>{{ $reserva->horario->fecha }} a las {{ $reserva->horario->hora }}</strong> ha sido cancelada.</p>
        <p><strong>Motivo de la cancelación:</strong>{{ $motivoCancelacion ?? 'No especificado' }}</p>
        <p>Hemos procesado un reembolso a tu cuenta de PayPal. Por favor, verifica tu cuenta de PayPal para confirmar la devolución.</p>
        <p>Si tienes alguna consulta o deseas reprogramar tu reserva, no dudes en contactarnos.</p>
        <p class="footer">Gracias por elegirnos,<br>El equipo de {{ config('app.name') }}</p>
    </div>
</body>
</html>
