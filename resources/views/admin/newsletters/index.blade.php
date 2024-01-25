@extends('layouts.admin')

@section('title')
    Admin | Newsletters
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/newsletter.css') }}">
@endsection

@section('content')
    <div class="container">
        <h2 class="my-4 text-center display-4 font-weight-bold titulo">Listado de Newsletters</h2>

        <!-- Mensajes de éxito y error -->
        <div class="mb-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <!-- Botón para Crear Nueva Newsletter -->
            <a href="{{ route('admin.newsletters.create') }}" class="btn btn-success mb-3">Crear Nueva Newsletter</a>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <!-- Búsqueda -->
                    <div class="col-md-6">
                        <label for="searchBox" class="form-label">Buscar Newsletter</label>
                        <input type="text" id="searchBox" class="form-control" placeholder="Buscar Newsletter...">
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.newsletters.index') }}" method="get" class="row align-items-end g-3">
                    <!-- Búsqueda por Rango de Fechas -->
                    <div class="col-md-4">
                        <label for="fecha_inicio" class="form-label">Desde:</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control"
                            value="{{ request('fecha_inicio') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="fecha_fin" class="form-label">Hasta:</label>
                        <input type="date" id="fecha_fin" name="fecha_fin" class="form-control"
                            value="{{ request('fecha_fin') }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">Buscar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="alert alert-info" role="alert">
            Nota: Solo se puede seleccionar y enviar una newsletter a la vez.
        </div>

        @if ($selectedNewsletter)
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title">Newsletter Seleccionada para Envío</h3>
                    <h5 class="text-secondary mb-4 mt-4"><strong>Título:</strong> {{ $selectedNewsletter->titulo }}</h5>
                    @if ($translatedDay)
                        <div class="d-flex align-items-center mb-3">
                            <i class="far fa-calendar-alt me-3 text-info" style="font-size: 1.5rem;"></i>
                            <p class="mb-0"><strong>Día de envío:</strong> {{ $translatedDay }}</p>
                        </div>
                        <div class="d-flex align-items-center mb-4">
                            <i class="far fa-clock me-3 text-success" style="font-size: 1.5rem;"></i>
                            <p class="mb-0"><strong>Hora de envío:</strong> {{ $executionTime }}</p>
                        </div>
                    @else
                        <p class="text-muted mb-4"><strong>Día de envío:</strong> No disponible</p>
                        <p class="text-muted mb-4"><strong>Hora de envío:</strong> No disponible</p>
                    @endif
                    <div>
                        <a href="{{ route('admin.newsletters.deselect', $selectedNewsletter->id) }}"
                            class="btn btn-outline-secondary">Desmarcar</a>
                    </div>
                </div>
            </div>
        @else
            <p class="text-center text-muted mt-5">No hay ninguna newsletter seleccionada para el envío.</p>
        @endif

        <div class="table-responsive">
            <table class="tabla table ">
                <thead>
                    <tr>
                        <th scope="col" class="columna-estrecha">Título</th>
                        <th scope="col"  class="columna-estrecha">Fecha creación
                            <!-- enlaces para la ordenación -->
                            <a href="{{ route('admin.newsletters.index', ['orden' => 'asc', 'columna' => 'titulo']) }}"
                                class="orden-link {{ $claseOrdenActual == 'orden-asc' ? 'active' : '' }}">↑</a>
                            <a href="{{ route('admin.newsletters.index', ['orden' => 'desc', 'columna' => 'titulo']) }}"
                                class="orden-link {{ $claseOrdenActual == 'orden-desc' ? 'active' : '' }}">↓</a>
                        </th>
                        <th scope="col"  class="columna-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody id="newsletterTableBody">

                    @foreach ($newsletters as $newsletter)
                        <tr>
                            <td>{{ $newsletter->titulo }}</td>
                            <td>{{ $newsletter->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Acciones de Newsletter">
                                    <!-- Botón de Vista Previa -->
                                    <button class="btn btn-info rounded-pill me-2"
                                        onclick="previewNewsletter({{ $newsletter->id }})" title="Vista previa">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    <!-- Botón editar -->
                                    <a href="{{ route('admin.newsletters.edit', $newsletter->id) }}"
                                        class="btn btn-secondary rounded me-2" title="Editar esta newsletter">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <!-- Botón para Programar Envío -->
                                    @if ($newsletter->id != 1)
                                        <!-- Suponiendo que no quieres permitir borrar la newsletter con ID 1 -->
                                        <!-- Botón para Programar Envío -->
                                        <button type="button"
                                            class="btn btn-warning btn-sm rounded me-2 scheduleButton"
                                            data-bs-toggle="modal" data-bs-target="#scheduleModal"
                                            data-newsletter-id="{{ $newsletter->id }}"
                                            {{ $selectedNewsletter && $selectedNewsletter->id == $newsletter->id ? 'disabled' : '' }}>
                                            <i class="bi bi-clock-fill"></i> Programar Envío
                                        </button>
                                        <!-- Botón para Borrar -->
                                        <!-- Este botón está deshabilitado si la newsletter está seleccionada para el envío -->
                                        <button type="button" class="btn btn-danger rounded" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal" data-id="{{ $newsletter->id }}"
                                            title="Borrar esta newsletter"
                                            {{ $selectedNewsletter && $selectedNewsletter->id == $newsletter->id ? 'disabled' : '' }}>
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                        <form id="deleteForm" action="" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Enlaces de Paginación -->
            {{ $newsletters->links() }}
        </div>
    </div>

    <!-- Modal de Vista Previa -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">Vista Previa de Newsletter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="previewFrame" title="Vista Previa de Newsletter"
                        style="width: 100%; height: 500px;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Programar Envío -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleModalLabel">Programar Envío de Newsletter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="scheduleForm" action="{{ route('admin.newsletters.updateConfig') }}" method="POST">
                        @csrf
                        <input type="hidden" name="newsletter_id" id="modal_newsletter_id">
                        <div class="row g-3 align-items-end">
                            <!-- Día de Envío Programado -->
                            <div class="col-md-6">
                                <label for="modal_day_of_week" class="form-label">Día de envío:</label>
                                <select id="modal_day_of_week" name="day_of_week" class="form-select">
                                    <option value="Monday" @if (optional($schedule)->day_of_week == 'Monday') selected @endif>Lunes</option>
                                    <option value="Tuesday" @if (optional($schedule)->day_of_week == 'Tuesday') selected @endif>Martes
                                    </option>
                                    <option value="Wednesday" @if (optional($schedule)->day_of_week == 'Wednesday') selected @endif>Miércoles
                                    </option>
                                    <option value="Thursday" @if (optional($schedule)->day_of_week == 'Thursday') selected @endif>Jueves
                                    </option>
                                    <option value="Friday" @if (optional($schedule)->day_of_week == 'Friday') selected @endif>Viernes
                                    </option>
                                </select>
                            </div>

                            <!-- Hora de Envío Programado -->
                            <div class="col-md-6">
                                <label for="modal_execution_time" class="form-label">Hora de envío:</label>
                                <input type="time" id="modal_execution_time" name="execution_time"
                                    class="form-control" value="{{ substr(optional($schedule)->execution_time, 0, 5) }}">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="submitScheduleForm()">Guardar
                        Configuración</button>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.deleteModal', [
        'modalTitle' => 'Confirmar Borrado',
        'modalBody' => '¿Estás seguro de querer borrar esta newsletter?',
    ])
@endsection

@push('scripts')
    <script defer src="{{ asset('js/admin-newsletter.js') }}"></script>
@endpush
