@extends('layouts.admin')

@section('title', 'Panel Admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">

            <!-- Contenido principal -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-12 px-4">
                <div class="text-center my-4">
                    <h2 class="display-4 font-weight-bold titulo">Panel Administrador</h2>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Actividades Existentes</h5>
                                @if (isset($cantidadActividades))
                                    <p class="card-text">{{ $cantidadActividades }}</p>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Valoraciones</h5>
                                @if (isset($cantidadValoraciones))
                                    <p class="card-text">{{ $cantidadValoraciones }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Usuarios Registrados</h5>
                                @if (isset($usuariosRegistrados))
                                    <p class="card-text">{{ $usuariosRegistrados }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reservas recientes -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Reservas Recientes</h5>
                                <ul class="list-group list-group-flush">
                                    @if (isset($reservasRecientes))
                                        @forelse ($reservasRecientes as $reserva)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $reserva->actividad->nombre }}
                                                <small
                                                    class="text-muted">{{ $reserva->created_at->format('d/m/Y') }}</small>
                                                <span
                                                    class="badge rounded-pill {{ $reserva->estado == 'confirmado' ? 'bg-success' : ($reserva->estado == 'cancelada' ? 'bg-danger' : 'bg-warning') }}">
                                                    {{ $reserva->estado }}
                                                </span>
                                            </li>
                                        @empty
                                            <li class="list-group-item">No hay reservas recientes.</li>
                                        @endforelse
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Valoraciones y comentarios -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card" style="margin-bottom: 8vh;">
                            <div class="card-body">
                                <h5 class="card-title">Valoraciones y Comentarios</h5>
                                <!-- lista de las últimas valoraciones y comentarios -->
                                <ul class="list-group">
                                    @if (isset($ultimasValoraciones))
                                        @forelse ($ultimasValoraciones as $valoracion)
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span>{{ $valoracion->user->nombre }}</span>
                                                    <span
                                                        class="badge badge-primary badge-pill">{{ $valoracion->puntuacion }}
                                                    </span>
                                                </div>
                                                <p>{{ $valoracion->comentario }}</p>
                                            </li>
                                        @empty
                                            <li class="list-group-item">No hay valoraciones recientes.</li>
                                        @endforelse
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-grafico">
                    <div class="card-body" id="card">
                        <canvas id="graficoReservas"></canvas>
                    </div>
                </div>


                {{-- Para el gráfico --}}
                <!-- ... (código anterior) ... -->

                <!-- ... (código anterior) ... -->

                <!-- ... (código anterior) ... -->

                <script>
                    var datosReservas = @json($datosReservas);

                    // Comprobar si hay datos en datosReservas antes de crear el gráfico
                    if (datosReservas.length > 0) {
                        // Crear el gráfico
                        var fechas = datosReservas.map(dato => dato.fecha);
                        var totales = datosReservas.map(dato => parseInt(dato.total)); // Convierte a números enteros

                        var ctx = document.getElementById('graficoReservas').getContext('2d');
                        var graficoReservas = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: fechas,
                                datasets: [{
                                    label: 'Reservas por Día',
                                    data: totales,
                                    backgroundColor: 'rgba(0, 123, 255, 0.2)',
                                    borderColor: 'rgba(0, 123, 255, 1)',
                                    borderWidth: 2,
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        stepSize: 5, // Establece el paso de la escala en el eje Y
                                        max: 100, // Establece el valor máximo en el eje Y, ajusta esto según tus datos
                                    },
                                    x: {
                                        beginAtZero: true,
                                        labels: fechas, // Establece las etiquetas en el eje X como las fechas
                                    }
                                }
                            }
                        });
                    } else {
                        // No hay datos en datosReservas, muestra un mensaje en el lugar donde deseas mostrarlo
                        var mensaje = document.createElement('p');
                        mensaje.innerText = 'No hay reservas disponibles para mostrar el gráfico.';
                        mensaje.style.textAlign = 'center'; // Centra horizontalmente
                        mensaje.style.fontSize = '24px'; // Aumenta el tamaño del texto
                        mensaje.style.display = 'flex';
                        mensaje.style.justifyContent = 'center'; // Centra verticalmente
                        mensaje.style.alignItems = 'center';
                        // Reemplaza 'nombre_del_div_donde_mostrar_mensaje' con el ID o clase del elemento HTML donde deseas mostrar el mensaje.
                        document.getElementById('card').appendChild(mensaje);
                    }
                </script>




            </main>
        </div>
    </div>
@endsection
