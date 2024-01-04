@extends('admin.index')

@section('title', 'Admin | Reservas')

@section('content')
    <div class="container">
        <div class="text-center my-4">
            <h2 class="display-4 font-weight-bold text-primary">Listado de Reservas</h2>
            <p class="lead">Descubre y gestiona la lista de reservas en el sistema.</p>
        </div>
        <div class="table-responsive">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Actividad</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservas as $reserva)
                        <tr>
                            <td>{{ $reserva->id }}</td>
                            <td>{{ $reserva->usuario->nombre }} {{ $reserva->usuario->apellido1 }}
                                {{ $reserva->usuario->apellido2 }}</td>
                            <td>{{ $reserva->actividad->nombre }}</td>
                            <td>{{ $reserva->horario->fecha }}</td>
                            <td>{{ $reserva->horario->hora }}</td>
                            <td>{{ $reserva->estado }}</td>
                            <td>
                                <form action="{{ route('reservas.cancelar', $reserva->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Cancelar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Enlaces de paginación --}}
            {{ $reservas->links() }}
        </div>
    @endsection
