{{-- resources/views/horarios/edit.blade.php --}}

@extends('layouts.admin')

@section('content')
    <h2>Editar Horario</h2>

    <form action="{{ route('horarios.update', $horario->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Aquí tus campos de formulario, prellenados con los datos de $horario --}}
        {{-- ... --}}

        <label>
            <input type="checkbox" name="editar_todos" value="1">
            Aplicar cambios a todos los eventos futuros
        </label>

        <button type="submit" class="btn btn-primary">Actualizar Horario</button>
    </form>
@endsection
