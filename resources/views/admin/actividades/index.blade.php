@extends('admin.index')

@section('title', 'Admin | Actividades')

@section('content')
    <div class="container">
        <div class="text-center my-4">
            <h2 class="display-4 font-weight-bold">Listado de Actividades</h2>
            <p class="lead">Descubre y gestiona la lista de actividades en el sistema.</p>
        </div>
        <div class="content">
            {{-- Mensaje de éxito --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Mensaje de error --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="contenedor-tabla">
                <p>
                    <a href="{{ route('admin.actividades.create') }}" class="btn btn-primary crear-actividad">
                        <span class="fas fa-plus"></span> Crear actividad
                    </a>
                </p>
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Duración</th>
                            <th>Precio Adulto</th>
                            <th>Precio niños</th>
                            <th>Aforo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($actividades as $actividad)
                            <tr>
                                <td><img src="{{ asset($actividad->imagen) }}" alt="{{ $actividad->nombre }}"></td>
                                <td>{{ $actividad->nombre }}</td>
                                <td>{{ $actividad->descripcion }}</td>
                                <td>{{ $actividad->duracion }}</td>
                                <td>{{ $actividad->precio_adulto }}</td>
                                <td>{{ $actividad->precio_nino }}</td>
                                <td>{{ $actividad->aforo }}</td>
                                <td>{{ $actividad->activa == 1 ? 'Activa' : 'Inactiva' }}</td>
                                <td>
                                    <form action="{{ route('admin.actividades.edit', encrypt($actividad->id)) }}"
                                        method="GET">
                                        <button class="btn btn-warning btn-sm" style="margin-bottom: 5px;">
                                            <span class="fas fa-edit"></span>
                                        </button>
                                    </form>
                                    {{-- <form
                                        action="{{ route('admin.actividades.show', ['actividad' => encrypt($actividad->id)]) }}"
                                        method="GET">
                                        <button class="btn btn-danger btn-sm">
                                            <span class="fas fa-times"></span>
                                        </button>
                                    </form> --}}

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Enlaces de paginación -->
                {{ $actividades->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
