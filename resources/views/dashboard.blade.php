@extends('layouts.guest')

@section('title')
    Dashboard
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
    <main>
        <div class="container py-5">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Pestañas de Navegación -->

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="reservas-tab" data-bs-toggle="tab" data-bs-target="#reservas"
                        type="button" role="tab" aria-controls="reservas" aria-selected="true">Reservas</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="valoraciones-tab" data-bs-toggle="tab" data-bs-target="#valoraciones"
                        type="button" role="tab" aria-controls="valoraciones"
                        aria-selected="false">Valoraciones</button>
                </li>
            </ul>

            <!-- Contenido de las Pestañas -->
            <div class="tab-content" id="myTabContent">
                {{-- Sección Reservas --}}
                <div id="reservas" class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">
                    <h2 class="tab-section-header">Tus Reservas</h2>
                    <!-- Mensaje de alerta personalizado -->
                    <div class="alert alert-info-custom">
                        <i class="fas fa-info-circle alert-icon"></i>
                        <div>
                            Recuerda que solo puedes cancelar hasta 48 horas antes del evento.
                        </div>
                    </div>

                    <h3>Reservas Activas</h3>
                    <div class="row">
                        @foreach ($reservasActivas as $reserva)
                            <div class="card">
                                <div class="card-body">
                                    <!-- Detalles de la reserva -->
                                    <p class="card-text">Fecha: {{ $reserva->horario->fecha }}</p>
                                    <p class="card-text">Hora: {{ $reserva->horario->hora }}</p>
                                    <p class="card-text">Estado: {{ $reserva->estado }}</p>
                                    <a href="{{ url('/descargar-entrada/' . $reserva->id) }}" class="btn btn-success">Descargar Entrada</a>
                                    @php
                                        $fechaReserva = \Carbon\Carbon::parse($reserva->horario->fecha . ' ' . $reserva->horario->hora);
                                        $ahora = \Carbon\Carbon::now();
                                        $diferenciaHoras = $ahora->diffInHours($fechaReserva, false);
                                    @endphp
                                    @if ($diferenciaHoras >= 48)
                                        <form action="{{ route('reservas.cancelar', $reserva->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Cancelar Reserva</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Sección Reservas Pasadas -->
                    <h3>Reservas Pasadas</h3>
                    <div class="row">
                        @foreach ($reservasPasadas as $reserva)
                            <div class="card card-reserva">
                                <div class="card-body">
                                    <!-- Detalles de la reserva -->
                                    <p class="card-text">Fecha: {{ $reserva->horario->fecha }}</p>
                                    <p class="card-text">Hora: {{ $reserva->horario->hora }}</p>
                                    <p class="card-text">Estado: {{ $reserva->estado }}</p>
                                    <a href="{{ url('/descargar-entrada/' . $reserva->id) }}" class="btn btn-success">Descargar Entrada</a>

                                    <!-- Verificar si el usuario ya ha valorado la actividad -->
                                    @php
                                        $usuarioHaValorado = $reserva->actividad->valoraciones->where('user_id', auth()->user()->id)->count() > 0;
                                    @endphp

                                    <!-- Mostrar el botón de valoración solo si el usuario no ha valorado la actividad -->
                                    @if (!$usuarioHaValorado)
                                        <a href="{{ route('pages.valorar', ['id' => $reserva->actividad->id]) }}"
                                            class="btn btn-primary">Valorar Actividad</a>
                                    @endif


                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Sección Valoraciones -->
                <div class="tab-pane fade valoraciones-container" id="valoraciones" role="tabpanel"
                    aria-labelledby="valoraciones-tab">
                    <h2 class="tab-section-header">Tus Valoraciones</h2>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            @foreach ($valoracionesUsuario as $valoracion)
                                <div class="card card-detail">
                                    <img src="{{ $valoracion->actividad->imagen }}" class="card-img-top"
                                        alt="Imagen de la actividad">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $valoracion->actividad->nombre }}</h5>
                                        <p class="text-muted small">Valorado el
                                            {{ $valoracion->created_at->format('d/m/Y') }}</p>
                                        <p class="card-text">
                                            <span class="star-rating">
                                                @for ($i = 0; $i < 5; $i++)
                                                    @if ($i < $valoracion->puntuacion)
                                                        <span class="filled">★</span>
                                                    @else
                                                        <span class="empty">★</span>
                                                    @endif
                                                @endfor
                                            </span>
                                        </p>
                                        <p class="card-text">{{ $valoracion->comentario }}</p>
                                        <a href="/actividades/{{ $valoracion->actividad->id }}"
                                            class="btn btn-primary mt-3">Ver actividad</a>
                                        <button class="btn btn-secondary mt-3">Editar</button>
                                        <button class="btn btn-danger mt-3" data-bs-toggle="modal"
                                            data-bs-target="#deleteValoracionModal"
                                            data-id="{{ $valoracion->id }}">Borrar</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal de Confirmación de Borrado -->
            <div class="modal fade" id="deleteValoracionModal" tabindex="-1" aria-labelledby="deleteValoracionModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteValoracionModalLabel">Confirmar Borrado</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¿Estás seguro de que quieres borrar esta valoración?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <form id="deleteValoracionForm" action="" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Borrar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script>
        //Para el modal
        document.addEventListener("DOMContentLoaded", function() {
            var valoracionModal = document.getElementById('deleteValoracionModal');
            valoracionModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var valoracionId = button.getAttribute('data-id');
                var deleteForm = document.getElementById('deleteValoracionForm');
                deleteForm.action = '/valoraciones/' + valoracionId;
            });
        });
    </script>
@endsection
