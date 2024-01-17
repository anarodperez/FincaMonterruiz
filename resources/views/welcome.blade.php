@extends('layouts.guest')
@section('title')
    Inicio
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" id="picostrap-styles-css" href="https://cdn.livecanvas.com/media/css/library/bundle.css"
        media="all">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preload" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <script defer="defer" src="https://unpkg.com/swiper@8/swiper-bundle.min.js" onload="initializeSwiperRANDOMID();">
    </script>
    <script>
        function initializeSwiperRANDOMID() {
            const swiper = new Swiper(".mySwiper-RANDOMID", {
                slidesPerView: 1,
                grabCursor: true,
                spaceBetween: 30,

                pagination: {
                    el: ".swiper-pagination",
                    dynamicBullets: true,
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2,
                    },
                    992: {
                        slidesPerView: 3,
                    },
                },
            });
        }
    </script>
    <style>
        .carousel-item {
            height: 600px;
        }

        .mySwiper-RANDOMID .card {
            max-width: 21rem
        }

        .custom-pagination .swiper-pagination-bullet {
            background: #5c7c64;
        }
    </style>
@endsection
@section('content')
    <main>
        <div class="container-fluid">
            <section>
                <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active"
                            style="background:url({{ asset('storage/img/img6.jpg') }}) center / cover no-repeat;"></div>
                        <div class="carousel-item"
                            style="background:url('{{ asset('storage/img/viña.jpeg') }}') center / cover no-repeat;"></div>
                        <div class="carousel-item"
                            style="background:url('{{ asset('storage/img/viña2.jpeg') }}') center / cover no-repeat;"></div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </section>

            <section class="bg-light">
                <div class="container text-center py-5 mb-4 ">
                    <div class="p-5 mb-4 lc-block">
                        <div class="lc-block mb-4">
                            <div editable="rich">
                                <h2 class="display-1 fw-bold">Vive Experiencias Únicas en Finca Monterruiz</h2>
                            </div>
                        </div>
                        <div class="lc-block mb-5">
                            <div editable="rich">
                                <p class="lead">
                                    Arraigados en el pago de viñas de Añina desde 1947, honramos con amor y respeto nuestra
                                    tradición vitivinícola a lo largo de generaciones. <br>Buscamos compartir la riqueza
                                    única
                                    de nuestra viticultura para ofrecer a nuestros visitantes una experiencia enriquecedora,
                                    donde descubrirán la historia, pasión y artesanía detrás de nuestros vinos.&nbsp;
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="container py-6"><!-- Slider main container -->
                <div class="swiper mySwiper-RANDOMID">
                    <div class="swiper-wrapper"><!-- Slides -->
                        @foreach ($actividades as $actividad)
                            <div class="swiper-slide h-100">
                                <div class="card shadow mx-auto">
                                    <div class="card-body">
                                        <div class="lc-block">
                                            <img class="img-fluid" src="{{ asset($actividad->imagen) }}" srcset=""
                                                sizes="" alt="" loading="lazy" width="" height="">
                                        </div>
                                        <div class="card-body">
                                            <div class="lc-block mb-3">
                                                <div editable="rich">

                                                    <h2 class="h5">{{ $actividad->nombre }}</h2>

                                                    <p>{{ $actividad->descripcion }}</p>
                                                </div>
                                            </div>
                                            <div class="lc-block">
                                                <button class="custom-btn boton">RESERVAR</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="swiper-pagination position-relative pt-5 bottom-0 boton custom-pagination"></div><br>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="lc-block text-center">
                                <a href="#" class="btn btn-primary">MÁS ACTIVIDADES</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <section class="bg-light valoraciones-section">
                <div class="container py-5">
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <h1 class="display-5 fw-bold">Lo que Nuestros Visitantes Opinan</h1>
                        </div>
                    </div>

                    <div id="valoracionesCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($ultimasValoraciones as $index => $valoracion)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <div class="d-flex justify-content-center">
                                        <div class="card valoracion-card" style="width: 18rem;">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $valoracion->actividad->nombre }}</h5>
                                                <p class="card-text">{{ $valoracion->comentario }}</p>
                                                <div class="rating">
                                                    @for ($i = 0; $i < $valoracion->puntuacion; $i++)
                                                        <i class="bi bi-star-fill"></i>
                                                    @endfor
                                                </div>
                                                <p class="card-text"><small class="text-muted">{{ $valoracion->created_at->format('d M Y') }}</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#valoracionesCarousel" role="button" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#valoracionesCarousel" role="button" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </a>
                    </div>
                </div>
            </section>

        </div>
        </section>
        <div class="newsletter">
            <h2>Suscríbete a nuestro boletín informativo</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <p>Recibe las últimas noticias y ofertas especiales en tu bandeja de entrada.</p>
            <form action="#" method="post">
                @csrf
                <input type="email" name="email" placeholder="Ingresa tu correo electrónico" required>
                <button class="custom-btn boton" type="submit">Suscribirse</button>
            </form>
        </div>
    </main>
@endsection
