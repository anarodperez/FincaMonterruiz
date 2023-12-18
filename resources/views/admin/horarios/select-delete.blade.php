@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2 class="my-4 text-center">Borrar Horarios Seleccionados</h2>
        <form action="{{ route('admin.horarios.destroySelected') }}" method="POST" style="min-height: 650px;">
            @csrf
            @method('DELETE')

            <!-- Itera sobre los horarios seleccionados para cargarlos dinámicamente -->
            @foreach($horarios as $horario)
                <div class="mb-3">
                    <label for="horario_{{ $horario->id }}" class="form-label">{{ $horario->actividad->nombre }} - {{ $horario->dia_semana }} - {{ $horario->hora }}</label>
                    <input type="checkbox" name="horarios[]" id="horario_{{ $horario->id }}" value="{{ $horario->id }}">
                </div>
            @endforeach

            <!-- Agrega otros campos según sea necesario -->
            <button type="submit" class="btn btn-danger">Borrar Horarios Seleccionados</button>
            <a href="{{ route('admin.horarios.index') }}" class="btn btn-info">
                <span class="fas fa-undo-alt"></span> Regresar
            </a>
        </form>
    </div>
@endsection
