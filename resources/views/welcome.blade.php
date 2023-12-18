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

    <!-- lazily load the Swiper CSS file -->
    <link rel="preload" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">

    <!-- lazily load the Swiper JS file -->
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
                    <!-- Additional required wrapper -->
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


            <section class="bg-light">
                <div class="container py-5">
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <div class="lc-block text-center text-md-end mb-5">
                                <div editable="rich">
                                    <h1 class="display-5 fw-bold">Lo que Nuestros Visitantes Dicen</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-4 mb-4">
                            <div class="card border-0 shadow">
                                <div class="card-body py-4">
                                    <div class="d-flex">
                                        <img style="width:48px;height:48px"
                                            src="https://images.unsplash.com/photo-1527980965255-d3b416303d12?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;ixid=MnwzNzg0fDB8MXxzZWFyY2h8M3x8YXZhdGFyfGVufDB8Mnx8fDE2Mzg4OTExNTE&amp;ixlib=rb-1.2.1&amp;q=80&amp;w=1080&amp;h=1080"
                                            alt="Photo by Nicolas Horn" class="rounded-2 shadow"
                                            srcset="https://images.unsplash.com/photo-1527980965255-d3b416303d12?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;ixid=MnwzNzg0fDB8MXxzZWFyY2h8M3x8YXZhdGFyfGVufDB8Mnx8fDE2Mzg4OTExNTE&amp;ixlib=rb-1.2.1&amp;q=80&amp;w=1080&amp;h=1080 1080w, https://images.unsplash.com/photo-1527980965255-d3b416303d12??crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;ixid=MnwzNzg0fDB8MXxzZWFyY2h8M3x8YXZhdGFyfGVufDB8Mnx8fDE2Mzg4OTExNTE&amp;ixlib=rb-1.2.1&amp;q=80&amp;w=150 150w, https://images.unsplash.com/photo-1527980965255-d3b416303d12??crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;ixid=MnwzNzg0fDB8MXxzZWFyY2h8M3x8YXZhdGFyfGVufDB8Mnx8fDE2Mzg4OTExNTE&amp;ixlib=rb-1.2.1&amp;q=80&amp;w=300 300w, https://images.unsplash.com/photo-1527980965255-d3b416303d12??crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;ixid=MnwzNzg0fDB8MXxzZWFyY2h8M3x8YXZhdGFyfGVufDB8Mnx8fDE2Mzg4OTExNTE&amp;ixlib=rb-1.2.1&amp;q=80&amp;w=768 768w, https://images.unsplash.com/photo-1527980965255-d3b416303d12??crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;ixid=MnwzNzg0fDB8MXxzZWFyY2h8M3x8YXZhdGFyfGVufDB8Mnx8fDE2Mzg4OTExNTE&amp;ixlib=rb-1.2.1&amp;q=80&amp;w=1024 1024w"
                                            sizes="(max-width: 1080px) 100vw, 1080px" width="1080" height="1080">
                                        <div class="ps-2">
                                            <h4 editable="inline" class="rfs-7 ms-2">Mathew Glock</h4>
                                        </div>
                                    </div>
                                    <div class="lc-block mt-4 text-muted">
                                        <div editable="rich">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="rating mt-3 text-success">
                                        <div class="lc-block"> <svg width="1em" height="1em" viewBox="0 0 16 16"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                lc-helper="svg-icon">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                                </path>
                                            </svg>
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg" lc-helper="svg-icon">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                                </path>
                                            </svg>
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg" lc-helper="svg-icon">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                                </path>
                                            </svg>
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg" lc-helper="svg-icon">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                                </path>
                                            </svg> <svg width="1em" height="1em" viewBox="0 0 16 16"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                lc-helper="svg-icon">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-4 mb-4">
                            <div class="card border-0 shadow">
                                <div class="card-body py-4">
                                    <div class="d-flex">
                                        <img style="width:48px;height:48px"
                                            src="https://images.unsplash.com/photo-1628157588553-5eeea00af15c?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;ixid=MnwzNzg0fDB8MXxzZWFyY2h8NHx8YXZhdGFyfGVufDB8Mnx8fDE2Mzg4OTExNTE&amp;ixlib=rb-1.2.1&amp;q=80&amp;w=1080&amp;h=1080"
                                            alt="Photo by Leio McLaren" class="rounded-2 shadow"
                                            srcset="https://images.unsplash.com/photo-1628157588553-5eeea00af15c?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;ixid=MnwzNzg0fDB8MXxzZWFyY2h8NHx8YXZhdGFyfGVufDB8Mnx8fDE2Mzg4OTExNTE&amp;ixlib=rb-1.2.1&amp;q=80&amp;w=1080&amp;h=1080 1080w, https://images.unsplash.com/photo-1628157588553-5eeea00af15c??crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;ixid=MnwzNzg0fDB8MXxzZWFyY2h8NHx8YXZhdGFyfGVufDB8Mnx8fDE2Mzg4OTExNTE&amp;ixlib=rb-1.2.1&amp;q=80&amp;w=150 150w, https://images.unsplash.com/photo-1628157588553-5eeea00af15c??crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;ixid=MnwzNzg0fDB8MXxzZWFyY2h8NHx8YXZhdGFyfGVufDB8Mnx8fDE2Mzg4OTExNTE&amp;ixlib=rb-1.2.1&amp;q=80&amp;w=300 300w, https://images.unsplash.com/photo-1628157588553-5eeea00af15c??crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;ixid=MnwzNzg0fDB8MXxzZWFyY2h8NHx8YXZhdGFyfGVufDB8Mnx8fDE2Mzg4OTExNTE&amp;ixlib=rb-1.2.1&amp;q=80&amp;w=768 768w, https://images.unsplash.com/photo-1628157588553-5eeea00af15c??crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;ixid=MnwzNzg0fDB8MXxzZWFyY2h8NHx8YXZhdGFyfGVufDB8Mnx8fDE2Mzg4OTExNTE&amp;ixlib=rb-1.2.1&amp;q=80&amp;w=1024 1024w"
                                            sizes="(max-width: 1080px) 100vw, 1080px" width="1080" height="1080">
                                        <div class="ps-2">
                                            <h4 editable="inline" class="rfs-7 ms-2">Tahmid William&nbsp;<p></p>
                                                <p></p>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="lc-block mt-4 text-muted">
                                        <div editable="rich">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc et metus id
                                                ligula malesuada placerat sit amet quis enim. Aliquam erat volutpat.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="rating mt-3 text-success">
                                        <div class="lc-block"> <svg width="1em" height="1em" viewBox="0 0 16 16"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                lc-helper="svg-icon">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                                </path>
                                            </svg>
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg" lc-helper="svg-icon">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                                </path>
                                            </svg>
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg" lc-helper="svg-icon">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                                </path>
                                            </svg>
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg" lc-helper="svg-icon">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                                </path>
                                            </svg> <svg width="1em" height="1em" viewBox="0 0 16 16"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                lc-helper="svg-icon">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-4 mb-4">
                            <div class="card border-0 shadow">
                                <div class="card-body py-4">
                                    <div class="d-flex">
                                        <img style="width:48px;height:48px"
                                            src="https://images.unsplash.com/photo-1595152452543-e5fc28ebc2b8?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;ixid=MnwzNzg0fDB8MXxzZWFyY2h8MTh8fGZhY2V8ZW58MHwyfHx8MTYzODg5MTA3MA&amp;ixlib=rb-1.2.1&amp;q=80&amp;w=1080&amp;h=1080"
                                            alt="Photo by Amir Seilsepour" class="rounded-2 shadow"
                                            srcset="https://images.unsplash.com/photo-1595152452543-e5fc28ebc2b8?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;ixid=MnwzNzg0fDB8MXxzZWFyY2h8MTh8fGZhY2V8ZW58MHwyfHx8MTYzODg5MTA3MA&amp;ixlib=rb-1.2.1&amp;q=80&amp;w=1080&amp;h=1080 1080w, https://images.unsplash.com/photo-1595152452543-e5fc28ebc2b8??crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;ixid=MnwzNzg0fDB8MXxzZWFyY2h8MTh8fGZhY2V8ZW58MHwyfHx8MTYzODg5MTA3MA&amp;ixlib=rb-1.2.1&amp;q=80&amp;w=150 150w, https://images.unsplash.com/photo-1595152452543-e5fc28ebc2b8??crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;ixid=MnwzNzg0fDB8MXxzZWFyY2h8MTh8fGZhY2V8ZW58MHwyfHx8MTYzODg5MTA3MA&amp;ixlib=rb-1.2.1&amp;q=80&amp;w=300 300w, https://images.unsplash.com/photo-1595152452543-e5fc28ebc2b8??crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;ixid=MnwzNzg0fDB8MXxzZWFyY2h8MTh8fGZhY2V8ZW58MHwyfHx8MTYzODg5MTA3MA&amp;ixlib=rb-1.2.1&amp;q=80&amp;w=768 768w, https://images.unsplash.com/photo-1595152452543-e5fc28ebc2b8??crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;ixid=MnwzNzg0fDB8MXxzZWFyY2h8MTh8fGZhY2V8ZW58MHwyfHx8MTYzODg5MTA3MA&amp;ixlib=rb-1.2.1&amp;q=80&amp;w=1024 1024w"
                                            sizes="(max-width: 1080px) 100vw, 1080px" width="1080" height="1080">
                                        <div class="ps-2">
                                            <h4 editable="inline" class="rfs-7 ms-2">Jarvis Ridley&nbsp;<p></p>
                                                <p></p>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="lc-block mt-4 text-muted">
                                        <div editable="rich">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                        </div>
                                    </div>
                                    <div class="rating mt-3 text-success">
                                        <div class="lc-block"> <svg width="1em" height="1em" viewBox="0 0 16 16"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                lc-helper="svg-icon">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                                </path>
                                            </svg>
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg" lc-helper="svg-icon">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                                </path>
                                            </svg>
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg" lc-helper="svg-icon">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                                </path>
                                            </svg>
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg" lc-helper="svg-icon">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                                </path>
                                            </svg> <svg width="1em" height="1em" viewBox="0 0 16 16"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                lc-helper="svg-icon">
                                                <path
                                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
