@extends('admin.index')

@section('title', 'Admin | Actividades')

@section('content')
<div class="text-center my-4">
    <h2 class="display-4 font-weight-bold text-primary">Listado de Actividades</h2>
    <p class="lead">Descubre y gestiona la lista de actividades en el sistema.</p>
</div>
    <div class="content">
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
                        {{-- <th>Categoría</th>  Nueva columna para la categoría --> --}}
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Enlaces de paginación -->
            {{ $actividades->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
