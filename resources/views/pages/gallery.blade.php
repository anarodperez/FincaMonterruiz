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
                        de nuestros visitantes mientras exploran las delicias enoturísticas en Finca Monterruiz!
                    </p>
                </div>
                <div class="image">
                    <img src="storage/img/viña.jpeg" alt="Imagen de la viña" />
                </div>
            </div>
        </div>
        <div class="container">
            <div class="box">
                <img src="storage/img/img3.jpg" alt="Imagen de la galería" />
            </div>
            <div class="box">
                <img src="storage/img/img4.jpg"  alt="Imagen de la galería"/>
            </div>
            <div class="box">
                <img src="storage/img/img5.jpg" alt="Imagen de la galería" />
            </div>
            <div class="box">
                <img src="storage/img/img6.jpg" alt="Imagen de la galería"/>
            </div>
            <div class="box">
                <img src="storage/img/img7.jpg" alt="Imagen de la galería" />
            </div>
            <div class="box">
                <img src="storage/img/img8.jpg" alt="Imagen de la galería" />
            </div>
            <div class="box">
                <img src="storage/img/img9.jpg" alt="Imagen de la galería" />
            </div>
            <div class="box">
                <img src="storage/img/img10.jpg"alt="Imagen de la galería"/>
            </div>
            <div class="box">
                <img src="storage/img/img11.jpg" alt="Imagen de la galería"/>
            </div>
            <div class="box">
                <img src="storage/img/img12.jpg" alt="Imagen de la galería" />
            </div>
            <div class="box">
                <img src="storage/img/img13.jpg" alt="Imagen de la galería"/>
            </div>
            <div class="box">
                <img src="storage/img/img14.jpg" alt="Imagen de la galería" />
            </div>
            <div class="box">
                <img src="storage/img/img19.jpg" alt="Imagen de la galería" />
            </div>
            <div class="box">
                <img src="storage/img/img16.jpg" alt="Imagen de la galería"/>
            </div>
            <div class="box">
                <img src="storage/img/img17.jpg" alt="Imagen de la galería" />
            </div>
            <div class="box">
                <img src="storage/img/img18.jpg" alt="Imagen de la galería"/>
            </div>
        </div>
    </main>
@endsection
