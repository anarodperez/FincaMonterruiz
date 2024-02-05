<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Factura {{ $factura->id }}</title>
    <style>
        body .factura-pdf {
            font-family: 'Helvetica', 'Arial', sans-serif;
        }

        .factura-pdf header,
        section,
        footer {
            margin-bottom: 20px;
        }

        .factura-pdf table {
            width: 100%;
            border-collapse: collapse;
        }

        .factura-pdf table,
        th,
        td {
            border: 1px solid black;
        }

        .factura-pdf th,
        td {
            padding: 10px;
            text-align: left;
        }

        .factura-pdf th {
            background-color: #f2f2f2;
        }

        .factura-pdf .text-right {
            text-align: right;
        }
    </style>
</head>

<body class="factura-pdf">
    <!-- Encabezado de la factura -->
    <header>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Factura #{{ $factura->id }}</h1>
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/img/logo.png'))) }}"
                alt="Logo Empresa" style="height: 70px; width: auto;"><br>
        </div><br>
        <div>
            <strong>Finca Monterruiz</strong><br>
            Barriada la Polila, 123<br>
            Jerez de la Frontera, Cádiz, 11400<br>
            Teléfono: +34 123 456 789<br>
            Email: fincaMonterruiz@gmail.com
        </div>
    </header>

    <!-- Información del cliente -->
    <section>
        <div>Nombre del cliente: {{ $usuario->nombre }} {{ $usuario->apellido1 }} {{ $usuario->apellido2 }}</div>
        <div>Email: {{ $usuario->email }}</div>
        @if (!empty($usuario->telefono))
            <div>Teléfono: {{ $usuario->telefono }}</div>
        @endif

    </section>

    <!-- Detalles de la factura -->
    <section>
        <div><strong>Número de factura:</strong> {{ $factura->id }}</div>
        <div><strong>Fecha de emisión:</strong> {{ $factura->fecha_emision }}</div>
    </section>

    <!-- Detalles de la reserva -->
    <section>
        <div>Reserva ID: {{ $factura->reserva_id }}</div>
        <div>Actividad: {{ $factura->reserva->actividad->nombre }}</div>
        <div>Fecha de la actividad: {{ $fechaActividad->format('Y-m-d') }} a las {{ $horaActividad->format('H:i') }}
        </div>
    </section>
    <table>
        <thead>
            <tr>
                <th>Actividad</th>
                <th>Número adultos</th>
                <th>Número niños</th>
                <th>Precio adultos</th>
                <th>Precio niños</th>
                <th>IVA</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <tr>
                <td>{{ $factura->reserva->actividad->nombre }}</td>
                <td>{{ $factura->reserva->num_adultos }} </td>
                <td> {{ $factura->reserva->num_ninos }}</td>
                <td>{{ $factura->precio_adulto_final }}€</td>
                <td>{{ $factura->precio_nino_final }}€</td>
                <td>{{ number_format($factura->iva, 2) }}€</td>
                <td>{{ number_format($factura->monto_total, 2) }}€</td>
            </tr>
        </tbody>
    </table>

    <!-- Totales -->
    <section class="text-right">
        <div><strong>Subtotal:</strong> {{ number_format($factura->monto, 2) }}€</div>
        <div><strong>IVA:</strong> {{ number_format($factura->iva, 2) }}€</div>
        <div><strong>Total:</strong> {{ number_format($factura->monto_total, 2) }}€</div>
    </section>

    <!-- Información adicional -->
    <footer>
        <p><strong>Método de pago:</strong> Paypal</p>
        <p><strong>Términos de pago:</strong> {{ $factura->estado }}</p>
    </footer>
</body>

</html>
