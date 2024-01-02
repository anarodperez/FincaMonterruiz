@extends('layouts.guest') {{-- Asegúrate de extender tu layout principal --}}

@section('title', 'Valorar Actividad')

@section('content')
<style>
    .valoracion-estrellas {
    direction: rtl; /* Invertir dirección para seleccionar estrellas */
}

.valoracion-estrellas input[type="radio"] {
    display: none; /* Ocultar botones de radio */
}

.valoracion-estrellas label {
    font-size: 30px;
    color: #ccc;
    cursor: pointer;
}

.valoracion-estrellas label:hover,
.valoracion-estrellas label:hover ~ label,
.valoracion-estrellas input[type="radio"]:checked ~ label {
    color: gold;
}

</style>
    <main class="container py-5">
        <h1>Valorar Actividad</h1>

        {{-- Asumiendo que estás pasando una variable "actividad" a la vista --}}
        <h2>{{ $actividad->nombre }}</h2>

        {{-- Formulario de Valoración --}}
        <form action="{{ route('valoraciones.store') }}" method="POST">
            @csrf {{-- Token CSRF para seguridad en Laravel --}}

            {{-- Campo Oculto para ID de la Actividad --}}
            <input type="hidden" name="actividad_id" value="{{ $actividad->id }}">

            {{-- Sistema de Estrellas para la Valoración --}}
            <div class="valoracion-estrellas">
                <p>Calificación:</p>
                @for ($i = 1; $i <= 5; $i++)
                    <input type="radio" name="puntuacion" id="estrella{{ $i }}" value="{{ $i }}"><label for="estrella{{ $i }}">★</label>
                @endfor
            </div>

            {{-- Campo para Comentario --}}
            <div class="mb-3">
                <label for="comentario" class="form-label">Comentario</label>
                <textarea class="form-control" id="comentario" name="comentario" rows="3"></textarea>
            </div>

            {{-- Botón de Envío --}}
            <button type="submit" class="btn btn-primary">Enviar Valoración</button>
        </form>
    </main>
@endsection
