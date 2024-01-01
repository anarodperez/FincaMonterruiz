{{-- resources/views/admin/reservas.blade.php --}}

@extends('admin.index')


@section('content')
    <div class="container">
        <h1>Reservas</h1>
        <table class="table">
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
                @foreach($reservas as $reserva)
                <tr>
                    <td>{{ $reserva->id }}</td>
                    <td>{{ $reserva->usuario->nombre}}  {{ $reserva->usuario->apellido1}} {{ $reserva->usuario->apellido2}}</td>
                    <td>{{ $reserva->actividad ? $reserva->actividad->nombre : 'Actividad no disponible' }}</td>
                    <td>{{ $reserva->horario->fecha}}</td>
                    <td>{{ $reserva->horario->hora}}</td>
                    <td>{{ $reserva->estado}}</td>
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
    </div>
@endsection
