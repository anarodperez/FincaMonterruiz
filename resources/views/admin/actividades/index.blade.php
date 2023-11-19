@extends('admin.index')

@section('title', 'Admin | Actividades')

@section('content')
    <h5 class="card-title text-center">Listado de actividades</h5>
    <div class="content">
        <div class="contenedor-tabla">
            <p>
                <a href="{{ route('admin.actividades.create') }}" class="btn btn-primary">
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
                            {{-- <td>
                                @if ($actividad->categoria)
                                    {{ $actividad->categoria->nombre }}
                                @else
                                    Sin categoría
                                @endif
                            </td> --}}
                            <td>
                                <form action="{{ route('admin.actividades.edit', encrypt($actividad->id)) }}" method="GET">
                                    <button class="btn btn-warning btn-sm" style="margin-bottom: 5px;">
                                        <span class="fas fa-edit"></span>
                                    </button>
                                </form>
                                <form action="{{ route('admin.actividades.show', ['actividad' => encrypt($actividad->id)]) }}" method="GET">
                                    <button class="btn btn-danger btn-sm">
                                        <span class="fas fa-times"></span>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
