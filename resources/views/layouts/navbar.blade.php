<nav class="navbar navbar-expand-lg navbar-dark header">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <picture><img src="/img/logo.png" alt="Logo" class="logo" /></picture>
            <h1 class="nombre-empresa m-0 pl-3">Finca Monterruiz</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Inicio</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ Request::routeIs('pages.catalogo') || Request::routeIs('pages.gallery') ? 'experiencia-activa' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Experiencias
                    </a>

                    <ul class="dropdown-menu border-0">
                        <li>
                            <a class="dropdown-item {{ Request::routeIs('pages.catalogo') ? 'active' : '' }}" href="{{ route('pages.catalogo') }}">Catálogo y reserva</a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ Request::routeIs('pages.gallery') ? 'active' : '' }}" href="{{ route('pages.gallery') }}">Galeria</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('pages.about-us') ? 'active' : '' }}" href="{{ route('pages.about-us') }}">Sobre nosotros</a>
                </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('pages.form-contact') ? 'active' : '' }}" href="{{ route('pages.form-contact') }}">Contacto</a>
            </li>
            </ul>
            @if (auth()->check())
                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{ auth()->user()->nombre }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end header border-0">
                            <?php
                            if (Auth::user()->es_admin) { ?>
                            <li><a class="dropdown-item" href={{ route('admin.index') }}>Panel Admin</a></li>
                            <?php } ?>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Mi Perfil</a></li>
                            <?php
                            if (!(Auth::user()->es_admin)) { ?>
                                <li><a class="dropdown-item" href={{ route('dashboard') }}>Dashboard</a></li>
                                <?php } ?>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <li><a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();this.closest('form').submit();">Cerrar
                                        sesión</a></li>
                            </form>
                        </ul>
                    </li>
            @else
            <li class="nav-item">
                <a href="{{ route('login') }}" class="nav-link btn">Iniciar sesión</a>
            </li>
            @endif
        </div>
    </div>
</nav>
