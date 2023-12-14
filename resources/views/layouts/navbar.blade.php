<nav class="navbar navbar-expand-lg navbar-dark header">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <picture><img src="" alt="Logo" class="logo" /></picture>
            <h1 class="nombre-empresa m-0 pl-3">Finca Monterruiz</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('index') }}">Inicio</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Experiencias
                    </a>
                    <ul class="dropdown-menu border-0">
                        <li>
                            <a class="dropdown-item" href="/catalogo">Catalogo y reserva</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Galeria</a>
                        </li>
                    </ul>
                </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Sobre nosotros</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Contáctanos</a>
            </li>
            </ul>
            @if (auth()->check())
                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{ auth()->user()->nombre }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end header">
                            <?php
                            if (Auth::user()->es_admin) { ?>
                            <li><a class="dropdown-item" href="#">Portal Administrador</a></li>
                            <?php } ?>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Perfil</a></li>
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
