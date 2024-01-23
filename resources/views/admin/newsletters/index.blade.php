@extends('layouts.admin')

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
                <!-- Opciones de Búsqueda y Ordenación -->
                <div class="row mb-3">
                    <!-- Búsqueda -->
                    <div class="col-md-6">
                        <label for="searchBox" class="form-label">Buscar Newsletter</label>
                        <input type="text" id="searchBox" class="form-control" placeholder="Buscar Newsletter...">
                    </div>

                    {{-- <!-- Ordenación -->
                    <form id="miFormulario" action="{{ route('admin.newsletters.index') }}" method="get">
                        <div class="col-md-6">
                            <label for="ordenarPor" class="form-label">Ordenar por fecha:</label>
                            <select name="orden" id="ordenarPor" class="form-select" onchange="this.form.submit()">
                                <option value="asc" {{ request('orden') == 'asc' ? 'selected' : '' }}>Más antiguo primero
                                </option>
                                <option value="desc" {{ request('orden') == 'desc' ? 'selected' : '' }}>Más reciente
                                    primero
                                </option>
                            </select>
                        </div>
                    </form> --}}
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

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.newsletters.updateConfig') }}" method="POST" class="mb-4">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <!-- Día de Envío Programado -->
                        <div class="col-md-6">
                            <label for="day_of_week" class="form-label">Día de envío programado:</label>
                            <select id="day_of_week" name="day_of_week" class="form-select">
                                <option value="Monday">Lunes</option>
                                <option value="Tuesday">Martes</option>
                                <option value="Wednesday">Miércoles</option>
                                <option value="Thursday">Jueves</option>
                                <option value="Friday">Viernes</option>
                            </select>
                        </div>

                        <!-- Hora de Envío Programado -->
                        <div class="col-md-6">
                            <label for="execution_time" class="form-label">Hora de envío programado:</label>
                            <input type="time" id="execution_time" name="execution_time" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Guardar Configuración</button>
                </form>
            </div>
        </div>


        <table class="tabla table ">
            <thead>
                <tr>
                    <th scope="col">Título</th>
                    <th scope="col">Fecha creación
                        <!-- enlaces para la ordenación -->
                        <a href="{{ route('admin.newsletters.index', ['orden' => 'asc', 'columna' => 'titulo']) }}"
                            class="orden-link {{ $claseOrdenActual == 'orden-asc' ? 'active' : '' }}">↑</a>
                        <a href="{{ route('admin.newsletters.index', ['orden' => 'desc', 'columna' => 'titulo']) }}"
                            class="orden-link {{ $claseOrdenActual == 'orden-desc' ? 'active' : '' }}">↓</a>
                    </th>
                    <th scope="col">Acciones</th>
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

                                <!-- Botón para seleccionar la newsletter para envío -->
                                <form action="{{ route('admin.newsletters.select', $newsletter->id) }}" method="post"
                                    style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning me-2" title="Enviar esta newsletter"
                                        onclick="return confirm('¿Estás seguro de que quieres enviar esta newsletter? Esta acción no se puede deshacer.');">
                                        <i class="bi bi-envelope-fill"></i> Enviar
                                    </button>
                                </form>

                                <!-- Enlace a la vista de edición -->
                                <a href="{{ route('admin.newsletters.edit', $newsletter->id) }}"
                                    class="btn btn-secondary rounded me-2" title="Editar esta newsletter">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>

                                <!-- Botón para Borrar -->
                                <button type="button" class="btn btn-danger rounded" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-id="{{ $newsletter->id }}"
                                    title="Borrar esta newsletter">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </div>
                            <form id="deleteForm" action="" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal de Vista Previa -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
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

    @include('admin.partials.deleteModal', [
        'modalTitle' => 'Confirmar Borrado',
        'modalBody' => '¿Estás seguro de querer borrar esta newsletter?',
    ])
@endsection

@push('scripts')
    <script defer src="{{ asset('js/admin-newsletter.js') }}"></script>
@endpush
