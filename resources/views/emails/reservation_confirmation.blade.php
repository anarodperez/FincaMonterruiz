<!DOCTYPE html>
<html>

<head>
    <title>Confirmación de Reserva</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #eeeeee;
            color: #333333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        h1 {
            color: white;
            font-size: 24px;
            text-align: center;
            margin-top: 0;
        }

        p strong{
            font-size: 16px;
            color: #555555;
        }


        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #999999;
        }

        .header {
            background-color: #6fa78a;
            color: white;
            padding: 10px;
            border-top-left-radius: 7px;
            border-top-right-radius: 7px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
        }


        .button {
            display: inline-block;
            background-color: #4c606d;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #6fa78a;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Confirmación de Reserva</h1>
        </div>
        <h2>Hola {{ $reserva->usuario->nombre }},</h2>
        <p>Tu reserva para la actividad <strong>{{ $reserva->actividad->nombre }}</strong> ha sido confirmada.</p>

        <h3>Detalles de la Reserva:</h3>
        <ul>
            <li><strong>Fecha:</strong> {{ $reserva->horario->fecha }}</li>
            <li><strong>Hora:</strong> {{ $reserva->horario->hora }}</li>
            <li><strong>Número de Adultos:</strong> {{ $reserva->num_adultos }}</li>
            <li><strong>Número de Niños:</strong> {{ $reserva->num_ninos }}</li>
            <li> <strong>Total Pagado:</strong> {{ $totalPagado }} €</li>

        </ul>
        <a href="{{ url('/descargar-entrada/' . $reserva->id) }}" class="button">Descargar Entrada</a>


        <p class="footer">¡Gracias por reservar con nosotros!</p>
    </div>
</body>

</html>
