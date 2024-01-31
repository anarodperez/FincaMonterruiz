@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="mt-4">Vista Previa del Newsletter</h1>
        <hr>

        <!-- Título del Newsletter -->
        <h3>{{ $newsletter->titulo }}</h3>

        <!-- Contenido del Newsletter -->
        <div class="newsletter-content">
            {!! $newsletter->contenido !!}
        </div>

        <!-- Imagen del Newsletter -->
        <div style="text-align: center;"> <!-- Centrar la imagen -->
            <img src="{{ asset($newsletter->imagen_url) }}" style="max-width: 70%; height: auto; border-radius: 8px;">
        </div>
    </div>
@endsection
