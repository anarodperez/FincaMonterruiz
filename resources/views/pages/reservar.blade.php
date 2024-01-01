@extends('layouts.guest')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/reservar.css') }}">
@endsection

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

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
                <!-- Precio por adulto -->
                @if (!is_null($horario->actividad->precio_adulto))
                    <div class="mb-3 d-flex align-items-baseline">
                        <label for="precio" style="margin-right: 10px;">Precio por persona:</label>
                        <p id="precio">{{ $horario->actividad->precio_adulto }} €</p>
                    </div>
                @endif

                <!-- Precio para niños -->
                @if (!is_null($horario->actividad->precio_nino))
                    <div class="mb-3 d-flex align-items-baseline">
                        <label for="precio_nino" style="margin-right: 10px;">Precio niños:</label>
                        <p id="precio_nino">{{ $horario->actividad->precio_nino }} €</p>
                    </div>
                @endif

                <div class="mb-3 d-flex align-items-baseline">
                    <label for="total" style="margin-right: 10px;">TOTAL:</label>
                    <p id="total"></p>
                </div>
                <div class="mb-3 d-flex align-items-baseline">
                    <label for="idioma" style="margin-right: 10px;">IDIOMA DE LA ACTIVIDAD:</label>
                    <p id="idioma">{{ $horario->idioma }} </p>
                </div>
            </div>


            <div class="col-md-6">
                <h2 class="mb-4">Completa tus datos</h2>
                <form id="formularioReserva" action="{{ route('paypal.checkout', ['horarioId' => $horario->id]) }}"
                    method="POST">

                    @csrf
                    <input type="hidden" name="horario_id" value="{{ $horario->id }}">
                    <input type="hidden" name="amount" id="paypalAmount">

                    <div class="mb-3 d-flex align-items-baseline">
                        <label for="nombre"style="margin-right: 10px;">Nombre:</label>
                        <p id="nombre">{{ $usuario->nombre }}</p>
                    </div>
                    <div class="mb-3 d-flex align-items-baseline">
                        <label for="apellidos"style="margin-right: 10px;">Apellidos:</label>
                        <p id="apellidos">{{ $usuario->apellido1 }} {{ $usuario->apellido2 }}</p>
                    </div>
                    <div class="mb-3 d-flex align-items-baseline">
                        <label for="email"style="margin-right: 10px;">Email:</label>
                        <p id="email">{{ $usuario->email }} </p>
                    </div>
                    <div class="mb-3 d-flex align-items-baseline">
                        <label for="telefono"style="margin-right: 10px;">Teléfono:</label>
                        <p id="telefono">{{ $usuario->telefono }}</p>
                    </div>
                    <div class="mb-3">
                        <label for="numAdultos">Número de Adultos:</label>
                        <input type="number" class="form-control" id="numAdultos" name="num_adultos" min="1"
                            max="10" required onchange="calcularTotal()">
                    </div>
                    <div class="mb-3">
                        <label for="numNinos">Número de Niños:</label>
                        <input type="number" class="form-control" id="numNinos" name="num_ninos" min="0"
                            onchange="calcularTotal()">
                    </div>
                    <!-- Desplegable para seleccionar el país -->
                    {{-- <div class="mb-3">
                        <label for="pais">País:</label>
                        <select class="form-control" id="pais" name="pais" required>
                            <option value="">-- Seleccionar un país --</option>
                            <option value="espana">España</option>
                            <option value="francia">Francia</option>
                            <option value="alemania">Alemania</option>
                        </select>
                    </div> --}}

                    <!-- Campo para el código postal -->
                    {{-- <div class="mb-3">
                        <label for="codigoPostal">Código Postal:</label>
                        <input type="text" class="form-control" id="codigoPostal" name="codigo_postal" required>
                    </div> --}}

                    <div class="mb-3">
                        <label for="observaciones">Observaciones:</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Confirmar y Pagar</button>

                </form>
            </div>
        </div>
        <script defer>
            document.getElementById('formularioReserva').addEventListener('submit', function(event) {
                event.preventDefault();
                if (validarFormulario()) {
                    let total = document.getElementById('total').textContent.replace(' €', '');
                    document.getElementById('paypalAmount').value = total;
                    this.submit();
                }
            });


            let precioAdultoRaw = "{{ $horario->actividad->precio_adulto ?? '0' }}";
            let precioNinoRaw = "{{ $horario->actividad->precio_nino ?? '0' }}";

            let precioAdulto = parseFloat(precioAdultoRaw);
            let precioNino = parseFloat(precioNinoRaw);

            function calcularTotal() {
                let numAdultos = document.getElementById('numAdultos').value;
                let numNinos = document.getElementById('numNinos').value;

                numAdultos = numAdultos ? parseInt(numAdultos) : 0;
                numNinos = numNinos ? parseInt(numNinos) : 0;

                let total = (numAdultos * precioAdulto) + (numNinos * precioNino);
                document.getElementById('total').textContent = total.toFixed(2) + ' €';
            }

            function validarFormulario() {
                let numAdultos = document.getElementById('numAdultos').value;
                let numNinos = document.getElementById('numNinos').value;

                numAdultos = numAdultos ? parseInt(numAdultos) : 0;
                numNinos = numNinos ? parseInt(numNinos) : 0;

                if (numAdultos === 0 && numNinos === 0) {
                    alert('Debes ingresar al menos un adulto o un niño.');
                    return false; // Esto evitará que el formulario se envíe
                }

                return true; // El formulario se puede enviar
            }

            // Asegúrate de llamar a calcularTotal al cargar la página si es necesario
            window.onload = function() {
                calcularTotal();
            };
        </script>


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
