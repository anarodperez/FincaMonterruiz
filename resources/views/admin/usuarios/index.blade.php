@extends('admin.index')

@section('title', 'Admin | Usuarios')

@section('content')
    <div class="container">
        <div class="text-center my-4">
            <h2 class="display-4 font-weight-bold titulo">Listado de Usuarios</h2>
            <p class="lead">Descubre y gestiona la lista de usuarios en el sistema.</p>
        </div>

        <div class="content contenedor-tabla">

            {{-- Botón para exportar datos --}}
            <div class="mb-4">
                <a href="{{ route('admin.usuarios.exportCsv') }}" class="btn btn-info">Exportar a CSV</a>
            </div>

            <!-- Formulario de búsqueda -->
            <form id="searchForm" action="{{ route('admin.usuarios.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="termino_busqueda" class="form-control text-center"
                        placeholder="Buscar por nombre, apellido, email o teléfono"
                        value="{{ request('termino_busqueda') }}">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary ml-2">Limpiar</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="tabla table">
                    <thead>
                        <tr>
                            <th>
                                <a href="{{ route('admin.usuarios.index', ['sort' => 'nombre']) }}" class="header-text">
                                    Nombre <i class="fas fa-sort"></i>
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.usuarios.index', ['sort' => 'apellido1']) }}" class="header-text">
                                    Apellidos <i class="fas fa-sort"></i>
                                </a>
                            </th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Fecha nacimiento</th>
                            <th>Validado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->nombre }}</td>
                                <td>{{ $usuario->apellidos }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->telefono }}</td>
                                <td>{{ $usuario->fecha_nacimiento }}</td>
                                <td>
                                    <form action="{{ route('admin.usuarios.validar', $usuario->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" value="{{ $usuario->id }}">

                                        @if ($usuario->validado)
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-check"></i> Validar
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-times"></i> Invalidar
                                            </button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $usuarios->links() }}
            </div>
        </div>
    </div>

@endsection
