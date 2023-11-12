@extends('layouts.guest')
@section('title')
    Galeria de Imagenes
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/gallery.css') }}">
@endsection

@section('content')
    <main>
        <div class="container-fluid">
            <div class="cabecera">
                <div class="text">
                    <h1><strong> Nuestros visitantes en Acción </strong> <i class="fa-solid fa-camera-retro"
                            style="color: #3e0a0b;"></i></h1>
                    <p>
                        ¡Prepárense para un recorrido visual que captura la diversión, la emoción y los momentos memorables
                        de nuestros visitantes mientras exploran las delicias enoturísticas en Finca Monterruiz! <br>
                        Sumérgete en estas imágenes llenas de sonrisas, copas elevadas y risas compartidas.
                    </p>
                </div>
                <div class="image">
                    <img src="/imagenes/img36.jpg" />
                </div>
            </div>
        </div>
        <div class="container">
            <div class="box">
                <img src="stotage/img/img3.jpg" />
            </div>
            <div class="box">
                <img src="/stotage/img/img4.jpg" />
            </div>
            <div class="box">
                <img src="/stotage/img/img5.jpg" />
            </div>
            <div class="box">
                <img src="/imagenes/img21.jpg" />
            </div>
            <div class="box">
                <img src="/imagenes/img22.jpg" />
            </div>
            <div class="box">
                <img src="/imagenes/img23.jpg" />
            </div>
            <div class="box">
                <img src="/imagenes/img24.jpg" />
            </div>
            <div class="box">
                <img src="/imagenes/img25.jpg" />
            </div>
            <div class="box">
                <img src="/imagenes/img26.jpg" />
            </div>
            <div class="box">
                <img src="/imagenes/img27.jpg" />
            </div>
            <div class="box">
                <img src="/imagenes/img28.jpg" />
            </div>
            <div class="box">
                <img src="/imagenes/img30.jpg" />
            </div>
            <div class="box">
                <img src="/imagenes/img31.jpg" />
            </div>
            <div class="box">
                <img src="/imagenes/img32.jpg" />
            </div>
            <div class="box">
                <img src="/imagenes/img33.jpg" />
            </div>
            <div class="box">
                <img src="/imagenes/img34.jpg" />
            </div>
        </div>
    </main>
@endsection
