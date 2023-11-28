@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2 class="my-4 text-center">Seleccionar Horarios para Borrar</h2>

        <form action="{{ route('admin.horarios.destroySelected') }}" method="POST">
            @csrf
            @method('DELETE')

            <ul>
                @foreach($horarios as $horario)
                    <li>
                        <label>
                            <input type="checkbox" name="horarios[]" value="{{ $horario->id }}">
                            {{ $horario->actividad->nombre }} - {{ $horario->dia_semana }} - {{ $horario->hora }}
                        </label>
                    </li>
                @endforeach
            </ul>

            <button type="submit" class="btn btn-danger">Borrar Horarios Seleccionados</button>
            <a href="{{ route('admin.horarios.index') }}" class="btn btn-info">
                <span class="fas fa-undo-alt"></span> Regresar
            </a>
        </form>
    </div>
@endsection
