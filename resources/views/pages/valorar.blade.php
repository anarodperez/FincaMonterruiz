@extends('layouts.guest')

@section('title', 'Valorar Actividad')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/valorar.css') }}">
@endsection

@section('content')
    <main class="container py-5">
        <div class="valoracion-container">
            <div class="valoracion-header">
                <h1>Valorar Actividad</h1>
                <h2>{{ $actividad->nombre }}</h2>
            </div>

            <form action="{{ route('valoraciones.store') }}" method="POST">
                @csrf
                <input type="hidden" name="actividad_id" value="{{ $actividad->id }}">

                <div class="valoracion-estrellas">

                    @for ($i = 5; $i >= 1; $i--)
                        <input type="radio" name="puntuacion" id="estrella{{ $i }}"
                            value="{{ $i }}">
                        <label for="estrella{{ $i }}">★</label>
                    @endfor
                    <p style="margin-right: 1.5vw">Calificación: </p>
                </div>


                <div class="comentario-section">
                    <label for="comentario" class="form-label">Comentario</label>
                    <textarea class="form-control" id="comentario" name="comentario"></textarea>
                </div>

                <div class="botones-valoracion">
                    <button type="submit" class="btn-enviar-valoracion">Enviar Valoración</button>
                    <a href="{{ route('dashboard') }}" class="btn-cancelar-valoracion">Cancelar</a>
                </div>
            </form>
        </div>
    </main>

@endsection
