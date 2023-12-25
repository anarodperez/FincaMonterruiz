@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Editar Horario</h2>
    <form action="{{ route('admin.horarios.update', $horario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Actividad:</label>
            <input type="text" class="form-control" value="{{ $horario->actividad->nombre }}" disabled>
            <input type="hidden" name="actividad" value="{{ $horario->actividad_id }}">
        </div>

        <!-- Otros campos del formulario -->
        <input type="date" name="fecha" value="{{ $horario->fecha }}" required>
        <input type="time" name="hora" value="{{ $horario->hora }}" required>

        <button type="submit" class="btn btn-primary">Actualizar Horario</button>
    </form>
</div>
@endsection
