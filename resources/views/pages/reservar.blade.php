@extends('layouts.guest')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/reservar.css') }}">
@endsection

@section('content')
    <div class="container mt-4">
        <div class="row">
            <!-- Columna de detalles de la reserva -->
            <div class="col-md-6">
                <h2 class="mb-4">Detalles de la reserva</h2>
                <div class="mb-3 d-flex align-items-baseline">
                    <label for="fechaReserva" style="margin-right: 10px;">Fecha de la reserva:</label>
                    <p id="fechaReserva">{{ $horario->fecha }}</p>
                </div>
                <div class="mb-3 d-flex align-items-baseline">
                    <label for="horaReserva" style="margin-right: 10px;">Hora de la reserva:</label>
                    <p id="horaReserva">{{ date('H:i', strtotime($horario->hora)) }}</p>
                </div>
                <div class="mb-3 d-flex align-items-baseline">
                    <label for="experiencia" style="margin-right: 10px;">Experiencia seleccionada:</label>
                    <p id="experiencia">{{ $horario->actividad->nombre }}</p>
                </div>
                <div class="mb-3 d-flex align-items-baseline">
                    <label for="precio" style="margin-right: 10px;">Precio por persona:</label>
                    <p id="precio">{{ $horario->actividad->precio_adulto }} €</p>
                </div>
                <div class="mb-3 d-flex align-items-baseline">
                    <label for="precio_nino" style="margin-right: 10px;">Precio niños:</label>
                    <p id="precio_nino">{{ $horario->actividad->precio_nino }} €</p>
                </div>
                <div class="mb-3 d-flex align-items-baseline">
                    <label for="total" style="margin-right: 10px;">Total:</label>
                    <p id="total">€</p>
                </div>
                <div class="mb-3 d-flex align-items-baseline">
                    <label for="idioma" style="margin-right: 10px;">IDIOMA DE LA ACTIVIDAD:</label>
                    <p id="idioma">{{ $horario->idioma }} </p>
                </div>
            </div>

            <!-- Columna para rellenar datos por el usuario -->
            <div class="col-md-6">
                <h2 class="mb-4">Completa tus datos</h2>
                <form>
                    <div class="mb-3">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" class="form-control" id="apellidos" required>
                    </div>
                    <div class="mb-3">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" class="form-control" id="telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="numAdultos">Número de Adultos:</label>
                        <input type="number" class="form-control" id="numAdultos" name="num_adultos" min="1"
                            max="10" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="numNinos">Número de Niños:</label>
                        <input type="number" class="form-control" id="numNinos" name="num_ninos" min="0" required>
                    </div>
                    <!-- Desplegable para seleccionar el país -->
                    <div class="mb-3">
                        <label for="pais">País:</label>
                        <select class="form-control" id="pais" name="pais" required>
                            <option value="">-- Seleccionar un país --</option>
                            <option value="espana">España</option>
                            <option value="francia">Francia</option>
                            <option value="alemania">Alemania</option>
                            <!-- Agrega más opciones de países aquí -->
                        </select>
                    </div>

                    <!-- Campo para el código postal -->
                    <div class="mb-3">
                        <label for="codigoPostal">Código Postal:</label>
                        <input type="text" class="form-control" id="codigoPostal" name="codigo_postal" required>
                    </div>

                    <div class="mb-3">
                        <label for="observaciones">Observaciones:</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Confirmar reserva</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #0056b3;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0069d9;
        }

        /* Añade más estilos personalizados aquí */
    </style>
@endsection
