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

        @if ($errors->has('aforo_error'))
            <div class="alert alert-danger">
                {{ $errors->first('aforo_error') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            <!-- Columna de detalles de la reserva -->
            <div class="col-md-6  detalles-reserva">
                <h2 class="mb-4">Detalles de la reserva</h2>

                <div class="info-reserva">
                    <div class="mb-3">
                        <span class="etiqueta">Fecha de la reserva:</span>
                        <span id="fechaReserva" class="valor">{{ $horario->fecha }}</span>
                    </div>
                    <div class="mb-3">
                        <span class="etiqueta">Hora de la reserva:</span>
                        <p id="horaReserva">{{ date('H:i', strtotime($horario->hora)) }}</p>
                    </div>
                    <div class="mb-3">
                        <span class="etiqueta">Experiencia seleccionada:</span>
                        <span id="experiencia" class="valor">{{ $horario->actividad->nombre }}</span>
                    </div>
                    <!-- Precio por adulto -->
                    @if (!is_null($horario->actividad->precio_adulto))
                        <div class="mb-3">
                            <span class="etiqueta">Precio por persona:</span>
                            <span id="precio" class="valor">{{ $horario->actividad->precio_adulto }} €</span>
                        </div>
                    @endif

                    <!-- Precio para niños -->
                    @if (!is_null($horario->actividad->precio_nino))
                        <div class="mb-3">
                            <span class="etiqueta">Precio niños:</span>
                            <span id="precio_nino" class="valor">{{ $horario->actividad->precio_nino ?? '0' }} €</span>
                        </div>
                    @endif

                    <!-- Precio Total Sin IVA -->
                    <div class="mb-3">
                        <span class="etiqueta">Subtotal (Sin IVA):</span>
                        <span id="subtotal" class="valor"></span>
                    </div>

                    <!-- Monto del IVA -->
                    <div class="mb-3">
                        <span class="etiqueta">IVA (21%):</span>
                        <span id="iva" class="valor"></span>
                    </div>

                    <!-- Precio Total Con IVA -->
                    <div class="mb-3">
                        <span class="etiqueta">TOTAL (Con IVA):</span>
                        <span id="totalConIVA" class="valor"></span>
                    </div>

                    <div class="mb-3 d-flex align-items-baseline">
                        <span class="etiqueta">Idioma de la actividad:</span>
                        <span id="idioma" class="valor">{{ $horario->idioma }}</span>
                    </div>
                    <div class="mb-3">
                        <span class="etiqueta">Aforo disponible:</span>
                        <span id="aforo" class="aforo">{{ max($aforoDisponible, 0) }}</span>

                    </div>

                </div>
            </div>

            <div class="col-md-6">
                <h2 class="mb-4">Completa tus datos</h2>
                <form id="formularioReserva" class="formulario-reserva"
                    action="{{ route('paypal.checkout', ['horarioId' => $horario->id]) }}" method="POST">

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
                        <input type="number" class="form-control" id="numAdultos" name="num_adultos" min="0"
                            onchange="calcularTotal()">
                    </div>

                    @if (!is_null($horario->actividad->precio_nino))
                        <div class="mb-3">
                            <label for="numNinos">Número de Niños:</label>
                            <input type="number" class="form-control" id="numNinos" name="num_ninos" min="0"
                                onchange="calcularTotal()">
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="observaciones">Observaciones:</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Confirmar y Pagar</button>
                    </div>

                </form>
            </div>
        </div>
        <script defer>
            document.getElementById('formularioReserva').addEventListener('submit', function(event) {
                event.preventDefault();
                if (validarFormulario()) {
                    let totalConIVA = document.getElementById('totalConIVA').textContent.replace(' €', '');
                    document.getElementById('paypalAmount').value = totalConIVA;
                    this.submit();
                }
            });

            let precioAdulto = parseFloat("{{ $horario->actividad->precio_adulto ?? '0' }}");
            let precioNino = parseFloat("{{ $horario->actividad->precio_nino ?? '0' }}");

            function calcularTotal() {
                let numAdultos = parseInt(document.getElementById('numAdultos').value) || 0;
                let numNinos = parseInt(document.getElementById('numNinos') ? document.getElementById('numNinos').value : 0) || 0;

                let subtotal = (numAdultos * precioAdulto) + (numNinos * precioNino);
                let iva = subtotal * 0.21;
                let totalConIVA = subtotal + iva;

                document.getElementById('subtotal').textContent = subtotal.toFixed(2) + ' €';
                document.getElementById('iva').textContent = iva.toFixed(2) + ' €';
                document.getElementById('totalConIVA').textContent = totalConIVA.toFixed(2) + ' €';
            }

            function validarFormulario() {
                let numAdultos = parseInt(document.getElementById('numAdultos').value) || 0;
                let numNinos = parseInt(document.getElementById('numNinos') ? document.getElementById('numNinos').value : 0) || 0;

                if (numAdultos === 0 && numNinos === 0) {
                    alert('Debes ingresar al menos un adulto o un niño.');
                    return false;
                }

                return true;
            }

            window.onload = function() {
                calcularTotal();
            };
        </script>




    </div>
@endsection
