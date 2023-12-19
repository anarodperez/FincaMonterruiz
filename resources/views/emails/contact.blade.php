<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #dddddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 1px solid #eeeeee;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
            color: #777777;
        }
        .info-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Nuevo Mensaje de Contacto</h2>
        </div>

        <p><span class="info-label">Nombre:</span> {{ $data['nombre'] }}</p>
        <p><span class="info-label">Email:</span> {{ $data['email'] }}</p>
        <p><span class="info-label">Teléfono:</span> {{ $data['telefono'] }}</p>
        <p><span class="info-label">Mensaje:</span> {{ $data['mensaje'] }}</p>

        <div class="footer">
            <p>Este mensaje ha sido enviado desde el formulario de contacto de la página web.</p>
        </div>
    </div>
</body>
</html>
