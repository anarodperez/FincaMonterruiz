@extends('layouts.guest')

@section('title', 'Galería de Imágenes')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/catalogo.css') }}">
@endsection

@section('content')
    <main>
        <!-- Encabezado -->
        <header class="jumbotron">
            <div class="container text-center">
                <h1>Descubre Nuestras Actividades</h1>
                <p>Explora una variedad de actividades emocionantes para todas las edades.</p>
                <a href="#" class="btn btn-primary btn-lg">Ver Actividades</a>
            </div>
        </header>

        <!-- Catálogo de Actividades -->
        <section class="container my-5">
            <div class="row">
                @foreach ($actividades as $actividad)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="{{ asset('images/' . $actividad->imagen) }}" class="card-img-top" alt="{{ $actividad->nombre }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $actividad->nombre }}</h5>
                                <p class="card-text">{{ $actividad->descripcion }}</p>
                                <a href="#" class="btn btn-primary">Ver Detalles</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>
@endsection
