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
    <script defer="defer" src="https://unpkg.com/swiper@8/swiper-bundle.min.js" onload="initializeSwiperRANDOMID();">
    </script>
    <script>
        function initializeSwiperRANDOMID() {
            const swiper = new Swiper(".mySwiper-RANDOMID", {
                slidesPerView: 1,
                grabCursor: true,
                spaceBetween: 30,
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
@endsection
@section('content')
    <main>
        <div class="container-fluid">
            <section>
                <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner first ">
                        <div class="carousel-item active"
                            style="background:url({{ asset('/img/img6.jpg') }}) center / cover no-repeat;"></div>
                        <div class="carousel-item"
                            style="background:url('{{ asset('/img/viña.jpeg') }}') center / cover no-repeat;"></div>
                        <div class="carousel-item"
                            style="background:url('{{ asset('/img/viña2.jpeg') }}') center / cover no-repeat;"></div>
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

            <section class="bg-light animate__animated animate__backInLeft ">
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

             <!-- Sección de Bienvenida -->
             <section class="bg-light animate__animated animate__backInRight  ">
                <div class="container text-center py-5 mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="display-4 mb-4">Explora Nuestros Viñedos</h3>
                            <p class="lead">Descubre la belleza de nuestros viñedos y la serenidad que ofrecen. Nuestra pasión por el cultivo sostenible de la vid nos permite apreciar la naturaleza en su forma más pura.</p>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="{{ asset('/img/img2.jpeg') }}" alt="Viñedos" class="img-fluid rounded">
                                </div>
                                <div class="col-md-6">
                                    <img src="{{ asset('/img/img3.jpeg') }}" alt="Viñedos" class="img-fluid rounded">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>



            {{-- SECCIÓN DE ACTIVIDADES --}}
            <section class="bg-light animate__animated animate__backInLeft ">
                <div class="container py-6">
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <h1 class="display-5 fw-bold mb-4">Descubre Nuestras Experiencias</h1>
                        </div>
                    </div>
                    <div class="swiper mySwiper-RANDOMID">
                        <div class="swiper-wrapper">
                            @foreach ($actividades as $actividad)
                                <div class="swiper-slide h-100">
                                    <div class="card shadow mx-auto" style="border-radius: 20px;">
                                        <div class="card-body">
                                            <div class="lc-block">
                                                <img class="card-img-top img-fluid" src="{{ asset($actividad->imagen) }}"
                                                    srcset="" sizes="" alt="" loading="lazy"
                                                    width="" height="">
                                            </div>
                                            <div class="card-body">
                                                <h2 class="card-title h5">{{ $actividad->nombre }}</h2>
                                                <p class="card-text">{{ $actividad->descripcion }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="lc-block text-center">
                                    <a href="/catalogo" class="custom-btn boton">RESERVAR</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- SECCIÓN VALORACIONES --}}
            <section class="bg-light valoraciones-section  animate__animated animate__backInRight">
                <div class="container-fluid py-6" style=" max-width: 90vw; margin: 0 auto; ">
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <h1 class="display-5 fw-bold mb-4">Lo que Nuestros Visitantes Opinan</h1>
                        </div>
                    </div>
                    <div id="valoracionesCarousel" class="carousel slide" data-bs-ride="carousel">
                        @if ($ultimasValoraciones->count() > 0)
                            <div class="carousel-inner">
                                @foreach ($ultimasValoraciones->chunk(3) as $valoracionChunk)
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                        <div class="d-flex justify-content-center">
                                            @foreach ($valoracionChunk as $valoracion)
                                                <div class="card valoracion-card mx-5" style="max-width:24rem;">
                                                    <div class="card-body">
                                                        <h5 class="card-title">
                                                            {{ $valoracion->actividad->nombre ?? 'Actividad Desconocida' }}
                                                        </h5>
                                                        <p class="card-text">{{ $valoracion->comentario }}</p>
                                                        <div class="rating">
                                                            @for ($i = 0; $i < $valoracion->puntuacion; $i++)
                                                                <i class="bi bi-star-fill"></i>
                                                            @endfor
                                                        </div>
                                                        <p class="card-text"><small
                                                                class="text-muted">{{ $valoracion->created_at->format('d M Y') }}</small>
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#valoracionesCarousel" role="button"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#valoracionesCarousel" role="button"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </a>
                        @else
                            <p class="text-center">Aún no hay valoraciones.</p>
                        @endif
                    </div>
                </div>
            </section>

            <div class="newsletter">
                <h2>Suscríbete a nuestro boletín informativo</h2>
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <span class="closebtn" onclick="closeAlert(this)">&times;</span>
                        <ul style="list-style-type: none; padding: 0; margin: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div id="error-container" class="alert alert-danger alert-dismissible fade show" style="display: none;">
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <p>Recibe las últimas noticias y ofertas especiales en tu bandeja de entrada.</p>
                <form id="subscription-form" action="{{ route('suscribirse') }}" method="post">
                    @csrf
                    <input type="email" id="email" name="email" placeholder="Ingresa tu correo electrónico"
                        required class="text-center">

                    <button class="custom-btn boton" type="submit">Suscribirse</button>
                </form>
            </div>
        </div>
    </main>

    <script>
        function closeAlert(element) {
            element.parentElement.style.display = 'none';
        }

        document.getElementById('subscription-form').onsubmit = function(event) {
            var email = document.getElementById('email').value;
            var errorContainer = document.getElementById('error-container');

            if (!validateEmail(email)) {
                event.preventDefault();
                errorContainer.textContent = 'Por favor ingresa un correo electrónico válido.';
                errorContainer.style.display = 'block';
            } else {
                errorContainer.style.display = 'none';
            }
        };

        function validateEmail(email) {
            var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
    </script>
@endsection
