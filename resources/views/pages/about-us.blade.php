@extends('layouts.guest')
@section('title')
    Sobre nosotros
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/about-us.css') }}">
@endsection
@section('content')
    <main>
        <div class="container" style="max-width: 1200px">
            <div class="row">
                <div class="col-xs-12" style="text-align: center">
                    <h2>– SOBRE NOSOTROS –</h2>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-6">
                    <div class="info-text">
                        <p>
                            Finca Monterruiz es una empresa que nace del deseo de enseñar y
                            promulgar la viticultura que se ha ido desarrollando durante
                            muchos años en el marco de Jerez. <br /><br />
                            Contamos con más de 75 años de experiencia en el cultivo de la
                            viña, lo que nos permite ofrecer a los visitantes una
                            experiencia única y enriquecedora.
                        </p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-6">
                    <div class="col-xs-12">
                        <figure class="contenido">
                            <a href="#"><img src="/img/img5.jpg" alt="Niña vendimiando" /></a>
                        </figure>
                    </div>
                </div>
                <div style="clear: both"></div>
                <hr />
                <div class="col-xs-12" style="text-align: center">
                    <h2>– FILOSOFIA –</h2>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-sm-push-4 col-md-6 col-md-push-6">
                        <div class="info-text right">
                            <p>
                                Buscamos crear experiencias únicas en torno al viñedo, más
                                allá de la típica visita a bodega y cata de vino. Nuestro
                                objetivo es emocionar a los visitantes y hacerlos partícipes
                                activos de la historia y cultura vitícola del Marco de Jerez.
                                <br /><br />
                                <strong>
                                    ¡Cada cepa tiene una historia que contar, ven y descúbrela!
                                </strong>
                            </p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-sm-pull-8 col-md-6 col-md-pull-6">
                        <div class="col-xs-12 col-sm-12">
                            <figure class="contenido">
                                <a href="#"><img src="/img/img4.jpg" alt="Perro en la viña" /></a>
                            </figure>
                        </div>
                    </div>
                </div>
                <div style="clear: both"></div>
                <hr />
            </div>
        </div>
    </main>
@endsection
