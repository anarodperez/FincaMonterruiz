@extends('admin.index')

@section('title', 'Admin | Usuarios')

@section('content')
    <h5 class="card-title text-center">Listado de usuarios</h5>
    <div class="content">
        <form id="searchForm" action="{{ route('admin.usuarios.index') }}" method="GET">
            <div class="form-group">
                <input type="text" name="nombre" id="nombre" placeholder="Buscar por nombre" value="{{ request('nombre') }}">
                <button type="submit">Buscar</button>
            </div>
        </form>

        <div class="contenedor-tabla">
            <p>
                {{-- <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary">
                    <span class="fas fa-plus"></span> Crear Usuario
                </a> --}}
            </p>
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Fecha nacimiento</th>
                        <th>Validado</th>
                        <th>Acciones</th>
                        <!-- Agrega más encabezados de columnas según sea necesario -->
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
                                <form action="{{ route('admin.usuarios.validar', $usuario->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="id" value="{{ $usuario->id }}">

                                    @if ($usuario->validado)
                                        <button type="submit" class="btn boton-rojo" style="background-color:red">Invalidar</button>
                                    @else
                                        <button type="submit" class="btn boton-verde" style="background-color:green">Validar</button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Configura el autocompletado
            $('#nombre').autocomplete({
                source: function(request, response) {
                    // Hacer una solicitud AJAX para obtener los resultados de búsqueda
                    $.ajax({
                        url: '{{ route("admin.usuarios.autocomplete") }}',
                        dataType: 'json',
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                minLength: 2 // Número mínimo de caracteres antes de realizar la búsqueda
            });
        });
    </script>
@endsection
