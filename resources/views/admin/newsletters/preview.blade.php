@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="mt-4">Vista Previa del Newsletter</h1>
        <hr>

        <!-- Título del Newsletter -->
        <h3 >{{ $newsletter->titulo }}</h3>

        <!-- Contenido del Newsletter -->
        <div class="newsletter-content">
            {!! $newsletter->contenido !!}
        </div>

                <!-- Contenido del Newsletter -->
                <div >
                    <img src="{{ asset($newsletter->imagen_url ) }}">

                </div>
    </div>
@endsection
