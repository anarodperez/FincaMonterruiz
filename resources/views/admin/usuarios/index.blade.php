@extends('admin.index')

@section('title', 'Admin | Usuarios')

@section('content')
    <div class="container">
        <div class="text-center my-4">
            <h2 class="display-4 font-weight-bold text-primary">Listado de Usuarios</h2>
            <p class="lead">Descubre y gestiona la lista de usuarios en el sistema.</p>
        </div>

        <div class="content contenedor-tabla">
            <form id="searchForm" action="{{ route('admin.usuarios.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Buscar por nombre"
                        value="{{ request('nombre') }}">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellidos</th>
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
                                            <button type="submit" class="btn boton-rojo"
                                                style="background-color:red">Invalidar</button>
                                        @else
                                            <button type="submit" class="btn boton-verde"
                                                style="background-color:green">Validar</button>
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
