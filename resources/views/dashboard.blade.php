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
            <div id="welcomeMessage" class="alert alert-info"></div>
        </div>

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
                    <h2 class="tab-section-header display-4 font-weight-bold text-center">Tus Reservas</h2>
                    <!-- Mensaje de alerta personalizado -->
                    <div class="alert alert-info-custom">
                        <i class="fas fa-info-circle alert-icon"></i>
                        <div>
                            Recuerda que solo puedes cancelar hasta 48 horas antes del evento.
                        </div>
                    </div>
                    <!-- Sección Reservas Activas -->
                    <h3>Reservas Activas</h3>
                    @if ($reservasActivas->count() > 0)
                        <div class="row">
                            @foreach ($reservasActivas as $reserva)
                                <div class="card">
                                    <div class="card-body">
                                        <!-- Detalles de la reserva -->
                                        <p class="card-text">Actividad: <strong>{{ $reserva->actividad->nombre }}</strong>
                                        </p>
                                        <p class="card-text">Fecha: <strong>{{ $reserva->horario->fecha }} </strong> </p>
                                        <p class="card-text">Hora: <strong>{{ $reserva->horario->hora }} </strong> </p>
                                        <p class="card-text">
                                            Estado: <span class="{{ $reserva->estado == 'confirmado' ? 'text-success' : ($reserva->estado == 'cancelada' ? 'text-danger' : '') }}">
                                                <strong>{{ $reserva->estado }}</strong>
                                            </span>
                                        </p>

                                        <div class="d-flex align-items-center mt-2">
                                            <a href="{{ url('/descargar-entrada/' . $reserva->id) }}"
                                                class="btn btn-success" style="margin-right: 1vw">Descargar Entrada</a>
                                            @php
                                                $fechaReserva = \Carbon\Carbon::parse($reserva->horario->fecha . ' ' . $reserva->horario->hora);
                                                $ahora = \Carbon\Carbon::now();
                                                $diferenciaHoras = $ahora->diffInHours($fechaReserva, false);
                                            @endphp
                                            @if ($reserva->estado != 'cancelada' && $diferenciaHoras >= 48)
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#cancelModal" data-id="{{ $reserva->id }}">
                                                    Cancelar Reserva
                                                </button>
                                            @endif
                                        </div>

                                        @if ($reserva->estado == 'cancelada')
                                            <div class="alert alert-warning" role="alert">
                                                Esta reserva ha sido cancelada. El reembolso ha sido procesado.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="paginacion mt-3">
                            {{ $reservasActivas->links() }}
                        </div>
                    @else
                        <p>No tienes reservas activas aún.</p>
                    @endif

                    <!-- Sección Reservas Pasadas -->
                    <h3>Reservas Pasadas</h3>

                    <div class="row">
                        @if ($reservasPasadas->count() > 0)
                            @foreach ($reservasPasadas as $reserva)
                                <div class="card card-reserva">
                                    <div class="card-body">
                                        <!-- Detalles de la reserva -->
                                        <p class="card-text">Actividad: <strong> {{ $reserva->actividad->nombre }} </strong></p>
                                        <p class="card-text">Fecha: <strong>{{ $reserva->horario->fecha }}</strong> </p>
                                        <p class="card-text">Hora: <strong>{{ $reserva->horario->hora }}</strong> </p>
                                        <p class="card-text">Estado: {{ $reserva->estado }}</p>
                                        <div class="d-flex align-items-center">
                                            <a href="{{ url('/descargar-entrada/' . $reserva->id) }}"
                                                class="btn btn-success" style="margin-right: 1vw">Descargar Entrada</a>

                                            <!-- Verificar si el usuario ya ha valorado la actividad -->
                                            @php
                                                $usuarioHaValorado = $reserva->actividad->valoraciones->where('user_id', auth()->user()->id)->count() > 0;
                                            @endphp

                                            <!-- Mostrar el botón de valoración solo si el usuario no ha valorado la actividad -->
                                            @if (!$usuarioHaValorado && $reserva->estado != 'cancelada')
                                                <a href="{{ route('pages.valorar', ['id' => $reserva->actividad->id]) }}"
                                                    class="btn btn-primary">Valorar Actividad</a>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No tienes reservas pasadas aún.</p>
                        @endif
                    </div>
                    <div class="paginacion mt-3">
                        {!! $reservasPasadas->links() !!}
                    </div>
                </div>

                <!-- Sección Valoraciones -->
                <div class="tab-pane fade valoraciones-container" id="valoraciones" role="tabpanel"
                    aria-labelledby="valoraciones-tab">
                    <h2 class="tab-section-header">Tus Valoraciones</h2>
                    @if ($valoracionesUsuario->count() > 0)
                        <div class="row valoraciones">
                            @foreach ($valoracionesUsuario as $valoracion)
                                <div class="col-md-4 mb-4">
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
                                            {{-- <a href="/actividades/{{ $valoracion->actividad->id }}"
                                            class="btn btn-primary mt-3">Ver actividad</a> --}}
                                            <button class="btn btn-secondary mt-3" data-bs-toggle="modal"
                                                data-bs-target="#editValoracionModal"
                                                data-id="{{ $valoracion->id }}">Editar</button>
                                            <button class="btn btn-danger mt-3" data-bs-toggle="modal"
                                                data-bs-target="#deleteValoracionModal"
                                                data-id="{{ $valoracion->id }}">Borrar</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {{ $valoracionesUsuario->links() }}
                        </div>
                    @else
                        <p>No tienes valoraciones aún.</p>
                    @endif
                </div>
            </div>

            <!-- Modal para Edición de Valoración -->
            <div class="modal fade" id="editValoracionModal" tabindex="-1" aria-labelledby="editValoracionModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editValoracionModalLabel">Editar Valoración</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="puntuacion" class="form-label">Puntuación</label>
                                    <input type="number" class="form-control" id="puntuacion" name="puntuacion">
                                </div>
                                <div class="mb-3">
                                    <label for="comentario" class="form-label">Comentario</label>
                                    <textarea class="form-control" id="comentario" name="comentario" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal de Confirmación de Borrado -->
            <div class="modal fade" id="deleteValoracionModal" tabindex="-1"
                aria-labelledby="deleteValoracionModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteValoracionModalLabel">Confirmar Borrado</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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
            <!-- Add Cancel Modal -->
            <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cancelModalLabel">Cancelar Reserva</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¿Estás seguro de que quieres cancelar esta reserva?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <form id="cancelForm" action="" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Cancelar Reserva</button>
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

        // Para el modal de edición
        document.addEventListener("DOMContentLoaded", function() {
            var editValoracionModal = document.getElementById('editValoracionModal');
            editValoracionModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var valoracionId = button.getAttribute('data-id');
                var editForm = document.getElementById('editValoracionForm');

                if (valoracionId) {
                    // Si se está editando una valoración existente
                    editForm.action = '/valoraciones/actualizar/' + valoracionId;
                    editForm.querySelector('input[name="_method"]').value = 'PUT';
                } else {
                    // Si se está creando una nueva valoración
                    editForm.action = '/valoraciones';
                    editForm.querySelector('input[name="_method"]').value = 'POST';
                }
            });
        });

        //Para el modal de cancelar actividad
        document.addEventListener("DOMContentLoaded", function() {
            var cancelModal = document.getElementById('cancelModal');
            cancelModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var reservaId = button.getAttribute('data-id');
                var cancelForm = document.getElementById('cancelForm');
                cancelForm.action = '/reservas/' + reservaId + '/cancelar';
            });
        });
    </script>
@endsection
@push('scripts')
<script src="{{ asset('js/ultima_visita-cookie.js') }}"></script>
@endpush
