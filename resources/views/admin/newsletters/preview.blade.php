@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="mt-4">Vista Previa</h1>
        <hr>

        <!-- Título del Newsletter -->
        <h3>{{ $newsletter->titulo }}</h3>

        <!-- Contenido del Newsletter -->
        <div class="newsletter-content">
            {!! $newsletter->contenido !!}
        </div>

        @if ($newsletter->imagen_url)
            <div style="text-align: center;">
                <img src="{{ asset($newsletter->imagen_url) }}" style="max-width: 70%; height: auto; border-radius: 8px;">
            </div>
        @endif

    </div>
@endsection
